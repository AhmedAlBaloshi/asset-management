@extends('layouts.admin')
@section('content')
@can('asset_create')
<div style="margin-bottom: 10px;" class="row">
    <div class="col-lg-12 d-flex">
        <a class="btn btn-success" style="height: 38px" href="{{ route('admin.assets.create') }}">
            {{ trans('global.add') }} {{ trans('cruds.asset.title_singular') }}
        </a>

        <form action="{{ route('admin.assets.processexcel') }}" id="import-excel" method="POST" enctype="multipart/form-data">
            @csrf
            <label for="fileInput" class="file-input-label">
                <span class="mx-2 btn btn-success">Import Excel</span>
                <input type="file" id="fileInput" onchange="submitImport(event)" name="file" style="display: none;" accept=".xlsx, .xls, .csv">
            </label>
        </form>

        <a class="btn btn-success" style="height: 38px" href="{{ route('admin.assets.sample') }}">
            Download Sample
        </a>

    </div>

</div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.asset.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Asset">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            QRCode
                        </th>
                        <th>
                            {{ trans('cruds.asset.fields.photo') }}
                        </th>
                        <th>
                            {{ trans('cruds.asset.fields.code') }}
                        </th>
                        <th>
                            {{ trans('cruds.asset.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.asset.fields.quantity') }}
                        </th>
                        <th>
                            {{ trans('cruds.asset.fields.unit_price') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($assets as $key => $asset)
                    <tr data-entry-id="{{ $asset->id }}">
                        <td>

                        </td>
                        <td>
                            @php
                            $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
                            $departCode = $asset->department?$asset->department->code.'-':'';
                            $locationCode = $asset->location?$asset->location->code.'-':'';

                        @endphp
                        {!! $generator->getBarcode($departCode.$locationCode.$asset->code, $generator::TYPE_CODE_128, 2, 50) !!}
                        </td>
                        <td>
                            @if($asset->photo)
                            <a href="{{ $asset->photo->getUrl() }}" target="_blank" style="display: inline-block">
                                <img src="{{ $asset->photo->getUrl('thumb') }}">
                            </a>
                            @endif
                        </td>
                        <td>
                            {{ $departCode.$locationCode.$asset->code ?? '' }}
                        </td>
                        <td>
                            {{ $asset->name ?? '' }}
                        </td>
                        <td>
                            {{ $asset->quantity ?? '' }}
                        </td>
                        <td align="right">
                            {{ number_format($asset->unit_price,2) ?? '' }}
                        </td>
                        <td>
                            @can('asset_show')
                            <a class="btn btn-xs btn-primary" href="{{ route('admin.assets.show', $asset->id) }}">
                                {{ trans('global.view') }}
                            </a>
                            @endcan

                            @can('asset_edit')
                            <a class="btn btn-xs btn-info" href="{{ route('admin.assets.edit', $asset->id) }}">
                                {{ trans('global.edit') }}
                            </a>
                            @endcan

                            @can('asset_delete')
                            <form action="{{ route('admin.assets.destroy', $asset->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                            </form>
                            @endcan

                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<div id="toastr-container"></div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
@if ($errors->any())
<script>
    // Display Toastr notification for validation error
    toastr.error('{{ $errors->first("message") }}', 'Validation Error');

</script>
@endif

<script>
    function submitImport(event) {
        const selectedFile = event.target.files[0];
        $('#import-excel').submit()
    }

</script>

@endsection
@section('scripts')
@parent
<script>
    $(function() {
        let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
        @can('asset_delete')
        let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
        let deleteButton = {
            text: deleteButtonTrans
            , url: "{{ route('admin.assets.massDestroy') }}"
            , className: 'btn-danger'
            , action: function(e, dt, node, config) {
                var ids = $.map(dt.rows({
                    selected: true
                }).nodes(), function(entry) {
                    return $(entry).data('entry-id')
                });

                if (ids.length === 0) {
                    alert('{{ trans('global.datatables.zero_selected') }}')

                    return
                }

                if (confirm('{{ trans('global.areYouSure') }}')) {
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
        @endcan

        let downloadButtonTrans = '{{ trans("Download QRs") }}';
let downloadButton = {
    text: downloadButtonTrans,
    className: 'btn-primary', // Change the class name to style the button as needed.
    action: function(e, dt, node, config) {
        var ids = $.map(dt.rows({
            selected: true
        }).nodes(), function(entry) {
            return $(entry).data('entry-id');
        });

        if (ids.length === 0) {
            alert('{{ trans('global.datatables.zero_selected') }}');
            return;
        }
        let url = "{{ route('admin.assets.downloadQR') }}";
        var queryString = ids.map(function(id) {
  return 'ids%5B%5D=' + encodeURIComponent(id);
}).join('&');

        window.location.href = url+'?'+queryString
    }
};

// Add the download button to the dtButtons array.
dtButtons.push(downloadButton);

        $.extend(true, $.fn.dataTable.defaults, {
            orderCellsTop: true
            , order: [
                [2, 'desc']
            ]
            , pageLength: 100
        , });
        let table = $('.datatable-Asset:not(.ajaxTable)').DataTable({
            buttons: dtButtons
        })
        $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });
    })

</script>
@endsection
