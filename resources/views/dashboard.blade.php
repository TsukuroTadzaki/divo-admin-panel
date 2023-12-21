@extends(config('platform.workspace', 'platform::workspace.compact'))
@php
$isEmptyNavbarBanner = Dashboard::isEmptyNavbarBanner();
@endphp
@section('aside')
    <div class="aside col-xs-12 col-xxl-2 bg-white d-flex flex-column" style="margin-top: {{ $isEmptyNavbarBanner ? '2.5rem' : '4.5rem' }};" data-controller="menu">
        <header class="d-xl-block p-3 mt-xl-4 w-100 d-flex align-items-center">
            <a href="#" class="header-toggler d-xl-none me-auto order-first d-flex align-items-center lh-1"
               data-action="click->menu#toggle">
                <x-orchid-icon path="bs.three-dots-vertical" class="icon-menu"/>

                <span class="ms-2">@yield('title')</span>
            </a>

            <a class="header-brand order-last" href="{{ route(config('platform.index')) }}">
                @includeFirst([config('platform.template.header'), 'platform::header'])
            </a>
        </header>

        <nav class="aside-collapse w-100 d-xl-flex flex-column collapse-horizontal" id="headerMenuCollapse1212">

            @include('platform::partials.search')

            <ul class="nav flex-column mb-md-1 mb-auto ps-0">
                {!! Dashboard::renderMenu(\Orchid\Platform\Dashboard::MENU_MAIN) !!}
            </ul>

            <div class="h-100 w-100 position-relative to-top cursor d-none d-md-flex mt-md-5"
                 data-action="click->html-load#goToTop"
                 title="{{ __('Scroll to top') }}">
                <div class="bottom-left w-100 mb-2 ps-3 overflow-hidden">
                    <small data-controller="viewport-entrance-toggle"
                           class="scroll-to-top"
                           data-viewport-entrance-toggle-class="show">
                        <x-orchid-icon path="bs.chevron-up" class="me-2 text-white"/>
                        {{ __('Scroll to top') }}
                    </small>
                </div>
            </div>

            <footer class="position-sticky bottom-0">
                {{-- <div class="bg-dark position-relative overflow-hidden" style="padding-bottom: 10px;">
                    @includeWhen(Auth::check(), 'platform::partials.profile')
                </div> --}}


                {{--
                <div class="mt-3">
                    @includeFirst([config('platform.template.footer'), 'platform::footer'])
                </div>

                --}}

            </footer>
        </nav>
    </div>
@endsection

@section('navbar_manu')
<div class="w-100 position-md-fixed z-10 bg-white">
    @if (!$isEmptyNavbarBanner)
        <marquee direction="left" scrollamount="8">{!! Dashboard::renderNavbarBanner() !!}</marquee>
    @endif
    <ul class="nav d-md-flex align-items-center">
        {!! Dashboard::renderNavbar(\Orchid\Platform\Dashboard::MENU_NAVBAR) !!}
    </ul>
</div>
@endsection

@section('workspace')
    @if(Breadcrumbs::has())
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb px-4 mb-2">
                <x-tabuna-breadcrumbs
                    class="breadcrumb-item"
                    active="active"
                />
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
        .z-10 {
            z-index: 10;
        }
        @media (min-width: 768px) {
            .position-md-fixed {
                position: fixed !important;
            }
        }
        .aside .nav li.nav-item.active {
            background-color: #ddd;
        }
        li.nav-item:hover {
            background-color: #ddd;
        }

    </style>
@endpush