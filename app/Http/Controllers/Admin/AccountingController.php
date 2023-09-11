<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\AssetLocation;
use App\Models\Locations;
use App\Models\Company;
use Gate;

class AccountingController extends Controller
{
    public function index(){
        abort_if(Gate::denies('accounting_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('admin.accounting.index');
    }

    public function show_all_asset_value(){
        abort_if(Gate::denies('accounting_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $assets = Asset::select('code','name','quantity','unit_price','total')
        ->get();
        $company = Company::first();
        $total_asset = Asset::select(DB::raw('sum(total) as total'))->first();
        $total = $total_asset->total;
        
        return view('admin.accounting.show_all_value',compact('assets','company','total'));
    }

    public function asset_by_location(){
        abort_if(Gate::denies('accounting_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $asset_locations = AssetLocation::get();
        $company = Company::first();
        
        return view('admin.accounting.asset_by_location',compact('company','asset_locations'));
    }

    public static function getAssetsByLocation($asset_location_id){
        $assets = Locations::select('assets.code','assets.name','assets.unit_price','locations.quantity')
        ->join('assets','locations.asset_id','=','assets.id')
        ->where('locations.asset_location_id',$asset_location_id)
        ->get();
        return $assets;
    }

    public static function getTotalAssetsByLocation($asset_location_id){
        //$assets = Locations::select('assets.unit_price','locations.quantity')->get();
    }

    public function asset_by_specific_location(){
        $list_location = AssetLocation::get();
        return view('admin.accounting.asset_by_specific_location',compact('list_location'));
    }

    public function show_specific_location(Request $request){
        $location_id = $request->location;
        $location_name = AssetLocation::where('id',$request->location)->first();
        $assets = Locations::select('assets.code','assets.name','assets.unit_price','locations.quantity')
        ->join('assets','locations.asset_id','=','assets.id')
        ->where('locations.asset_location_id',$request->location)
        ->get();
        $company = Company::first();
        return view('admin.accounting.show_specific_location', compact('assets','location_name','location_id','company'));
    }
}
