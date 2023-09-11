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
use App\Models\Departments;
use App\Models\LicenseManagement;
use App\Models\Supplier;
use App\Models\User;
use App\Models\Locations;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class AssetController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('asset_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $assets = Asset::with(['license', 'brand', 'category', 'department', 'supplier', 'status', 'location', 'assigned_to', 'team', 'media'])->get();

        return view('admin.assets.index', compact('assets'));
    }

    public function create()
    {
        abort_if(Gate::denies('asset_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $licenses = LicenseManagement::all()->pluck('license', 'id')->prepend(trans('global.pleaseSelect'), '');
        $brands = Brand::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $categories = AssetCategory::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $departments = Departments::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $suppliers = Supplier::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $statuses = AssetStatus::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $locations = AssetLocation::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $assigned_tos = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        return view('admin.assets.create', compact('licenses', 'brands', 'categories', 'suppliers', 'statuses', 'locations', 'assigned_tos', 'departments'));
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
        $asset_update = Asset::where('id', $asset->id)->update(['total' => $total]);

        return redirect()->route('admin.assets.index');
    }

    public function edit(Asset $asset)
    {
        abort_if(Gate::denies('asset_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $licenses = LicenseManagement::all()->pluck('license', 'id')->prepend(trans('global.pleaseSelect'), '');
        $brands = Brand::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $categories = AssetCategory::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $departments = Departments::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $suppliers = Supplier::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $statuses = AssetStatus::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $locations = AssetLocation::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $assigned_tos = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $asset->load('license', 'brand', 'category', 'supplier', 'status', 'location', 'assigned_to', 'team');

        return view('admin.assets.edit', compact('licenses', 'brands', 'categories', 'departments', 'suppliers', 'statuses', 'locations', 'assigned_tos', 'asset'));
    }

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
        $asset_update = Asset::where('id', $asset->id)->update(['total' => $total]);

        return redirect()->route('admin.assets.index');
    }

    public function show(Asset $asset)
    {
        abort_if(Gate::denies('asset_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $asset->load('license', 'brand', 'category', 'supplier', 'status', 'location', 'assigned_to', 'team');
        $locations = Locations::select('asset_locations.name', 'locations.*')
            ->join('asset_locations', 'locations.asset_location_id', '=', 'asset_locations.id')
            ->where('asset_id', '=', $asset->id)
            ->get();
        $asset_location = AssetLocation::whereNull('deleted_at')->get();
        $assetInLocation = Locations::where('asset_id', '=', $asset->id)
            ->count();

        return view('admin.assets.show', compact('asset', 'locations', 'asset_location', 'assetInLocation'));
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

    public function save_to_location(Request $request)
    {
        $locations = new Locations();
        $locations->asset_id = $request->asset_id;
        $locations->asset_location_id = $request->asset_location_id;
        $locations->quantity = $request->quantity;
        $locations->save();

        return redirect('/admin/assets/' . $request->asset_id);
    }

    public function remove_asset_from_location(Request $request)
    {
        $locations = Locations::where('id', $request->id)->delete();
        return redirect('/admin/assets/' . $request->asset_id);
    }

    public function processExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xlsx,xls',
        ]);

        $emptyCode = 0;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $excelData = IOFactory::load($file);
            $worksheet = $excelData->getActiveSheet();
            $rowData = [];
            foreach ($worksheet->getRowIterator() as $row) {
                $cellIterator = $row->getCellIterator();
                $cellData = [];
                foreach ($cellIterator as $cell) {
                    $cellData[] = $cell->getValue();
                }
                if (!empty(array_filter($cellData, function ($value) {
                    return  $value !== null ? $value : null;
                }))) {
                    $rowData[] = $cellData;
                }
            }
            // Initialize an empty array to store the result
            $keys = $rowData[0];
            $result = [];

            // Iterate through the remaining sub-arrays
            for ($i = 1; $i < count($rowData); $i++) {
                $row = $rowData[$i];
                $rowAssoc = [];

                // Create an associative array using keys and values
                for ($j = 0; $j < count($keys); $j++) {
                    if ($keys[$j] == "Model No/ Code") {
                        $key = 'code';
                    } else if ($keys[$j] == "Description") {
                        $key = 'note';
                    } else if ($keys[$j] == "Assets Name") {
                        $key = 'name';
                    } else if ($keys[$j] == "Assets Category") {
                        $key = 'category_id';
                    } else if ($keys[$j] == "Qty") {
                        $key = 'quantity';
                    } else if ($keys[$j] == "EN NUMBER ") {
                        $key = 'serial_number';
                    } else if ($keys[$j] == "Location") {
                        $key = 'location_id';
                    } else if ($keys[$j] == "Department") {
                        $key = 'department_id';
                    } else {
                        $key = $keys[$j];
                    }
                    $value = $row[$j];
                    $rowAssoc[$key] = $value;
                }
                // $location = ;
                if ($rowAssoc['location_id'] !== null) {
                    $location = AssetLocation::where('name', $rowAssoc['location_id'])->first();
                    if (!$location) {
                        $location = new AssetLocation();
                        $location->name = $rowAssoc['location_id'];
                        $location->save();
                    }
                    $rowAssoc['location_id'] = $location ? $location->id : null;
                }
                if ($rowAssoc['department_id'] !== null) {
                    $department = Departments::where('name', $rowAssoc['department_id'])->first();
                    if (!$department) {
                        $department = new Departments();
                        $department->name = $rowAssoc['department_id'];
                        $department->save();
                    }
                    $rowAssoc['department_id'] = $department ? $department->id : null;
                }
                if ($rowAssoc['category_id'] !== null) {
                    $category = AssetCategory::where('name', $rowAssoc['category_id'])->first();
                    if (!$category) {
                        $category = new AssetCategory();
                        $category->name = $rowAssoc['category_id'];
                        $category->save();
                    }
                    $rowAssoc['category_id'] = $category ? $category->id : null;
                }

                // Add the associative array to the result


                $status = AssetStatus::where('name', 'Available')->first();
                $rowAssoc['status_id'] = $status->id;

                $rowAssoc["license_id"] = null;
                $rowAssoc["brand_id"] = null;
                $rowAssoc["supplier_id"] = null;
                $rowAssoc["assigned_to_id"] = null;
                $rowAssoc["date_of_purchase"] = null;
                $rowAssoc["unit_price"] = null;
                $rowAssoc["warranty_period"] = null;
                $rowAssoc["depreciation"] = null;

                $result[] = $rowAssoc;

                if (!$rowAssoc['code'])
                    $emptyCode++;
            }

            if ($emptyCode > 0) {
                return redirect()->route('admin.assets.index')
                    ->withErrors(['message' => 'The Model No/ Code column must not be empty.'])
                    ->withInput();
            }
            for ($i = 0; $i < count($result); $i++) {
                if (Asset::where('code', $result[$i]['code'])->first()) {
                    return redirect()->route('admin.assets.index')
                        ->withErrors(['message' => 'The Model No/Code must be unique.'])
                        ->withInput();
                }
                $asset = Asset::create($result[$i]);
                $total = $request->quantity * $request->unit_price;
                $asset_update = Asset::where('id', $asset->id)->update(['total' => $total]);
            }
            return redirect()->route('admin.assets.index');
        }
    }

    public function sampleExcelFile()
    {
        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();

        $headers = [
            'Department',
            'Location',
            'Assets Category',
            'Assets Name',
            'Description',
            'Model No/Code',
            'Qty',
            'EN NUMBER',
        ];

        $sheet->fromArray([$headers], null, 'A1');
        $dummyData = [
            ['Finance', 'Finance Office', 'Electronics', 'Laptop', 'High-performance laptop', 'L123', 5, 123456],
            ['HR', 'HR Office', 'Furniture', 'Desk', 'Wooden desk', 'D789', 2, 789012],
        ];

        $sheet->fromArray($dummyData, null, 'A2');

        $tempFile = tempnam(sys_get_temp_dir(), 'excel');

        $writer = new Xlsx($spreadsheet);
        $writer->save($tempFile);
        return response()->download($tempFile, 'excel-file.xlsx')->deleteFileAfterSend(true);
    }
}
