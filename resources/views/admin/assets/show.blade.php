@extends('layouts.admin')
@section('content')

<div class="row">
    <div class="col-md-3">
        <div class="info-box bg-info">
            <span class="info-box-icon bg-red" style="display:flex; flex-direction: column; justify-content: center;">
                <i class="fa fa-chart-line"></i>
            </span>

            <div class="info-box-content">
                <span class="info-box-text">Total Asset</span>
                <span class="info-box-number">1</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    
    <div class="col-md-3">
        <div class="info-box bg-primary">
            <span class="info-box-icon bg-red" style="display:flex; flex-direction: column; justify-content: center;">
                <i class="fa fa-chart-line"></i>
            </span>

            <div class="info-box-content">
                <span class="info-box-text">Asset in Location</span>
                <span class="info-box-number">{{ $assetInLocation }}</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
</div>

<ul class="nav nav-tabs">
    <li class="active"><a href="#detail" data-toggle="tab" class="btn btn-primary btn-sm">Detail</a></li>
    <li>&nbsp;<a href="#locations" data-toggle="tab" class="btn btn-sm btn-info">Locations</a></li>
</ul>

<div class="tab-content">
    <div id="detail" class="tab-pane fade in active">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        @if($asset->photo)
                            <a href="{{ $asset->photo->getUrl() }}" target="_blank" style="display: inline-block">
                                <img src="{{ $asset->photo->getUrl() }}" width="200px">
                            </a>
                        @endif
                        &nbsp;&nbsp;
                        {!! QrCode::size(80)->generate($asset->code) !!}
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.asset.fields.code') }}
                                    </th>
                                    <td>
                                        {{ $asset->code }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.asset.fields.serial_number') }}
                                    </th>
                                    <td>
                                        {{ $asset->serial_number }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.asset.fields.license') }}
                                    </th>
                                    <td>
                                        {{ $asset->license->license ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.asset.fields.name') }}
                                    </th>
                                    <td>
                                        {{ $asset->name }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.asset.fields.brand') }}
                                    </th>
                                    <td>
                                        {{ $asset->brand->name ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.asset.fields.category') }}
                                    </th>
                                    <td>
                                        {{ $asset->category->name ?? '' }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>        
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <tbody>                        
                                <tr>
                                    <th>
                                        {{ trans('cruds.asset.fields.supplier') }}
                                    </th>
                                    <td>
                                        {{ $asset->supplier->name ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.asset.fields.date_of_purchase') }}
                                    </th>
                                    <td>
                                        {{ $asset->date_of_purchase }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.asset.fields.quantity') }}
                                    </th>
                                    <td>
                                        {{ $asset->quantity }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.asset.fields.unit_price') }}
                                    </th>
                                    <td>
                                        {{ number_format($asset->unit_price,2) }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.asset.fields.warranty_period') }}
                                    </th>
                                    <td>
                                        {{ $asset->warranty_period }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.asset.fields.depreciation') }}
                                    </th>
                                    <td>
                                        {{ $asset->depreciation }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.asset.fields.status') }}
                                    </th>
                                    <td>
                                        {{ $asset->status->name ?? '' }}
                                    </td>
                                </tr>
                                <!--
                                <tr>
                                    <th>
                                        {{ trans('cruds.asset.fields.location') }}
                                    </th>
                                    <td>
                                        {{ $asset->location->name ?? '' }}
                                    </td>
                                </tr>
                                -->
                                <tr>
                                    <th>
                                        {{ trans('cruds.asset.fields.notes') }}
                                    </th>
                                    <td>
                                        {{ $asset->notes }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.asset.fields.assigned_to') }}
                                    </th>
                                    <td>
                                        {{ $asset->assigned_to->name ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right" colspan="2">
                                        <div class="form-group">
                                            <a class="btn btn-default" href="{{ route('admin.assets.index') }}">
                                                {{ trans('global.back_to_list') }}
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="locations" class="tab-pane fade">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" align="right">
                        <a href="#" class="btn btn-default btn-sm" data-toggle="modal" data-target="#putAsset">Put Asset to Location</a>                        
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class=" table table-bordered table-striped table-hover datatable datatable-locations">
                                <thead>
                                    <tr>
                                        <th width="10"></th>
                                        <th>Location</th>
                                        <th>QTY</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($locations as $key => $locations)
                                    <tr>
                                        <td data-entry-id="{{ $locations->id }}"></td>
                                        <td>{{ $locations->name }}</td>
                                        <td>{{ $locations->quantity }}</td>
                                        <td>
                                            <a href="#" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteLoc">Delete</a>
                                            
                                            <form action="/admin/remove-asset-from-location" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="asset_id" value="{{ $asset->id }}">
                                                <input type="hidden" name="id" value="{{ $locations->id }}">
                                                <div id="deleteLoc" class="modal fade" role="dialog">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-body">
                                                                <p>Are you sure want to delete this record?</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>                                            
                                        </td>
                                    </tr>                                    
                                    @endforeach
                                </tbody>
                            </table>
                        </div>                        
                    </div>
                </div>

                <form method="POST" action="{{ route('admin.save-to-location') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal fade" id="putAsset" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Put Asset to Location</h4>                                        
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="">Asset</label>
                                        <input type="text" class="form-control" value="{{ $asset->serial_number }} - {{ $asset->name }}" readonly />
                                        <input type="hidden" value="{{ $asset->id }}" name="asset_id">
                                    </div>
                                    <div class="form-group">
                                        <label>Add to Location</label><br>
                                        <select name="asset_location_id" id="asset_location_id" class="form-control select2">
                                            @foreach ($asset_location as $assetLoc)
                                            <option value="{{ $assetLoc->id }}">{{ $assetLoc->name }}</option>
                                            @endforeach                                        
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="quantity">Quantity</label>
                                        <input type="text" class="form-control" name="quantity">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-sm btn-primary" name="save">Save</button>
                                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>                

            </div>
        </div>
    </div>
</div>

<!--
<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.asset.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.assets.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.asset.fields.photo') }}
                        </th>
                        <td>
                            @if($asset->photo)
                                <a href="{{ $asset->photo->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $asset->photo->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.asset.fields.code') }}
                        </th>
                        <td>
                            {{ $asset->code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.asset.fields.serial_number') }}
                        </th>
                        <td>
                            {{ $asset->serial_number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.asset.fields.license') }}
                        </th>
                        <td>
                            {{ $asset->license->license ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.asset.fields.name') }}
                        </th>
                        <td>
                            {{ $asset->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.asset.fields.brand') }}
                        </th>
                        <td>
                            {{ $asset->brand->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.asset.fields.category') }}
                        </th>
                        <td>
                            {{ $asset->category->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.asset.fields.supplier') }}
                        </th>
                        <td>
                            {{ $asset->supplier->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.asset.fields.date_of_purchase') }}
                        </th>
                        <td>
                            {{ $asset->date_of_purchase }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.asset.fields.quantity') }}
                        </th>
                        <td>
                            {{ $asset->quantity }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.asset.fields.unit_price') }}
                        </th>
                        <td>
                            {{ $asset->unit_price }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.asset.fields.total') }}
                        </th>
                        <td>
                            {{ $asset->total }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.asset.fields.warranty_period') }}
                        </th>
                        <td>
                            {{ $asset->warranty_period }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.asset.fields.depreciation') }}
                        </th>
                        <td>
                            {{ $asset->depreciation }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.asset.fields.status') }}
                        </th>
                        <td>
                            {{ $asset->status->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.asset.fields.location') }}
                        </th>
                        <td>
                            {{ $asset->location->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.asset.fields.notes') }}
                        </th>
                        <td>
                            {{ $asset->notes }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.asset.fields.assigned_to') }}
                        </th>
                        <td>
                            {{ $asset->assigned_to->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.assets.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>
-->
@endsection

@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('asset_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.assets.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-locations:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection