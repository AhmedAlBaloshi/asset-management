@extends('layouts.admin')
@section('content')

<form method="POST" action="{{ route("admin.assets.update", [$asset->id]) }}" enctype="multipart/form-data">
    @method('PUT')
    @csrf
    <div class="form-group">
        <input type="hidden" value="1" name="location_id">
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label class="required" for="code">{{ trans('cruds.asset.fields.code') }}</label>
                        <input class="form-control {{ $errors->has('code') ? 'is-invalid' : '' }}" type="text" name="code" id="code" value="{{ old('code', $asset->code) }}" required>
                        @if($errors->has('code'))
                            <span class="text-danger">{{ $errors->first('code') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.asset.fields.code_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label for="serial_number">{{ trans('cruds.asset.fields.serial_number') }}</label>
                        <input class="form-control {{ $errors->has('serial_number') ? 'is-invalid' : '' }}" type="text" name="serial_number" id="serial_number" value="{{ old('serial_number', $asset->serial_number) }}">
                        @if($errors->has('serial_number'))
                            <span class="text-danger">{{ $errors->first('serial_number') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.asset.fields.serial_number_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label for="license_id">{{ trans('cruds.asset.fields.license') }}</label>
                        <select class="form-control select2 {{ $errors->has('license') ? 'is-invalid' : '' }}" name="license_id" id="license_id">
                            @foreach($licenses as $id => $license)
                                <option value="{{ $id }}" {{ (old('license_id') ? old('license_id') : $asset->license->id ?? '') == $id ? 'selected' : '' }}>{{ $license }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('license'))
                            <span class="text-danger">{{ $errors->first('license') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.asset.fields.license_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label class="required" for="name">{{ trans('cruds.asset.fields.name') }}</label>
                        <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $asset->name) }}" required>
                        @if($errors->has('name'))
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.asset.fields.name_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label for="brand_id">{{ trans('cruds.asset.fields.brand') }}</label>
                        <select class="form-control select2 {{ $errors->has('brand') ? 'is-invalid' : '' }}" name="brand_id" id="brand_id">
                            @foreach($brands as $id => $brand)
                                <option value="{{ $id }}" {{ (old('brand_id') ? old('brand_id') : $asset->brand->id ?? '') == $id ? 'selected' : '' }}>{{ $brand }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('brand'))
                            <span class="text-danger">{{ $errors->first('brand') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.asset.fields.brand_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label class="required" for="category_id">{{ trans('cruds.asset.fields.category') }}</label>
                        <select class="form-control select2 {{ $errors->has('category') ? 'is-invalid' : '' }}" name="category_id" id="category_id" required>
                            @foreach($categories as $id => $category)
                                <option value="{{ $id }}" {{ (old('category_id') ? old('category_id') : $asset->category->id ?? '') == $id ? 'selected' : '' }}>{{ $category }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('category'))
                            <span class="text-danger">{{ $errors->first('category') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.asset.fields.category_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label for="department_id">{{ trans('Department') }}</label>
                        <select class="form-control select2 {{ $errors->has('department') ? 'is-invalid' : '' }}" name="department_id" id="department_id">
                            @foreach($departments as $id => $department)
                                <option value="{{ $id }}" {{ (old('department_id') ? old('department_id') : $asset->department->id ?? '') == $id ? 'selected' : '' }}>{{ $department }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('department'))
                            <span class="text-danger">{{ $errors->first('department') }}</span>
                        @endif
                        {{-- <span class="help-block">{{ trans('cruds.asset.fields.category_helper') }}</span> --}}
                    </div>
                    <div class="form-group">
                        <label for="supplier_id">{{ trans('cruds.asset.fields.supplier') }}</label>
                        <select class="form-control select2 {{ $errors->has('supplier') ? 'is-invalid' : '' }}" name="supplier_id" id="supplier_id">
                            @foreach($suppliers as $id => $supplier)
                                <option value="{{ $id }}" {{ (old('supplier_id') ? old('supplier_id') : $asset->supplier->id ?? '') == $id ? 'selected' : '' }}>{{ $supplier }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('supplier'))
                            <span class="text-danger">{{ $errors->first('supplier') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.asset.fields.supplier_helper') }}</span>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label class="required" for="status_id">{{ trans('cruds.asset.fields.status') }}</label>
                        <select class="form-control select2 {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status_id" id="status_id" required>
                            @foreach($statuses as $id => $status)
                                <option value="{{ $id }}" {{ (old('status_id') ? old('status_id') : $asset->status->id ?? '') == $id ? 'selected' : '' }}>{{ $status }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('status'))
                            <span class="text-danger">{{ $errors->first('status') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.asset.fields.status_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label for="notes">{{ trans('cruds.asset.fields.notes') }}</label>
                        <textarea class="form-control {{ $errors->has('notes') ? 'is-invalid' : '' }}" name="notes" id="notes">{{ old('notes', $asset->notes) }}</textarea>
                        @if($errors->has('notes'))
                            <span class="text-danger">{{ $errors->first('notes') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.asset.fields.notes_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label for="assigned_to_id">{{ trans('cruds.asset.fields.assigned_to') }}</label>
                        <select class="form-control select2 {{ $errors->has('assigned_to') ? 'is-invalid' : '' }}" name="assigned_to_id" id="assigned_to_id">
                            @foreach($assigned_tos as $id => $assigned_to)
                                <option value="{{ $id }}" {{ (old('assigned_to_id') ? old('assigned_to_id') : $asset->assigned_to->id ?? '') == $id ? 'selected' : '' }}>{{ $assigned_to }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('assigned_to'))
                            <span class="text-danger">{{ $errors->first('assigned_to') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.asset.fields.assigned_to_helper') }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="photo">{{ trans('cruds.asset.fields.photo') }}</label>
                        <div class="needsclick dropzone {{ $errors->has('photo') ? 'is-invalid' : '' }}" id="photo-dropzone">
                        </div>
                        @if($errors->has('photo'))
                            <span class="text-danger">{{ $errors->first('photo') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.asset.fields.photo_helper') }}</span>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="date_of_purchase">{{ trans('cruds.asset.fields.date_of_purchase') }}</label>
                        <input class="form-control date {{ $errors->has('date_of_purchase') ? 'is-invalid' : '' }}" type="text" name="date_of_purchase" id="date_of_purchase" value="{{ old('date_of_purchase', $asset->date_of_purchase) }}">
                        @if($errors->has('date_of_purchase'))
                            <span class="text-danger">{{ $errors->first('date_of_purchase') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.asset.fields.date_of_purchase_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label class="required" for="quantity">{{ trans('cruds.asset.fields.quantity') }}</label>
                        <input class="form-control {{ $errors->has('quantity') ? 'is-invalid' : '' }}" type="number" name="quantity" id="quantity" value="{{ old('quantity', $asset->quantity) }}" step="0.01" required>
                        @if($errors->has('quantity'))
                            <span class="text-danger">{{ $errors->first('quantity') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.asset.fields.quantity_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label for="unit_price">{{ trans('cruds.asset.fields.unit_price') }}</label>
                        <input class="form-control {{ $errors->has('unit_price') ? 'is-invalid' : '' }}" type="number" name="unit_price" id="unit_price" value="{{ old('unit_price', $asset->unit_price) }}" step="0.01">
                        @if($errors->has('unit_price'))
                            <span class="text-danger">{{ $errors->first('unit_price') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.asset.fields.unit_price_helper') }}</span>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="warranty_period">{{ trans('cruds.asset.fields.warranty_period') }}</label>
                        <input class="form-control {{ $errors->has('warranty_period') ? 'is-invalid' : '' }}" type="text" name="warranty_period" id="warranty_period" value="{{ old('warranty_period', $asset->warranty_period) }}">
                        @if($errors->has('warranty_period'))
                            <span class="text-danger">{{ $errors->first('warranty_period') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.asset.fields.warranty_period_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label for="depreciation">{{ trans('cruds.asset.fields.depreciation') }}</label>
                        <input class="form-control {{ $errors->has('depreciation') ? 'is-invalid' : '' }}" type="text" name="depreciation" id="depreciation" value="{{ old('depreciation', $asset->depreciation) }}">
                        @if($errors->has('depreciation'))
                            <span class="text-danger">{{ $errors->first('depreciation') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.asset.fields.depreciation_helper') }}</span>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <button class="btn btn-danger" type="submit">
                            {{ trans('global.save') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<!--
<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.asset.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.assets.update", [$asset->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="photo">{{ trans('cruds.asset.fields.photo') }}</label>
                <div class="needsclick dropzone {{ $errors->has('photo') ? 'is-invalid' : '' }}" id="photo-dropzone">
                </div>
                @if($errors->has('photo'))
                    <span class="text-danger">{{ $errors->first('photo') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.asset.fields.photo_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="code">{{ trans('cruds.asset.fields.code') }}</label>
                <input class="form-control {{ $errors->has('code') ? 'is-invalid' : '' }}" type="text" name="code" id="code" value="{{ old('code', $asset->code) }}" required>
                @if($errors->has('code'))
                    <span class="text-danger">{{ $errors->first('code') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.asset.fields.code_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="serial_number">{{ trans('cruds.asset.fields.serial_number') }}</label>
                <input class="form-control {{ $errors->has('serial_number') ? 'is-invalid' : '' }}" type="text" name="serial_number" id="serial_number" value="{{ old('serial_number', $asset->serial_number) }}">
                @if($errors->has('serial_number'))
                    <span class="text-danger">{{ $errors->first('serial_number') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.asset.fields.serial_number_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="license_id">{{ trans('cruds.asset.fields.license') }}</label>
                <select class="form-control select2 {{ $errors->has('license') ? 'is-invalid' : '' }}" name="license_id" id="license_id">
                    @foreach($licenses as $id => $license)
                        <option value="{{ $id }}" {{ (old('license_id') ? old('license_id') : $asset->license->id ?? '') == $id ? 'selected' : '' }}>{{ $license }}</option>
                    @endforeach
                </select>
                @if($errors->has('license'))
                    <span class="text-danger">{{ $errors->first('license') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.asset.fields.license_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.asset.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $asset->name) }}" required>
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.asset.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="brand_id">{{ trans('cruds.asset.fields.brand') }}</label>
                <select class="form-control select2 {{ $errors->has('brand') ? 'is-invalid' : '' }}" name="brand_id" id="brand_id">
                    @foreach($brands as $id => $brand)
                        <option value="{{ $id }}" {{ (old('brand_id') ? old('brand_id') : $asset->brand->id ?? '') == $id ? 'selected' : '' }}>{{ $brand }}</option>
                    @endforeach
                </select>
                @if($errors->has('brand'))
                    <span class="text-danger">{{ $errors->first('brand') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.asset.fields.brand_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="category_id">{{ trans('cruds.asset.fields.category') }}</label>
                <select class="form-control select2 {{ $errors->has('category') ? 'is-invalid' : '' }}" name="category_id" id="category_id" required>
                    @foreach($categories as $id => $category)
                        <option value="{{ $id }}" {{ (old('category_id') ? old('category_id') : $asset->category->id ?? '') == $id ? 'selected' : '' }}>{{ $category }}</option>
                    @endforeach
                </select>
                @if($errors->has('category'))
                    <span class="text-danger">{{ $errors->first('category') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.asset.fields.category_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="supplier_id">{{ trans('cruds.asset.fields.supplier') }}</label>
                <select class="form-control select2 {{ $errors->has('supplier') ? 'is-invalid' : '' }}" name="supplier_id" id="supplier_id">
                    @foreach($suppliers as $id => $supplier)
                        <option value="{{ $id }}" {{ (old('supplier_id') ? old('supplier_id') : $asset->supplier->id ?? '') == $id ? 'selected' : '' }}>{{ $supplier }}</option>
                    @endforeach
                </select>
                @if($errors->has('supplier'))
                    <span class="text-danger">{{ $errors->first('supplier') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.asset.fields.supplier_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="date_of_purchase">{{ trans('cruds.asset.fields.date_of_purchase') }}</label>
                <input class="form-control date {{ $errors->has('date_of_purchase') ? 'is-invalid' : '' }}" type="text" name="date_of_purchase" id="date_of_purchase" value="{{ old('date_of_purchase', $asset->date_of_purchase) }}">
                @if($errors->has('date_of_purchase'))
                    <span class="text-danger">{{ $errors->first('date_of_purchase') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.asset.fields.date_of_purchase_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="quantity">{{ trans('cruds.asset.fields.quantity') }}</label>
                <input class="form-control {{ $errors->has('quantity') ? 'is-invalid' : '' }}" type="number" name="quantity" id="quantity" value="{{ old('quantity', $asset->quantity) }}" step="0.01" required>
                @if($errors->has('quantity'))
                    <span class="text-danger">{{ $errors->first('quantity') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.asset.fields.quantity_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="unit_price">{{ trans('cruds.asset.fields.unit_price') }}</label>
                <input class="form-control {{ $errors->has('unit_price') ? 'is-invalid' : '' }}" type="number" name="unit_price" id="unit_price" value="{{ old('unit_price', $asset->unit_price) }}" step="0.01">
                @if($errors->has('unit_price'))
                    <span class="text-danger">{{ $errors->first('unit_price') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.asset.fields.unit_price_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="total">{{ trans('cruds.asset.fields.total') }}</label>
                <input class="form-control {{ $errors->has('total') ? 'is-invalid' : '' }}" type="number" name="total" id="total" value="{{ old('total', $asset->total) }}" step="0.01">
                @if($errors->has('total'))
                    <span class="text-danger">{{ $errors->first('total') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.asset.fields.total_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="warranty_period">{{ trans('cruds.asset.fields.warranty_period') }}</label>
                <input class="form-control {{ $errors->has('warranty_period') ? 'is-invalid' : '' }}" type="text" name="warranty_period" id="warranty_period" value="{{ old('warranty_period', $asset->warranty_period) }}">
                @if($errors->has('warranty_period'))
                    <span class="text-danger">{{ $errors->first('warranty_period') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.asset.fields.warranty_period_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="depreciation">{{ trans('cruds.asset.fields.depreciation') }}</label>
                <input class="form-control {{ $errors->has('depreciation') ? 'is-invalid' : '' }}" type="text" name="depreciation" id="depreciation" value="{{ old('depreciation', $asset->depreciation) }}">
                @if($errors->has('depreciation'))
                    <span class="text-danger">{{ $errors->first('depreciation') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.asset.fields.depreciation_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="status_id">{{ trans('cruds.asset.fields.status') }}</label>
                <select class="form-control select2 {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status_id" id="status_id" required>
                    @foreach($statuses as $id => $status)
                        <option value="{{ $id }}" {{ (old('status_id') ? old('status_id') : $asset->status->id ?? '') == $id ? 'selected' : '' }}>{{ $status }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <span class="text-danger">{{ $errors->first('status') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.asset.fields.status_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="location_id">{{ trans('cruds.asset.fields.location') }}</label>
                <select class="form-control select2 {{ $errors->has('location') ? 'is-invalid' : '' }}" name="location_id" id="location_id" required>
                    @foreach($locations as $id => $location)
                        <option value="{{ $id }}" {{ (old('location_id') ? old('location_id') : $asset->location->id ?? '') == $id ? 'selected' : '' }}>{{ $location }}</option>
                    @endforeach
                </select>
                @if($errors->has('location'))
                    <span class="text-danger">{{ $errors->first('location') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.asset.fields.location_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="notes">{{ trans('cruds.asset.fields.notes') }}</label>
                <textarea class="form-control {{ $errors->has('notes') ? 'is-invalid' : '' }}" name="notes" id="notes">{{ old('notes', $asset->notes) }}</textarea>
                @if($errors->has('notes'))
                    <span class="text-danger">{{ $errors->first('notes') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.asset.fields.notes_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="assigned_to_id">{{ trans('cruds.asset.fields.assigned_to') }}</label>
                <select class="form-control select2 {{ $errors->has('assigned_to') ? 'is-invalid' : '' }}" name="assigned_to_id" id="assigned_to_id">
                    @foreach($assigned_tos as $id => $assigned_to)
                        <option value="{{ $id }}" {{ (old('assigned_to_id') ? old('assigned_to_id') : $asset->assigned_to->id ?? '') == $id ? 'selected' : '' }}>{{ $assigned_to }}</option>
                    @endforeach
                </select>
                @if($errors->has('assigned_to'))
                    <span class="text-danger">{{ $errors->first('assigned_to') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.asset.fields.assigned_to_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>
-->


@endsection

@section('scripts')
<script>
    Dropzone.options.photoDropzone = {
    url: '{{ route('admin.assets.storeMedia') }}',
    maxFilesize: 2, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').find('input[name="photo"]').remove()
      $('form').append('<input type="hidden" name="photo" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="photo"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($asset) && $asset->photo)
      var file = {!! json_encode($asset->photo) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, file.preview)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="photo" value="' + file.file_name + '">')
      this.options.maxFiles = this.options.maxFiles - 1
@endif
    },
    error: function (file, response) {
        if ($.type(response) === 'string') {
            var message = response //dropzone sends it's own error messages in string
        } else {
            var message = response.errors.file
        }
        file.previewElement.classList.add('dz-error')
        _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
        _results = []
        for (_i = 0, _len = _ref.length; _i < _len; _i++) {
            node = _ref[_i]
            _results.push(node.textContent = message)
        }

        return _results
    }
}
</script>
@endsection
