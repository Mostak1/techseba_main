<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ProfileDomain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class DomainSettingController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::guard('web')->user();
        $baseDomain = ProfileDomain::getBaseDomain();

        // Auto-provision default subdomain if none exists and user has username
        $subdomain = $user->profileDomains()->where('type', 'subdomain')->first();
        if (!$subdomain && !empty($user->username)) {
            $defaultHost = strtolower($user->username) . '.' . $baseDomain;
            if (!ProfileDomain::where('host', $defaultHost)->exists()) {
                $subdomain = ProfileDomain::create([
                    'user_id' => $user->id,
                    'host' => $defaultHost,
                    'type' => 'subdomain',
                    'is_primary' => true,
                    'is_active' => true,
                    'verified_at' => now(),
                ]);
            }
        }

        $customDomains = $user->profileDomains()->where('type', 'custom_domain')->latest()->get();
        $serverIp = $_SERVER['SERVER_ADDR'] ?? gethostbyname($baseDomain);
        $cv = $user->userCv()->with('portfolioTemplate')->first();
        $portfolioTemplate = $cv?->portfolioTemplate ?? app(\App\Services\TemplateRegistry::class)->effectiveTemplate('portfolio', null);

        return view('user.domain_settings', [
            'user' => $user,
            'subdomain' => $subdomain,
            'customDomains' => $customDomains,
            'baseDomain' => $baseDomain,
            'serverIp' => $serverIp,
            'portfolioTemplate' => $portfolioTemplate,
        ]);
    }

    public function updateSubdomain(Request $request)
    {
        $user = Auth::guard('web')->user();
        $baseDomain = ProfileDomain::getBaseDomain();

        $request->validate([
            'subdomain_prefix' => [
                'required',
                'string',
                'min:3',
                'max:40',
                'regex:/^[a-z0-9][a-z0-9\-]*[a-z0-9]$/i',
            ],
        ], [
            'subdomain_prefix.required' => 'Subdomain prefix is required.',
            'subdomain_prefix.regex' => 'Subdomain can only contain letters, numbers, and hyphens (cannot start or end with a hyphen).',
        ]);

        $prefix = strtolower(trim($request->subdomain_prefix));
        $reserved = [
            'www', 'mail', 'admin', 'api', 'app', 'cpanel', 'webmail', 'localhost',
            'techseba', 'support', 'blog', 'shop', 'dev', 'test', 'demo', 'staging',
            'login', 'register', 'dashboard', 'user', 'cv', 'portfolio'
        ];

        if (in_array($prefix, $reserved, true)) {
            return redirect()->back()->with([
                'message' => "The subdomain prefix '{$prefix}' is reserved and cannot be used.",
                'alert-type' => 'error',
            ]);
        }

        $newHost = $prefix . '.' . $baseDomain;

        $existing = ProfileDomain::where('host', $newHost)
            ->where('user_id', '!=', $user->id)
            ->first();

        if ($existing) {
            return redirect()->back()->with([
                'message' => "The subdomain '{$newHost}' is already taken by another user.",
                'alert-type' => 'error',
            ]);
        }

        $subdomain = $user->profileDomains()->where('type', 'subdomain')->first();
        if ($subdomain) {
            $subdomain->host = $newHost;
            $subdomain->is_active = true;
            $subdomain->verified_at = now();
            $subdomain->save();
        } else {
            $subdomain = ProfileDomain::create([
                'user_id' => $user->id,
                'host' => $newHost,
                'type' => 'subdomain',
                'is_primary' => !$user->profileDomains()->where('is_primary', true)->exists(),
                'is_active' => true,
                'verified_at' => now(),
            ]);
        }

        // Keep username synced with subdomain
        $user->username = Str::slug($prefix);
        $user->save();

        return redirect()->back()->with([
            'message' => "Subdomain updated successfully: {$newHost}",
            'alert-type' => 'success',
        ]);
    }

    public function storeCustomDomain(Request $request)
    {
        $user = Auth::guard('web')->user();
        $baseDomain = ProfileDomain::getBaseDomain();

        $request->validate([
            'custom_domain' => [
                'required',
                'string',
                'min:4',
                'max:120',
            ],
            'user_note' => [
                'nullable',
                'string',
                'max:2000',
            ],
        ]);

        // Clean domain input
        $host = strtolower(trim($request->custom_domain));
        $host = preg_replace('#^https?://#i', '', $host);
        $host = rtrim($host, '/');

        // Basic domain validation
        if (!preg_match('/^(?!:\/\/)([a-zA-Z0-9-_]+\.)+[a-zA-Z]{2,}$/', $host)) {
            return redirect()->back()->with([
                'message' => 'Please enter a valid domain name (e.g. myportfolio.com or cv.mydomain.me).',
                'alert-type' => 'error',
            ]);
        }

        if (str_ends_with($host, $baseDomain)) {
            return redirect()->back()->with([
                'message' => "You cannot add a {$baseDomain} domain here. Use the Subdomain section instead.",
                'alert-type' => 'error',
            ]);
        }

        if (ProfileDomain::where('host', $host)->exists()) {
            return redirect()->back()->with([
                'message' => "The domain '{$host}' is already registered in our system.",
                'alert-type' => 'error',
            ]);
        }

        ProfileDomain::create([
            'user_id' => $user->id,
            'host' => $host,
            'type' => 'custom_domain',
            'status' => ProfileDomain::STATUS_PENDING,
            'user_note' => $request->user_note,
            'admin_message' => null,
            'is_primary' => false,
            'is_active' => false,
            'verified_at' => null,
        ]);

        return redirect()->back()->with([
            'message' => "Custom domain request submitted for '{$host}'. Status is Pending admin review.",
            'alert-type' => 'success',
        ]);
    }

    public function updateUserNote(Request $request, $id)
    {
        $user = Auth::guard('web')->user();
        $domain = $user->profileDomains()->where('type', 'custom_domain')->findOrFail($id);

        $request->validate([
            'user_note' => 'required|string|max:2000',
        ]);

        $domain->user_note = $request->user_note;
        if ($domain->status === ProfileDomain::STATUS_CANCELED) {
            $domain->status = ProfileDomain::STATUS_PENDING;
        }
        $domain->save();

        return redirect()->back()->with([
            'message' => 'Domain information / notes updated successfully for review.',
            'alert-type' => 'success',
        ]);
    }

    public function verifyCustomDomain($id)
    {
        $user = Auth::guard('web')->user();
        $domain = $user->profileDomains()->where('type', 'custom_domain')->findOrFail($id);
        $baseDomain = ProfileDomain::getBaseDomain();

        $host = $domain->host;
        $isPointing = false;

        // Check CNAME records
        $cnameRecords = @dns_get_record($host, DNS_CNAME);
        if ($cnameRecords && is_array($cnameRecords)) {
            foreach ($cnameRecords as $record) {
                if (isset($record['target']) && (
                    strcasecmp($record['target'], $baseDomain) === 0 ||
                    strcasecmp($record['target'], 'www.' . $baseDomain) === 0 ||
                    str_ends_with(strtolower($record['target']), $baseDomain)
                )) {
                    $isPointing = true;
                    break;
                }
            }
        }

        // Check A records if CNAME not matched
        if (!$isPointing) {
            $aRecords = @dns_get_record($host, DNS_A);
            $serverIp = $_SERVER['SERVER_ADDR'] ?? gethostbyname($baseDomain);
            if ($aRecords && is_array($aRecords)) {
                foreach ($aRecords as $record) {
                    if (isset($record['ip']) && $record['ip'] === $serverIp) {
                        $isPointing = true;
                        break;
                    }
                }
            }
        }

        if ($isPointing) {
            $domain->verified_at = now();
            $domain->is_active = true;
            $domain->save();

            return redirect()->back()->with([
                'message' => "Congratulations! Domain '{$host}' has been verified and activated successfully.",
                'alert-type' => 'success',
            ]);
        }

        return redirect()->back()->with([
            'message' => "DNS check failed for '{$host}'. Please verify your DNS CNAME points to '{$baseDomain}'. Note: DNS changes can take a few minutes to hours to propagate.",
            'alert-type' => 'error',
        ]);
    }

    public function setPrimary($id)
    {
        $user = Auth::guard('web')->user();
        $domain = $user->profileDomains()->findOrFail($id);

        if (!$domain->is_active) {
            return redirect()->back()->with([
                'message' => 'Only active/verified domains can be set as primary.',
                'alert-type' => 'error',
            ]);
        }

        $user->profileDomains()->update(['is_primary' => false]);
        $domain->is_primary = true;
        $domain->save();

        return redirect()->back()->with([
            'message' => "Domain '{$domain->host}' is now your primary domain.",
            'alert-type' => 'success',
        ]);
    }

    public function destroyCustomDomain($id)
    {
        $user = Auth::guard('web')->user();
        $domain = $user->profileDomains()->where('type', 'custom_domain')->findOrFail($id);

        $wasPrimary = $domain->is_primary;
        $domain->delete();

        // If it was primary, fallback to subdomain
        if ($wasPrimary) {
            $subdomain = $user->profileDomains()->where('type', 'subdomain')->first();
            if ($subdomain) {
                $subdomain->is_primary = true;
                $subdomain->save();
            }
        }

        return redirect()->back()->with([
            'message' => 'Custom domain removed successfully.',
            'alert-type' => 'success',
        ]);
    }
}
