<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/elfinder/2.1.64/js/elfinder.min.js" integrity="sha512-2/LGrIY+MyzVq+p9FOnlEH/1ekCJXWMVU9INphJp5GA6lHEWYb3ZETcB5pJDGkUUU04Bc6V9F9dwdj/22fWKqg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript" charset="utf-8">
        document.addEventListener('DOMContentLoaded', elfinder_handler);
        document.addEventListener('turbo:load', elfinder_handler);

        function elfinder_handler(event) {
            $('#elfinder').elfinder({
                customData: {
                    _token: '{{ csrf_token() }}'
                },
                url : '{{ route("elfinder.connector") }}',
                urlUpload: '{{ route("platform.file_upload", ["watermark" => 0]) }}',
                rememberLastDir : false,
                useBrowserHistory: false,
                reloadClearHistory: true,
            });
        }
</script>
<div id="elfinder"></div>
