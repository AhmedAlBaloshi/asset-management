<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\LicenseManagement;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyLicenseManagementRequest extends FormRequest  {





public function authorize()
{
    abort_if(Gate::denies('license_management_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');




return true;
    
}
public function rules()
{
    



return [
'ids' => 'required|array',
    'ids.*' => 'exists:license_managements,id',
]
    
}

}