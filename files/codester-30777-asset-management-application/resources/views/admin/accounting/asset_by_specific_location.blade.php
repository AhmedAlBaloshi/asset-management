@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                Asset by Specific Location
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route("admin.accounting.show-specific-location") }}" enctype="multipart/form-data" target="_blank">
                    @csrf
                    <div class="form-group">
                        <label for="location">Location</label>
                        <select name="location" class="form-control select2" id="location">
                            @foreach ($list_location as $loc)
                                <option value="{{ $loc->id }}">{{ $loc->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-sm btn-success" value="Show" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
    
@endsection