@php
$isEmptyNavbarBanner = Dashboard::isEmptyNavbarBanner();
@endphp
<!DOCTYPE html>
<html lang="{{  app()->getLocale() }}" data-controller="html-load" dir="{{ \Orchid\Support\Locale::currentDir() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no">
    <title>
        @yield('title', config('app.name'))
        @hasSection('title')
            - {{ config('app.name') }}
        @endif
    </title>
    <meta name="csrf_token" content="{{  csrf_token() }}" id="csrf_token">
    <meta name="auth" content="{{  Auth::check() }}" id="auth">
    @if(\Orchid\Support\Locale::currentDir(app()->getLocale()) == "rtl")
        <link rel="stylesheet" type="text/css" href="{{  mix('/css/orchid.rtl.css','vendor/orchid') }}">
    @else
        <link rel="stylesheet" type="text/css" href="{{  mix('/css/orchid.css','vendor/orchid') }}">
    @endif

    @stack('head')

    <meta name="turbo-root" content="{{  Dashboard::prefix() }}">
    <meta name="dashboard-prefix" content="{{  Dashboard::prefix() }}">

    @if(!config('platform.turbo.cache', false))
        <meta name="turbo-cache-control" content="no-cache">
    @endif

    <script src="{{ mix('/js/manifest.js','vendor/orchid') }}" type="text/javascript"></script>
    <script src="{{ mix('/js/vendor.js','vendor/orchid') }}" type="text/javascript"></script>
    <script src="{{ mix('/js/orchid.js','vendor/orchid') }}" type="text/javascript"></script>

    @foreach(Dashboard::getResource('stylesheets') as $stylesheet)
        <link rel="stylesheet" href="{{  $stylesheet }}">
    @endforeach

    @stack('stylesheets')

    @foreach(Dashboard::getResource('scripts') as $scripts)
        <script src="{{  $scripts }}" defer type="text/javascript"></script>
    @endforeach

    @if(!empty(config('platform.vite', [])))
        @vite(config('platform.vite'))
    @endif
</head>

<body class="{{ \Orchid\Support\Names::getPageNameClass() }}" data-controller="pull-to-refresh">
<nav class="navbar sticky-top bg-dark" style="box-shadow: 0 .125rem .25rem rgba(21,20,26,.075)!important;">
    @yield('navbar_menu')
</nav>
<div class="container-fluid" data-controller="@yield('controller')" @yield('controller-data')>

    <div class="row d-md-flex h-100">
        @yield('aside')

        <div class="col-xxl col-xl-9 offset-md-2 col-md-10">
            @yield('body')
        </div>
    </div>


    @include('platform::partials.toast')
</div>

@stack('scripts')
<script type="text/javascript">
    function openPicker(input_id, multiple = 0, mimes = []) {
        let btn = document.getElementById('filemanager_btn_' + input_id);
        if (btn) {
            btn.style.display = 'none';
            let url = btn.getAttribute('data-url');
            let options = {
                customData: {
                    _token: '{{ csrf_token() }}',
                    watermarkPath: '{{ $watermarkPath ?? "" }}',
                },
                url: '{{ route("elfinder.connector") }}',
                urlUpload: url,
                resizable: false,
                ui: ['toolbar', 'tree', 'path','stat'],
                rememberLastDir : true,
                useBrowserHistory: false,
                reloadClearHistory: false,
                height: 300,
                defaultView: 'list',
                getFileCallback: function (files, fm) {
                    if (Array.isArray(files)) {
                        for(let file of files){
                            showPreview(input_id, file.path, multiple)
                        }
                    } else {
                        showPreview(input_id, files.path, multiple)
                    }
                    document.getElementById('filemanager_btn_' + input_id).style.display = 'flex';
                    fm.destroy();
                },
                commandsOptions : {
                    getfile : {
                        multiple : multiple ? true : false,
                    },
                },
                uiOptions : {
                    toolbar : [
                        ['back', 'forward'],
                        ['home', 'up'],
                        ['mkdir', 'mkfile', 'upload'],
                        ['open', 'download', 'getfile'],
                        ['info'],
                        ['copy', 'cut', 'paste'],
                        ['rm'],
                        ['duplicate', 'rename', 'edit', 'resize'],
                        ['extract', 'archive'],
                        ['search'],
                        ['view']
                    ],
                    tree : {
                        openRootOnLoad : true,
                        syncTree : true
                    },
                    navbar : {
                        minWidth : 150,
                        maxWidth : 500
                    },
                    cwd : {
                        oldSchool : false
                    }
                },
            };
            if (!Array.isArray(mimes)) {
                mimes = JSON.parse(mimes);
            }
            if (mimes.length) {
                options.onlyMimes = mimes;
            }
            var elf = $('#filepicker_' + input_id).elfinder(options).elfinder('instance');
        }
    }

    function showPreview(input_id, path, multiple) {
        if (!multiple) {
            document.getElementById('inputs_' + input_id).innerHTML = '';
        }
        let span = document.querySelector('.empty-span');
        if (span) {
            span.remove();
        }
        let clone = document.querySelector('#ref_' + input_id).cloneNode(true);
        clone.querySelector('img').src = '/' +  path;
        clone.querySelector('input').value = path;
        clone.classList.remove('ref');
        clone.style.display = 'flex';
        document.getElementById('inputs_' + input_id).appendChild(clone);
        sortable_preview();
    }
    function sortable_preview() {
        $('.preview-container').sortable();
    }
</script>

</body>
</html>
