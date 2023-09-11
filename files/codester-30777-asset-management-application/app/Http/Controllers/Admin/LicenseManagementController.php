<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyLicenseManagementRequest;
use App\Http\Requests\StoreLicenseManagementRequest;
use App\Http\Requests\UpdateLicenseManagementRequest;
use App\Models\LicenseManagement;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class LicenseManagementController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('license_management_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $licenseManagements = LicenseManagement::with(['team'])->get();

        return view('admin.licenseManagements.index', compact('licenseManagements'));
    }

    public function create()
    {
        abort_if(Gate::denies('license_management_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.licenseManagements.create');
    }

    public function store(StoreLicenseManagementRequest $request)
    {
        $licenseManagement = LicenseManagement::create($request->all());

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $licenseManagement->id]);
        }

        return redirect()->route('admin.license-managements.index');
    }

    public function edit(LicenseManagement $licenseManagement)
    {
        abort_if(Gate::denies('license_management_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $licenseManagement->load('team');

        return view('admin.licenseManagements.edit', compact('licenseManagement'));
    }

    public function update(UpdateLicenseManagementRequest $request, LicenseManagement $licenseManagement)
    {
        $licenseManagement->update($request->all());

        return redirect()->route('admin.license-managements.index');
    }

    public function show(LicenseManagement $licenseManagement)
    {
        abort_if(Gate::denies('license_management_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $licenseManagement->load('team', 'licenseAssets');

        return view('admin.licenseManagements.show', compact('licenseManagement'));
    }

    public function destroy(LicenseManagement $licenseManagement)
    {
        abort_if(Gate::denies('license_management_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $licenseManagement->delete();

        return back();
    }

    public function massDestroy(MassDestroyLicenseManagementRequest $request)
    {
        LicenseManagement::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('license_management_create') && Gate::denies('license_management_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new LicenseManagement();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
