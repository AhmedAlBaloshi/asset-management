<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyAssetRequest;
use App\Http\Requests\StoreAssetRequest;
use App\Http\Requests\UpdateAssetRequest;
use App\Models\Asset;
use App\Models\AssetCategory;
use App\Models\AssetLocation;
use App\Models\AssetStatus;
use App\Models\Brand;
use App\Models\LicenseManagement;
use App\Models\Supplier;
use App\Models\User;
use App\Models\Locations;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;

class AssetController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('asset_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $assets = Asset::with(['license', 'brand', 'category', 'supplier', 'status', 'location', 'assigned_to', 'team', 'media'])->get();

        return view('admin.assets.index', compact('assets'));
    }

    public function create()
    {
        abort_if(Gate::denies('asset_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $licenses = LicenseManagement::all()->pluck('license', 'id')->prepend(trans('global.pleaseSelect'), '');
        $brands = Brand::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $categories = AssetCategory::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $suppliers = Supplier::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $statuses = AssetStatus::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $locations = AssetLocation::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $assigned_tos = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        return view('admin.assets.create', compact('licenses', 'brands', 'categories', 'suppliers', 'statuses', 'locations', 'assigned_tos'));
    }

    public function store(StoreAssetRequest $request)
    {
        $asset = Asset::create($request->all());

        if ($request->input('photo', false)) {
            $asset->addMedia(storage_path('tmp/uploads/' . basename($request->input('photo'))))->toMediaCollection('photo');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $asset->id]);
        }
        
        $total = $request->quantity * $request->unit_price;
        $asset_update = Asset::where('id',$asset->id)->update(['total'=>$total]);

        return redirect()->route('admin.assets.index');
    }

    public function edit(Asset $asset)
    {
        abort_if(Gate::denies('asset_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $licenses = LicenseManagement::all()->pluck('license', 'id')->prepend(trans('global.pleaseSelect'), '');
        $brands = Brand::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $categories = AssetCategory::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $suppliers = Supplier::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $statuses = AssetStatus::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $locations = AssetLocation::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $assigned_tos = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $asset->load('license', 'brand', 'category', 'supplier', 'status', 'location', 'assigned_to', 'team');

        return view('admin.assets.edit', compact('licenses', 'brands', 'categories', 'suppliers', 'statuses', 'locations', 'assigned_tos', 'asset'));    }

    public function update(UpdateAssetRequest $request, Asset $asset)
    {
        $asset->update($request->all());

        if ($request->input('photo', false)) {
            if (!$asset->photo || $request->input('photo') !== $asset->photo->file_name) {
                if ($asset->photo) {
                    $asset->photo->delete();
                }
                $asset->addMedia(storage_path('tmp/uploads/' . basename($request->input('photo'))))->toMediaCollection('photo');
            }
        } elseif ($asset->photo) {
            $asset->photo->delete();
        }

        $total = $request->quantity * $request->unit_price;
        $asset_update = Asset::where('id',$asset->id)->update(['total'=>$total]);

        return redirect()->route('admin.assets.index');
    }

    public function show(Asset $asset)
    {
        abort_if(Gate::denies('asset_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $asset->load('license', 'brand', 'category', 'supplier', 'status', 'location', 'assigned_to', 'team');
        $locations = Locations::select('asset_locations.name','locations.*')
        ->join('asset_locations','locations.asset_location_id','=','asset_locations.id')
        ->where('asset_id','=',$asset->id)
        ->get();
        $asset_location = AssetLocation::whereNull('deleted_at')->get();
        $assetInLocation = Locations::where('asset_id','=',$asset->id)
        ->count();

        return view('admin.assets.show', compact('asset','locations','asset_location','assetInLocation'));
    }

    public function destroy(Asset $asset)
    {
        abort_if(Gate::denies('asset_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $asset->delete();

        return back();
    }

    public function massDestroy(MassDestroyAssetRequest $request)
    {
        Asset::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('asset_create') && Gate::denies('asset_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Asset();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }

    public function save_to_location(Request $request){
        $locations = new Locations();
        $locations->asset_id = $request->asset_id;
        $locations->asset_location_id = $request->asset_location_id;
        $locations->quantity = $request->quantity;
        $locations->save();
        
        return redirect('/admin/assets/'.$request->asset_id);
    }

    public function remove_asset_from_location(Request $request){
        $locations = Locations::where('id',$request->id)->delete();
        return redirect('/admin/assets/'.$request->asset_id);
    }
}
