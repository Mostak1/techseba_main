@php
    $pageSeoTitle = $seoTitle
        ?? $meta_title
        ?? ($seo_setting->seo_title ?? null)
        ?? config('techseba_seo.pages.home.title');

    $pageSeoDescription = $seoDescription
        ?? $meta_description
        ?? ($seo_setting->seo_description ?? null)
        ?? config('techseba_seo.pages.home.description');

    $pageSeoTitle = techseba_seo_title($pageSeoTitle);
    $pageSeoDescription = techseba_seo_description($pageSeoDescription);
    $pageCanonical = techseba_canonical_url($canonicalUrl ?? null);
    $pageImage = isset($seoImage) ? asset($seoImage) : asset($general_setting->logo ?? '');
    $organization = config('techseba_seo.organization');
@endphp

@if(! trim($__env->yieldContent('title')))
    <title>{{ $pageSeoTitle }}</title>
    <meta name="title" content="{{ $pageSeoTitle }}">
    <meta name="description" content="{{ $pageSeoDescription }}">
@endif

<link rel="canonical" href="{{ $pageCanonical }}">
<meta name="robots" content="index,follow">
<meta property="og:type" content="website">
<meta property="og:site_name" content="{{ $organization['name'] ?? config('app.name') }}">
<meta property="og:title" content="{{ $pageSeoTitle }}">
<meta property="og:description" content="{{ $pageSeoDescription }}">
<meta property="og:url" content="{{ $pageCanonical }}">
@if($pageImage)
    <meta property="og:image" content="{{ $pageImage }}">
@endif
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $pageSeoTitle }}">
<meta name="twitter:description" content="{{ $pageSeoDescription }}">
@if($pageImage)
    <meta name="twitter:image" content="{{ $pageImage }}">
@endif

<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'Organization',
    'name' => $organization['name'] ?? config('app.name'),
    'url' => $organization['url'] ?? url('/'),
    'email' => $organization['email'] ?? null,
    'telephone' => $organization['telephone'] ?? null,
    'address' => [
        '@type' => 'PostalAddress',
        'addressLocality' => 'Dhaka',
        'addressCountry' => 'BD',
        'streetAddress' => $organization['address'] ?? null,
    ],
    'areaServed' => $organization['area_served'] ?? ['Bangladesh'],
    'sameAs' => $organization['same_as'] ?? [],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>

<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'LocalBusiness',
    'name' => $organization['name'] ?? config('app.name'),
    'url' => $organization['url'] ?? url('/'),
    'email' => $organization['email'] ?? null,
    'telephone' => $organization['telephone'] ?? null,
    'address' => [
        '@type' => 'PostalAddress',
        'addressLocality' => 'Dhaka',
        'addressCountry' => 'BD',
        'streetAddress' => $organization['address'] ?? null,
    ],
    'areaServed' => $organization['area_served'] ?? ['Bangladesh'],
    'priceRange' => '$$',
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>

@stack('schema')
