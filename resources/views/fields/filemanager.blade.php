<label class="form-label">{{ $title }}</label>
<div>
    <div id="ref_{{ $attributes['id'] }}" class="preview-wrapper" style="display: none;">
        <img src="" alt="">
        <input type="hidden" name="{{ $attributes['name'] }}{{ $allowMultiple ? '[]' : '' }}">
        <button onclick="this.closest('div').remove()" class="remove-image">&#215;</button>
    </div>
    <div class="command-bar d-flex nav-link">
        <a href="javascript:void(0)" onclick="openPicker('{{ $attributes['id'] }}', {{ $allowMultiple ? 1 : 0 }}, '{{ json_encode($mimes) }}')" class="btn btn-link" id="filemanager_btn_{{ $attributes['id'] }}" data-url={{ route("platform.file_upload") }}>
            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="1em" height="1em" viewBox="0 0 32 32" class="me-2" role="img" fill="currentColor" path="folder-alt" componentname="orchid-icon">
                <path d="M30.005 6.5h-15l-3-3h-10c-1.105 0-2 0.896-2 2v5h-0.009v2h0.009v14c0 1.105 0.895 2 2 2h28c1.105 0 2-0.895 2-2v-18c0-1.104-0.895-2-2-2zM2.005 5.5h9.086l2.457 2.414 0.629 0.586h15.829v2h-28v-5h-0zM2.005 26.5v-14h28v14h-28z"></path>
            </svg>
            <span>{{ _t('Choose files...') }}</span>
        </a>
    </div>
    <div id="filepicker_{{ $attributes['id'] }}"></div>
    <div id="inputs_{{ $attributes['id'] }}" class="preview-container">
        @if (!$value)
            <span class="empty-span">{{ _t('No files selected') }}</span>
        @else
            @if ($allowMultiple)
                @foreach ($value as $image)
                    <div class="preview-wrapper">
                        <img src="/{{ $image }}" alt="">
                        <input type="hidden" name="{{ $attributes['name'] }}[]" value="{{ $image }}">
                        <button onclick="this.closest('div').remove()" class="remove-image">&#215;</button>
                    </div>
                @endforeach
            @else
                <div class="preview-wrapper">
                    <img src="/{{ $value }}" alt="">
                    <input type="hidden" name="{{ $attributes['name'] }}" value="{{ $value }}">
                    <button onclick="this.closest('div').remove()" class="remove-image">&#215;</button>
                </div>
            @endif
        @endif
    </div>
</div>
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', sortable_preview);
    document.addEventListener('turbo:load', sortable_preview);
    function sortable_preview() {
        $('.preview-container').sortable();
    }
    function openPicker(input_id, multiple = 0, mimes = []) {
        let btn = document.getElementById('filemanager_btn_' + input_id);
        btn.style.display = 'none';
        let url = btn.getAttribute('data-url');
        let options = {
            customData: {
                _token: '{{ csrf_token() }}',
                watermarkPath: '{{ $watermarkPath }}',
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
</script>

<style>
    .preview-container {
        display: flex;
        flex-wrap: wrap;
        margin-top: 1rem;
    }
    .preview-wrapper {
        position: relative;
        display: flex;
        flex-direction: column;
        margin-right: 1rem;
        margin-bottom: 1rem;
        width: 150px;
        height: 150px;
    }
    .preview-wrapper img {
        width: 100%;
        height: auto;
        margin: auto;
    }
    .remove-image {
        display: inline;
        position: absolute;
        top: -10px;
        right: -10px;
        border-radius: 10em;
        padding: 2px 6px 3px;
        text-decoration: none;
        font: 700 21px/20px sans-serif;
        background: #555;
        border: 3px solid #fff;
        color: #FFF;
        box-shadow: 0 2px 6px rgba(0,0,0,0.5), inset 0 2px 4px rgba(0,0,0,0.3);
        text-shadow: 0 1px 2px rgba(0,0,0,0.5);
        -webkit-transition: background 0.5s;
        transition: background 0.5s;
    }
    .remove-image:hover {
        background: #E54E4E;
        padding: 3px 7px 5px;
        top: -11px;
        right: -11px;
    }
    .remove-image:active {
        background: #E54E4E;
        top: -10px;
        right: -11px;
    }
</style>
