<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Locations;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use Gate;

class LocationsController extends Controller
{
    public function index(){
        abort_if(Gate::denies('locations_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('admin.locations.index');
    }
}
