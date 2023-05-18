<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="robots" content="index, follow, noodp, noydir" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>
        {{ isset($data['title']) ? $data['title'] : 'Unknown'; }}
    </title>
    <meta name="description" content="{{ $data['desc'] }}" />
    <meta name="keywords" content="{{ $data['keywords'] }}" />
    <meta name="author" content="@RobhiTranzad" />
    <meta name="email" content="robhi.sanjaya@gmail.com" />
    <meta name="website" content="{{ $data['url'] }}" />
    <meta name="Version" content="{{ $data['app_version'] }}" />
    <meta name="docsearch:language" content="id">
    <meta name="docsearch:version" content="{{ $data['app_version'] }}">
    <link rel="canonical" href="{{ $data['url'] }}">
    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('/dist/img/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('/dist/img/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/dist/img/favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('/dist/img/favicon/site.webmanifest') }}">
    <link rel="mask-icon" href="{{ asset('/dist/img/favicon/safari-pinned-tab.svg') }}" color="#6CC4A1">
    <meta name="msapplication-TileColor" content="#b91d47">
    <meta name="theme-color" content="#6CC4A1">
    <meta name="application-name" content="{{ $data['app_name'] }}">
    <meta name="msapplication-TileImage" content="{{ $data['thumb'] }}">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="HandheldFriendly" content="true" />
    <!-- Twitter -->
    <meta name="twitter:widgets:csp" content="on">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:url" content="{{ $data['url'] }}">
    <meta name="twitter:site" content="{{ $data['app_name'] }}">
    <meta name="twitter:creator" content="@robhitranzad">
    <meta name="twitter:title" content="{{ $data['title'] }}">
    <meta name="twitter:description" content="{{ $data['desc'] }}">
    <meta name="twitter:image" content="{{ $data['thumb'] }}">
    <!-- Facebook -->
    <meta property="og:locale" content="id_ID" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ $data['url'] }}">
    <meta property="og:title" content="{{ $data['title'] }}">
    <meta property="og:description" content="{{ $data['desc'] }}">
    <meta property="og:type" content="website">
    <meta property="og:image" content="{{ $data['thumb'] }}">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="1000">
    <meta property="og:image:height" content="500">
    @include('frontend.partials.styles')
</head>
<body class="rbt-header-sticky">
    @include('frontend.partials.header')
    <!-- Body Content start -->
    @yield('content')
    <!-- Body Content end -->
    @include('frontend.partials.footer')
    <div class="rbt-progress-parent">
        <svg class="rbt-back-circle svg-inner" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
        </svg>
    </div>
    @include('frontend.partials.scripts')
</body>
</html>