@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">Accounting</div>
</div>

<div class="row">
    <div class="col-md-2">
        <div class="card">
            <div class="card-body" align="center">
                <img src="{{ URL::to('/') }}/icons/report.png" width="48px" /><br/>                
            </div>
            <div class="card-footer" align="center">
                <a href="{{ route("admin.accounting.show-all-asset-value") }}" target="_blank">Asset by Value</a>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card">
            <div class="card-body" align="center">
                <img src="{{ URL::to('/') }}/icons/location.gif" width="48px" /><br/>                
            </div>
            <div class="card-footer" align="center">
                <a href="{{ route("admin.accounting.asset-by-location") }}" target="_blank">Asset by Location</a>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card">
            <div class="card-body" align="center">
                <img src="{{ URL::to('/') }}/icons/specific-location.png" width="48px" /><br/>                
            </div>
            <div class="card-footer" align="center">
                <a href="{{ route("admin.accounting.asset-by-specific-location") }}">Specific Location</a>
            </div>
        </div>
    </div>
</div>
@endsection