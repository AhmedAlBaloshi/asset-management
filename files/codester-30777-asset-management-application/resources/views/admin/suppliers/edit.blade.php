@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.supplier.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.suppliers.update", [$supplier->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf

            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label class="required" for="name">{{ trans('cruds.supplier.fields.name') }}</label>
                  <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $supplier->name) }}" required>
                  @if($errors->has('name'))
                      <span class="text-danger">{{ $errors->first('name') }}</span>
                  @endif
                  <span class="help-block">{{ trans('cruds.supplier.fields.name_helper') }}</span>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="phone">{{ trans('cruds.supplier.fields.phone') }}</label>
                  <input class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" type="text" name="phone" id="phone" value="{{ old('phone', $supplier->phone) }}">
                  @if($errors->has('phone'))
                      <span class="text-danger">{{ $errors->first('phone') }}</span>
                  @endif
                  <span class="help-block">{{ trans('cruds.supplier.fields.phone_helper') }}</span>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="email">{{ trans('cruds.supplier.fields.email') }}</label>
                  <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="text" name="email" id="email" value="{{ old('email', $supplier->email) }}">
                  @if($errors->has('email'))
                      <span class="text-danger">{{ $errors->first('email') }}</span>
                  @endif
                  <span class="help-block">{{ trans('cruds.supplier.fields.email_helper') }}</span>
                </div>
              </div>
            </div>

            <div class="form-group">
                <label for="address">{{ trans('cruds.supplier.fields.address') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('address') ? 'is-invalid' : '' }}" name="address" id="address">{!! old('address', $supplier->address) !!}</textarea>
                @if($errors->has('address'))
                    <span class="text-danger">{{ $errors->first('address') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.supplier.fields.address_helper') }}</span>
            </div>

            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="city">{{ trans('cruds.supplier.fields.city') }}</label>
                  <input class="form-control {{ $errors->has('city') ? 'is-invalid' : '' }}" type="text" name="city" id="city" value="{{ old('city', $supplier->city) }}">
                  @if($errors->has('city'))
                      <span class="text-danger">{{ $errors->first('city') }}</span>
                  @endif
                  <span class="help-block">{{ trans('cruds.supplier.fields.city_helper') }}</span>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="country">{{ trans('cruds.supplier.fields.country') }}</label>
                  <input class="form-control {{ $errors->has('country') ? 'is-invalid' : '' }}" type="text" name="country" id="country" value="{{ old('country', $supplier->country) }}">
                  @if($errors->has('country'))
                      <span class="text-danger">{{ $errors->first('country') }}</span>
                  @endif
                  <span class="help-block">{{ trans('cruds.supplier.fields.country_helper') }}</span>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="zip">{{ trans('cruds.supplier.fields.zip') }}</label>
                  <input class="form-control {{ $errors->has('zip') ? 'is-invalid' : '' }}" type="text" name="zip" id="zip" value="{{ old('zip', $supplier->zip) }}">
                  @if($errors->has('zip'))
                      <span class="text-danger">{{ $errors->first('zip') }}</span>
                  @endif
                  <span class="help-block">{{ trans('cruds.supplier.fields.zip_helper') }}</span>
                </div>
              </div>
            </div>      
            
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection

@section('scripts')
<script>
    $(document).ready(function () {
  function SimpleUploadAdapter(editor) {
    editor.plugins.get('FileRepository').createUploadAdapter = function(loader) {
      return {
        upload: function() {
          return loader.file
            .then(function (file) {
              return new Promise(function(resolve, reject) {
                // Init request
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '{{ route('admin.suppliers.storeCKEditorImages') }}', true);
                xhr.setRequestHeader('x-csrf-token', window._token);
                xhr.setRequestHeader('Accept', 'application/json');
                xhr.responseType = 'json';

                // Init listeners
                var genericErrorText = `Couldn't upload file: ${ file.name }.`;
                xhr.addEventListener('error', function() { reject(genericErrorText) });
                xhr.addEventListener('abort', function() { reject() });
                xhr.addEventListener('load', function() {
                  var response = xhr.response;

                  if (!response || xhr.status !== 201) {
                    return reject(response && response.message ? `${genericErrorText}\n${xhr.status} ${response.message}` : `${genericErrorText}\n ${xhr.status} ${xhr.statusText}`);
                  }

                  $('form').append('<input type="hidden" name="ck-media[]" value="' + response.id + '">');

                  resolve({ default: response.url });
                });

                if (xhr.upload) {
                  xhr.upload.addEventListener('progress', function(e) {
                    if (e.lengthComputable) {
                      loader.uploadTotal = e.total;
                      loader.uploaded = e.loaded;
                    }
                  });
                }

                // Send request
                var data = new FormData();
                data.append('upload', file);
                data.append('crud_id', '{{ $supplier->id ?? 0 }}');
                xhr.send(data);
              });
            })
        }
      };
    }
  }

  var allEditors = document.querySelectorAll('.ckeditor');
  for (var i = 0; i < allEditors.length; ++i) {
    ClassicEditor.create(
      allEditors[i], {
        extraPlugins: [SimpleUploadAdapter]
      }
    );
  }
});
</script>

@endsection