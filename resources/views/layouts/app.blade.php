@php
$print = app('printservice')->isPrintMode();
$pClass = request()->route()->getAction()['controller'] ?? 'App\Http\Controllers\GenericPagesController';
$pClass = preg_replace('/App\\\\Http\\\\Controllers\\\\/i','p-',$pClass);
$pClass = preg_replace('/Controller/i','',$pClass);
$pClass = strtolower(preg_replace('/@/i','-',$pClass));
@endphp
<!DOCTYPE html>
<html dir="ltr" lang="{{ app()->getLocale() }}" class="no-js{{ (isset($unstickyHeader) and $unstickyHeader) ? ' s-unsticky-header' : '' }}{{ (isset($contrastHeader) and $contrastHeader) ? ' s-contrast-header' : '' }}{{ (isset($borderlessHeader) and $borderlessHeader) ? ' s-borderless-header' : '' }}{{ (isset($filledLogo) and $filledLogo) ? ' s-filled-logo' : '' }}{{ $print ? ' s-print' : '' }}  {{ !empty($roadblocks) && $roadblocks->count() > 0 ? ' s-roadblock-defined' : '' }}{{ isset($_COOKIE["A17_fonts_cookie_serif"]) ? ' s-serif-loaded' : '' }}{{ isset($_COOKIE["A17_fonts_cookie_sans-serif"]) ? ' s-sans-serif-loaded' : '' }} s-env-{{ app()->environment() }} {{ $pClass }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover" />
  <meta http-equiv="X-UA-Compatible" content="IE=Edge">
  <meta name="format-detection" content="telephone=no">

    @if (isset($seo))
      <meta property="twitter:card" content="summary_large_image" />
      <meta property="og:type" content="article" />
      @section('meta_title') @include('partials.metas._title') @show
      @section('meta_description') @include('partials.metas._description') @show
      @section('meta_url') @include('partials.metas._url') @show
      @section('meta_image') @include('partials.metas._image') @show
    @endif

  <link rel="search" type="application/opensearchdescription+xml" title="Art Institute of Chicago" href="/opensearch.xml">

  <!-- Main Favicon -->
  <link rel="shortcut icon" type="image/png" href="{{revAsset('images/favicon-16.png')}}">
  <!-- Apple Touch Icons (ipad/iphone standard+retina) -->
  <link rel="apple-touch-icon-precomposed" href="{{revAsset('images/favicon-152.png')}}"> <!-- General use iOS/Android icon, auto-downscaled by devices. -->
  <link rel="apple-touch-icon-precomposed" type="image/png" href="{{revAsset('images/favicon-120.png')}}" sizes="120x120"> <!-- iPhone retina touch icon -->
  <link rel="apple-touch-icon-precomposed" type="image/png" href="{{revAsset('images/favicon-76.png')}}" sizes="76x76"> <!-- iPad home screen icons -->

  <!--[if lt IE 9]>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
  <![endif]-->

  <meta name="csrf-token" content="{{ csrf_token() }}">

  <meta name="svg-sprite-src" content="{{ revAsset('icons/icons.svg') }}">

  @include('partials._head-js')
  @if ($print)
      <script>A17.print = true;</script>
  @endif
  <link rel="stylesheet" type="text/css" href="https://cloud.typography.com/612324/7579192/css/fonts.css" />
  <link rel="preload" href="{{revAsset('fonts/3545D5_0_0.eot')}}" as="font" crossorigin="anonymous" />
  <link rel="preload" href="{{revAsset('fonts/3545D5_0_0.eot?#iefix')}}" as="font" crossorigin="anonymous" />
  <link rel="preload" href="{{revAsset('fonts/3545D5_0_0.woff2')}}" as="font" type="font/woff2" crossorigin="anonymous" />
  <link rel="preload" href="{{revAsset('fonts/3545D5_0_0.woff')}}" as="font" type="font/woff" crossorigin="anonymous" />
  <link rel="preload" href="{{revAsset('fonts/3545D5_0_0.ttf')}}" as="font" type="font/ttf" crossorigin="anonymous" />
  <link rel="preload" href="{{revAsset('fonts/3545D5_1_0.eot')}}" as="font" crossorigin="anonymous" />
  <link rel="preload" href="{{revAsset('fonts/3545D5_1_0.eot?#iefix')}}" as="font" crossorigin="anonymous" />
  <link rel="preload" href="{{revAsset('fonts/3545D5_1_0.woff2')}}" as="font" type="font/woff2" crossorigin="anonymous" />
  <link rel="preload" href="{{revAsset('fonts/3545D5_1_0.woff')}}" as="font" type="font/woff" crossorigin="anonymous" />
  <link rel="preload" href="{{revAsset('fonts/3545D5_1_0.ttf')}}" as="font" type="font/ttf" crossorigin="anonymous" />
  <link rel="preload" href="{{revAsset('fonts/3545D5_2_0.eot')}}" as="font" crossorigin="anonymous" />
  <link rel="preload" href="{{revAsset('fonts/3545D5_2_0.eot?#iefix')}}" as="font" crossorigin="anonymous" />
  <link rel="preload" href="{{revAsset('fonts/3545D5_2_0.woff2')}}" as="font" type="font/woff2" crossorigin="anonymous" />
  <link rel="preload" href="{{revAsset('fonts/3545D5_2_0.woff')}}" as="font" type="font/woff" crossorigin="anonymous" />
  <link rel="preload" href="{{revAsset('fonts/3545D5_2_0.ttf')}}" as="font" type="font/ttf" crossorigin="anonymous" />
  <style>
  @import url("//hello.myfonts.net/count/3545d5");
  @font-face {font-family: 'Sabon';src: url({{revAsset('fonts/3545D5_0_0.eot')}});src: url({{revAsset('fonts/3545D5_0_0.eot?#iefix')}}) format('embedded-opentype'),url({{revAsset('fonts/3545D5_0_0.woff2')}}) format('woff2'),url({{revAsset('fonts/3545D5_0_0.woff')}}) format('woff'),url({{revAsset('fonts/3545D5_0_0.ttf')}}) format('truetype');font-weight:normal;font-weight:400;font-style:normal;}
  @font-face {font-family: 'Sabon';src: url({{revAsset('fonts/3545D5_1_0.eot')}});src: url({{revAsset('fonts/3545D5_1_0.eot?#iefix')}}) format('embedded-opentype'),url({{revAsset('fonts/3545D5_1_0.woff2')}}) format('woff2'),url({{revAsset('fonts/3545D5_1_0.woff')}}) format('woff'),url({{revAsset('fonts/3545D5_1_0.ttf')}}) format('truetype');font-weight:normal;font-weight:400;font-style:italic;}
  @font-face {font-family: 'Sabon';src: url({{revAsset('fonts/3545D5_2_0.eot')}});src: url({{revAsset('fonts/3545D5_2_0.eot?#iefix')}}) format('embedded-opentype'),url({{revAsset('fonts/3545D5_2_0.woff2')}}) format('woff2'),url({{revAsset('fonts/3545D5_2_0.woff')}}) format('woff'),url({{revAsset('fonts/3545D5_2_0.ttf')}}) format('truetype');font-weight:normal;font-weight:500;font-style:normal;}
  </style>
  <link rel="stylesheet" href="https://vjs.zencdn.net/7.1.0/video-js.css" />
  <meta name="msvalidate.01" content="1E22F0BBEF5CF0D71FF4C150D094A1CA" />
  <link href="{{revAsset('styles/app.css')}}" rel="stylesheet" />
  @if ($print)
    <link href="{{revAsset('styles/print.css')}}" rel="stylesheet" />
  @else
      <link href="{{revAsset('styles/print.css')}}" rel="stylesheet" media="print" />
      @if (config('services.google_tag_manager.enabled'))
        <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','{!! config('services.google_tag_manager.id') !!}');</script>
        <!-- End Google Tag Manager -->
      @endif
  @endif
</head>

@if ($print)
<body onload="window.print();" class="s-serif-loaded s-sans-serif-loaded">
@else
<body>

@endif
    @if (config('services.google_tag_manager.enabled'))
        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={!! config('services.google_tag_manager.id') !!}"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->
    @endif

<div id="a17">

  @include('partials._header')

  <main id="content">
    @if (!empty($roadblocks))
        <div id="slider-promo" class="g-slider g-slider--promo"></div>
        @foreach ($roadblocks as $roadblock)
            <script type="text/template" class="g-slider--promo--template" data-geotarget="{{ $roadblock['geotarget'] }}" data-expires="{{ $roadblock['expiry_period'] ?? 86400 }}">
                @component('partials._slider-promo', ['modal' => $roadblock])
                @endcomponent
            </script>
        @endforeach
    @endif

    @yield('content')

    @include('partials._newsletter')
  </main>

  @include('partials._footer')

  @if (config('aic.show_design_grids'))
    @include('partials._designgrids')
  @endif
</div>

@include('partials._mask')
@include('partials._calendar')
@include('partials._fullscreenImage')
@include('partials._share-menu')
@include('partials._nav-mobile')
@include('partials._search')
@include('partials._modal')
@include('partials._ajax-loader')

@include('partials._scripts')
</body>
</html>
@if (config('api.logger'))
@php
\Log::info(app('debug')->getOutput());
@endphp
@endif
