<script type="text/javascript" charset="utf-8">
        document.addEventListener('DOMContentLoaded', elfinder_handler);
        document.addEventListener('turbo:load', elfinder_handler);

        function elfinder_handler(event) {
            $('#elfinder').elfinder({
                customData: {
                    _token: '{{ csrf_token() }}'
                },
                url : '{{ route("elfinder.connector") }}',
                urlUpload: '{{ route("platform.files_upload", ["watermark" => 1]) }}',
                rememberLastDir : false,
                useBrowserHistory: false,
                reloadClearHistory: true,
            });
        }
</script>
<div id="elfinder"></div>
