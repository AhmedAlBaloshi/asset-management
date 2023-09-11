@extends('layouts.admin')
@section('content')
{{-- @can('asset_category_create') --}}
<div style="margin-bottom: 10px;" class="row">
    <div class="col-lg-12">
        <a class="btn btn-success" href="{{ route('admin.asset-departments.create') }}">
            {{ trans('global.add') }} {{ trans('Department') }}
        </a>
    </div>
</div>
{{-- @endcan --}}
<div class="card">
    <div class="card-header">
        {{ trans('Department') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-AssetDepartment">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('Name') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($assetDepartments as $key => $assetDepartment)
                    <tr data-entry-id="{{ $assetDepartment->id }}">
                        <td>

                        </td>
                        <td>
                            {{ $assetDepartment->name ?? '' }}
                        </td>
                        <td>
                            {{-- @can('asset_category_show') --}}
                            <a class="btn btn-xs btn-primary" href="{{ route('admin.asset-departments.show', $assetDepartment->id) }}">
                                {{ trans('global.view') }}
                            </a>
                            {{-- @endcan --}}

                            {{-- @can('asset_category_edit') --}}
                            <a class="btn btn-xs btn-info" href="{{ route('admin.asset-departments.edit', $assetDepartment->id) }}">
                                {{ trans('global.edit') }}
                            </a>
                            {{-- @endcan --}}

                            {{-- @can('asset_category_delete') --}}
                            <form action="{{ route('admin.asset-departments.destroy', $assetDepartment->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                            </form>
                            {{-- @endcan --}}

                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function() {
        let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
        // @can('asset_category_delete')
        // let deleteButtonTrans = 'Delete selected';
        let deleteButton = {
            text: 'Delete Selected'
            , url: "{{ route('admin.asset-departments.massDestroy') }}"
            , className: 'btn-danger'
            , action: function(e, dt, node, config) {
                var ids = $.map(dt.rows({
                    selected: true
                }).nodes(), function(entry) {
                    return $(entry).data('entry-id')
                });

                if (ids.length === 0) {
                    alert("{{ trans('global.datatables.zero_selected') }}")

                    return
                }

                if (confirm('{{ trans('global.areYouSure') }}')) {
                    // console.warn(config.url);
                    $.ajax({
                            headers: {
                                'x-csrf-token': _token
                            }
                            , method: 'POST'
                            , url: config.url
                            , data: {
                                ids: ids
                                , _method: 'DELETE'
                            }
                        })
                        .done(function() {
                            location.reload()
                        })
                }
            }
        }
        dtButtons.push(deleteButton)
        // @endcan

        $.extend(true, $.fn.dataTable.defaults, {
            orderCellsTop: true
            , order: [
                [1, 'desc']
            ]
            , pageLength: 100
        , });
        let table = $('.datatable-AssetDepartment:not(.ajaxTable)').DataTable({
            buttons: dtButtons
        })
        $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });

    })

</script>
@endsection
