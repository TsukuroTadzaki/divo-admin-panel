@empty(!$title)
    <fieldset>
            <div class="col p-0 px-3">
                <legend class="text-black mt-2 mx-2">
                    {{ $title }}
                </legend>
            </div>
    </fieldset>
@endempty

<div class="bg-white rounded shadow-sm mb-3"
     data-controller="table"
     data-table-slug="{{$slug}}"
>

    <div class="table-responsive">
        <table @class([
                    'table',
                    'table-compact'  => $compact,
                    'table-striped'  => $striped,
                    'table-bordered' => $bordered,
                    'table-hover'    => $hoverable,
               ])>

            @if($showHeader)
                <thead>
                    <tr>
                        @if (count($rows) && isset($rows[0]->children))
                            <th>#</th>
                        @endif
                        @foreach($columns as $column)
                            {!! $column->buildTh() !!}
                        @endforeach
                    </tr>
                </thead>
            @endif

            <tbody>

                @if (count($rows))
                    @include('platform::layouts.table-rows', [
                        'rows' => $rows,
                        'child' => false,
                        'index' => $loop->index,
                        'parent' => $loop->parent,
                        'columns' => $columns,
                        'level' => '',
                        'row_id' => uniqid('expanded_'),
                    ])
                @endif

                @if($total->isNotEmpty())
                    <tr>
                        @foreach($total as $column)
                            {!! $column->buildTd($repository, $loop) !!}
                        @endforeach
                    </tr>
                @endif

            </tbody>
        </table>
    </div>

    @if($rows->isEmpty())
        <div class="d-md-flex align-items-center px-md-0 px-2 pt-4 pb-5 w-100 text-md-start text-center">

            @isset($iconNotFound)
                <div class="col-auto mx-md-4 mb-3 mb-md-0">
                    <x-orchid-icon :path="$iconNotFound" class="block h1"/>
                </div>
            @endisset

            <div>
                <h3 class="fw-light">
                    {!!  $textNotFound !!}
                </h3>

                 {!! $subNotFound !!}
            </div>
        </div>
    @else

        @include('platform::layouts.pagination',[
                'paginator' => $rows,
                'columns' => $columns,
                'onEachSide' => $onEachSide,
        ])

    @endif
</div>



@push('scripts')
    <script>
        function expandRow(el, rowId) {
            if (el.innerText === '-') {
                var content = document.querySelectorAll('tr[data-id^="' + rowId + '"]');
                for (tr of content) {
                    tr.style.display = "none";
                }
                var actions = document.querySelectorAll('tr[data-id^="' + rowId + '"] td .nested.action');
                for (action of actions) {
                    action.innerText = "+";
                }
                el.innerText = '+';
            } else {
                var content = document.querySelectorAll('tr[data-id="' + rowId + '"]');
                for (tr of content) {
                    tr.style.display = "table-row";
                }
                el.innerText = '-';
            }
        }
    </script>
@endpush

@push('stylesheets')
    <style>
        .nested {
            font-size: 1.5rem;
            color: gray;
        }
        .nested.action {
            cursor: pointer;
        }
    </style>
@endpush
