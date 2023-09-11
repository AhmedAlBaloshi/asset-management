<?php

namespace App\Http\Requests;

use App\Models\LicenseManagement;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreLicenseManagementRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('license_management_create');
    }

    public function rules()
    {
        return [
            'license' => [
                'string',
                'required',
            ],
            'title' => [
                'string',
                'required',
            ],
        ];
    }
}
