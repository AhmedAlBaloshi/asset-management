@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.supplier.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.supplier.fields.name') }}
                        </th>
                        <td>
                            {{ $supplier->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.supplier.fields.address') }}
                        </th>
                        <td>
                            {!! $supplier->address !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.supplier.fields.city') }}
                        </th>
                        <td>
                            {{ $supplier->city }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.supplier.fields.country') }}
                        </th>
                        <td>
                            {{ $supplier->country }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.supplier.fields.phone') }}
                        </th>
                        <td>
                            {{ $supplier->phone }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.supplier.fields.email') }}
                        </th>
                        <td>
                            {{ $supplier->email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.supplier.fields.zip') }}
                        </th>
                        <td>
                            {{ $supplier->zip }}
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="form-group">
                <a class="btn btn-success" href="/admin/suppliers/{{$supplier->id}}/edit">
                    <i class="fa fa-edit"></i> 
                    {{ trans('global.edit') }}
                </a>
                <a class="btn btn-default" href="{{ route('admin.suppliers.index') }}">
                    <i class="fa fa-arrow-circle-left"></i> 
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection