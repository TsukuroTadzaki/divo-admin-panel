@extends('platform::workspace.compact')
@php
$isEmptyNavbarBanner = Dashboard::isEmptyNavbarBanner();
@endphp
@section('aside')
{{-- desktop --}}
<div class="col-xs-12 col-md-2 bg-dark d-none d-md-flex flex-column position-fixed overflow-scroll h-100 pb-md-5 sidebar-nav" data-controller="menu" id="aside-section">
    <div class="row side-container">
        <div class="left-side col-lg-3">
            <ul class="nav flex-column mb-md-1 mb-auto ps-0 tab-head-wrapper">
                @foreach(Dashboard::renderNewMenu() as $key => $menu)
                <li class="nav-item" id="nav-{{$key}}">
                    <a id="nav-1" data-id="#content-{{$key}}" class="nav-link d-flex align-items-center collapsed" data-turbo-frame="tabContent">
                        <x-orchid-icon path="{{$menu['icon']}}" class="me-2 text-white" />
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
        <div class="right-side col-lg-9">
            <nav class="aside-collapse w-100 d-xl-flex flex-column collapse-horizontal mb-md-5" id="headerMenuCollapse1212" style="overflow-x: hidden !important;">
                <div class="tabs-wrapper" turbo-frame id="tabContent">
                    <!-- {{-- @include('platform::partials.search') --}} -->
                    @foreach(Dashboard::renderNewMenu() as $key => $menu)
                    <ul id="content-{{$key}}" class="nav flex-column mb-md-1 mb-auto ps-0 side-wrap content">
                        @foreach($menu['list'] as $item)
                        {!!$item->render()!!}
                        @endforeach
                        <!-- {!! Dashboard::renderMenu(\Orchid\Platform\Dashboard::MENU_MAIN) !!} -->
                    </ul>
                    @endforeach
                    <ul id="test2" class="nav flex-column mb-md-1 mb-auto ps-0 side-wrap content">
                        @foreach(app('lang')->getActiveLanguages() as $lang)
                        <li class="d-flex nav-item">
                            <a href="{{ route('platform.localize', ['locale' => $lang->slug]) }}" class="nav-link text-white">
                                {{ strtoupper($lang->slug) }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="h-100 w-100 position-relative to-top cursor d-flex mt-md-5" data-action="click->html-load#goToTop" title="{{ __('Scroll to top') }}">
                    <div class="bottom-left w-100 mb-2 ps-3 overflow-hidden">
                        <small data-controller="viewport-entrance-toggle" class="scroll-to-top" data-viewport-entrance-toggle-class="show">
                            <x-orchid-icon path="bs.chevron-up" class="me-2 text-white" />
                            {{ __('Scroll to top') }}
                        </small>
                    </div>
                </div>
                <!-- <footer class="position-sticky bottom-0">
                    <div class="position-fixed overflow-hidden bottom-0" style="padding-bottom: 10px;">
                        <svg id="darkmodeToggle" width="20px" height="20px" viewBox="0 0 24 24">
                            <g fill="#fff" fill-rule="nonzero">
                                <path d="M12,22 C17.5228475,22 22,17.5228475 22,12 C22,6.4771525 17.5228475,2 12,2 C6.4771525,2 2,6.4771525 2,12 C2,17.5228475 6.4771525,22 12,22 Z M12,20.5 L12,3.5 C16.6944204,3.5 20.5,7.30557963 20.5,12 C20.5,16.6944204 16.6944204,20.5 12,20.5 Z"></path>
                            </g>
                        </svg>
                    </div>
                </footer> -->
            </nav>
        </div>
    </div>
</div>
@endsection

@section('navbar_menu')
{{-- desktop --}}
<div class="d-none d-md-flex justify-content-betwween align-items-center w-100">
    <header class="d-flex align-items-center p-2 ps-4 col-2">
        <a class="header-brand order-last" href="{{ route(config('platform.index')) }}">
            @includeFirst([config('platform.template.header'), 'platform::header'])
        </a>
    </header>
    <div class="col-10">
        @if (!$isEmptyNavbarBanner)
        <marquee direction="left" scrollamount="8">{!! Dashboard::renderNavbarBanner() !!}</marquee>
        @endif

        <ul class="nav d-md-flex align-items-center justify-content-end">
            @foreach(app('lang')->getActiveLanguages() as $lang)
            <li class="d-flex nav-item">
                <a href="{{ route('platform.localize', ['locale' => $lang->slug]) }}" class="nav-link text-white">
                    {{ strtoupper($lang->slug) }}
                </a>
            </li>
            @endforeach
            {!! Dashboard::renderNavbar(\Orchid\Platform\Dashboard::MENU_NAVBAR) !!}
        </ul>
    </div>
</div>
{{-- mobile --}}
<div class="container-fluid d-flex flex-column d-md-none col-12">
    @if (!$isEmptyNavbarBanner)
    <div class="m-auto ms-0">
        <marquee direction="left" scrollamount="8">{!! Dashboard::renderNavbarBanner() !!}</marquee>
    </div>
    @endif
    <div class="m-auto">
        <a class="header-brand order-first col-12" href="{{ route(config('platform.index')) }}">
            @includeFirst([config('platform.template.header'), 'platform::header'])
        </a>
    </div>
    <div class="col-12">
        <ul class="nav d-flex flex-nowrap flex-row overflow-auto">
            {!! Dashboard::renderNavbar(\Orchid\Platform\Dashboard::MENU_NAVBAR) !!}
        </ul>
    </div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark m-auto ms-0 d-flex justify-content-between w-100">
        <div class="container-fluid">
            <span class="ms-2">@yield('title')</span>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse mt-3" id="navbarTogglerDemo02">
                <ul class="nav flex-column mb-md-1 mb-auto ps-0">
                    {!! Dashboard::renderMenu(\Orchid\Platform\Dashboard::MENU_MAIN) !!}
                </ul>
            </div>
        </div>
    </nav>
</div>
@endsection

@section('workspace')
@if(Breadcrumbs::has())
<nav aria-label="breadcrumb">
    <ol class="breadcrumb px-4 mb-2">
        <x-tabuna-breadcrumbs class="breadcrumb-item" active="active" />
    </ol>
</nav>
@endif

<div class="order-last order-md-0 command-bar-wrapper">
    <div class="@hasSection('navbar') @else d-none d-md-block @endif layout d-md-flex align-items-center">
        <header class="d-none d-md-block col-xs-12 col-md p-0 me-3">
            <h1 class="m-0 fw-light h3 text-black">@yield('title')</h1>
            <small class="text-muted" title="@yield('description')">@yield('description')</small>
        </header>
        <nav class="col-xs-12 col-md-auto ms-md-auto p-0">
            <ul class="nav command-bar justify-content-sm-end justify-content-start d-flex align-items-center">
                @yield('navbar')
            </ul>
        </nav>
    </div>
</div>

@include('platform::partials.alert')
@yield('content')
@endsection

@push('head')
<style>

</style>
@endpush
