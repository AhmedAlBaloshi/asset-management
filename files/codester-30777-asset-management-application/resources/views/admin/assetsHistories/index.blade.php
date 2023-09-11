@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('cruds.assetsHistory.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-AssetsHistory">
                <thead>
                    <tr>
                        <th width="10"></th>
                        <th>{{ trans('global.code') }}</th>
                        <th>{{ trans('global.asset') }}</th>
                        <th>{{ trans('global.location_name') }}</th>
                        <th>{{ trans('global.quantity') }}</th>
                        <th>{{ trans('global.created_at') }}</th>
                        <th>{{ trans('global.updated_at') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($assetLocation as $key => $assetLocation)
                        <tr data-entry-id="{{ $assetLocation->id }}">
                            <td></td>
                            <td>{{ $assetLocation->code ?? '' }}</td>
                            <td>{{ $assetLocation->name ?? '' }}</td>
                            <td>{{ $assetLocation->location_name ?? '' }}</td>
                            <td>{{ $assetLocation->quantity ?? '' }}</td>
                            <td>{{ $assetLocation->created_at ?? '' }}</td>
                            <td>{{ $assetLocation->updated_at ?? '' }}</td>
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
$(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
  
  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-AssetsHistory:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})
</script>
@endsection