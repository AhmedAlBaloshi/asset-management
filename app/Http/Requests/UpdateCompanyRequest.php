<?php

namespace App\Http\Requests;

use App\Models\Company;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateCompanyRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('company_edit');
    }

    public function rules()
    {
        return [
            'company_name' => [
                'string',
                'nullable',
            ],
            'city'         => [
                'string',
                'nullable',
            ],
            'phone'        => [
                'string',
                'nullable',
            ],
            'fax'          => [
                'string',
                'nullable',
            ],
            'postal'       => [
                'string',
                'nullable',
            ],
            'email'        => [
                'string',
                'nullable',
            ],
            'website'      => [
                'string',
                'nullable',
            ],
            'owner_name'   => [
                'string',
                'nullable',
            ],
            'user'         => [
                'string',
                'nullable',
            ],
        ];
    }
}
