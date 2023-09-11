<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AssetsHistory;
use App\Models\Locations;
use App\Models\Assets;
use App\Models\AssetLocation;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AssetsHistoryController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('assets_history_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $assetLocation = Locations::select('locations.updated_at','locations.created_at as created_at','assets.code as code','assets.name as name','asset_locations.name as location_name','locations.quantity as quantity')
        ->join('assets','locations.asset_id','=','assets.id')
        ->join('asset_locations','locations.asset_location_id','=','asset_locations.id')
        ->orderBy('locations.updated_at')
        ->get();

        //$assetsHistories = AssetsHistory::with(['asset', 'status', 'location', 'assigned_user', 'team'])->get();

        return view('admin.assetsHistories.index', compact('assetLocation'));
    }
}
