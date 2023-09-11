<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreLicenseManagementRequest;
use App\Http\Requests\UpdateLicenseManagementRequest;
use App\Http\Resources\Admin\LicenseManagementResource;
use App\Models\LicenseManagement;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LicenseManagementApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('license_management_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new LicenseManagementResource(LicenseManagement::with(['team'])->get());
    }

    public function store(StoreLicenseManagementRequest $request)
    {
        $licenseManagement = LicenseManagement::create($request->all());

        return (new LicenseManagementResource($licenseManagement))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(LicenseManagement $licenseManagement)
    {
        abort_if(Gate::denies('license_management_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new LicenseManagementResource($licenseManagement->load(['team']));
    }

    public function update(UpdateLicenseManagementRequest $request, LicenseManagement $licenseManagement)
    {
        $licenseManagement->update($request->all());

        return (new LicenseManagementResource($licenseManagement))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(LicenseManagement $licenseManagement)
    {
        abort_if(Gate::denies('license_management_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $licenseManagement->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
