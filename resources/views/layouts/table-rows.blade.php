@foreach($rows as $model)
    @php $row_id2 = uniqid(); @endphp

    <tr style="display: {{ $child ? 'none' : 'table-row'}};" data-id="{{ $row_id }}">
        @if (isset($model->children))
            <td>
                <span class="nested">{!! $level !!}</span>
                @if(!empty($model->children) && count($model->children))
                    &nbsp;<span class="nested action" onclick="expandRow(this, '{{ $row_id . '_' . $row_id2 }}')">+</span>
                @endif
            </td>
        @endif
        @foreach($columns as $column)
            {!! $column->buildTd($model, $parent) !!}
        @endforeach
    </tr>

    @if(!empty($model->children) && count($model->children))
        @php
            if (isset($model->sort)) {
                $children = $model->children->sortBy('sort');
            } else {
                $children = $model->children;
            }
        @endphp
        @include('platform::layouts.table-rows', [
            'rows' => $children,
            'child' => true,
            'index' => $loop->index,
            'parent' => $loop->parent,
            'columns' => $columns,
            'level' => $level . '&nbsp;·',
            'row_id' => $row_id. '_' . $row_id2
        ])
    @endif
@endforeach
