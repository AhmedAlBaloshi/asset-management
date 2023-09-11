@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.licenseManagement.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.licenseManagement.fields.license') }}
                        </th>
                        <td>
                            {{ $licenseManagement->license }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.licenseManagement.fields.title') }}
                        </th>
                        <td>
                            {{ $licenseManagement->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.licenseManagement.fields.description') }}
                        </th>
                        <td>
                            {!! $licenseManagement->description !!}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-success" href="/admin/license-managements/{{$licenseManagement->id}}/edit">
                    <i class="fa fa-edit"></i> 
                    {{ trans('global.edit') }}
                </a>
                <a class="btn btn-default" href="{{ route('admin.license-managements.index') }}">
                    <i class="fa fa-arrow-circle-left"></i> 
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

@endsection