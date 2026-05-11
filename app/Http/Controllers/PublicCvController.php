<?php

namespace App\Http\Controllers;

use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

class PublicCvController extends Controller
{
    private array $reservedUsernames = [
        'login',
        'register',
        'admin',
        'user',
        'dashboard',
        'about',
        'contact',
        'blog',
        'api',
        'password',
        'logout',
    ];

    private array $relations = [
        'user',
        'template',
        'portfolioTemplate',
        'employments',
        'academics',
        'trainings',
        'professionalQualifications',
        'skills',
        'languages',
        'references',
        'projects',
    ];

    public function show(string $username)
    {
        $cv = $this->publicCv($username);

        return view($this->portfolioViewPath($cv), [
            'cv' => $cv,
            'username' => $username,
            'cvUrl' => route('cv.public', $username),
            'printUrl' => route('public.cv.print', $username),
            'pdfUrl' => null,
            'printEnabled' => $cv->public_print_enabled,
            'pdfEnabled' => false,
        ]);
    }

    public function cv(string $username)
    {
        $cv = $this->publicCv($username);

        return $this->renderCv($cv, [
            'showActions' => true,
            'printEnabled' => $cv->public_print_enabled,
            'pdfEnabled' => false,
            'printUrl' => route('public.cv.print', $username),
            'pdfUrl' => null,
            'printMode' => false,
            'forPdf' => false,
        ]);
    }

    public function showById(int $id)
    {
        $user = User::findOrFail($id);
        $cv = $user->userCv()->with($this->relations)->first();

        abort_unless($cv && $cv->is_public, 404);

        return $this->renderCv($cv, [
            'showActions' => true,
            'printEnabled' => $cv->public_print_enabled,
            'pdfEnabled' => false,
            'printUrl' => route('public.cv.print', $user->username ?: 'cv/id/'.$id),
            'pdfUrl' => null,
            'printMode' => false,
            'forPdf' => false,
        ]);
    }

    public function print(string $username)
    {
        $cv = $this->publicCv($username);

        abort_unless($cv->public_print_enabled, 403);

        return $this->renderCv($cv, [
            'showActions' => true,
            'printEnabled' => true,
            'pdfEnabled' => false,
            'printUrl' => route('public.cv.print', $username),
            'pdfUrl' => null,
            'printMode' => true,
            'forPdf' => false,
        ]);
    }

    public function pdf(string $username)
    {
        // Public visitor PDF download is intentionally disabled for now.
        abort(404);

        $cv = $this->publicCv($username);

        abort_unless($cv->public_pdf_enabled, 403);

        $filename = Str::slug($cv->full_name ?: $username).'-cv.pdf';

        return Pdf::loadView($this->viewPath($cv), $this->viewData($cv, [
            'showActions' => false,
            'printEnabled' => false,
            'pdfEnabled' => false,
            'printUrl' => null,
            'pdfUrl' => null,
            'printMode' => false,
            'forPdf' => true,
        ]))
            ->setOptions($this->pdfOptions(), true)
            ->setPaper('a4', 'portrait')
            ->download($filename);
    }

    private function publicCv(string $username)
    {
        abort_if(in_array(strtolower($username), $this->reservedUsernames, true), 404);

        $user = User::where('username', $username)->firstOrFail();
        $cv = $user->userCv()->with($this->relations)->first();

        abort_unless($cv && $cv->is_public, 404);

        return $cv;
    }

    private function renderCv($cv, array $options)
    {
        return view($this->viewPath($cv), $this->viewData($cv, $options));
    }

    private function viewData($cv, array $options): array
    {
        return array_merge(['cv' => $cv], $options);
    }

    private function viewPath($cv): string
    {
        $viewPath = $cv->template?->view_path ?: 'frontend.cv.templates.bdjobs';

        return view()->exists($viewPath) ? $viewPath : 'frontend.cv.templates.bdjobs';
    }

    private function portfolioViewPath($cv): string
    {
        $viewPath = $cv->portfolioTemplate?->is_active
            ? $cv->portfolioTemplate->view_path
            : 'frontend.cv.portfolio';

        return view()->exists($viewPath) ? $viewPath : 'frontend.cv.portfolio';
    }

    private function pdfOptions(): array
    {
        return [
            'defaultMediaType' => 'screen',
            'defaultFont' => 'DejaVu Sans',
            'dpi' => 96,
            'isHtml5ParserEnabled' => true,
            'chroot' => base_path(),
        ];
    }
}
