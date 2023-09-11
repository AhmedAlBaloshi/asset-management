<?php

namespace App\Http\Requests;

use App\Models\Asset;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateAssetRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('asset_edit');
    }

    public function rules()
    {
        return [
            'code' => [
                'string',
                'required',
                'unique:assets,code,' . request()->route('asset')->id,
            ],
            'serial_number' => [
                'string',
                'nullable',
            ],
            'name' => [
                'string',
                'required',
            ],
            'category_id' => [
                'required',
                'integer',
            ],
            'date_of_purchase' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'quantity' => [
                'numeric',
                'required',
            ],
            'warranty_period' => [
                'string',
                'nullable',
            ],
            'depreciation' => [
                'string',
                'nullable',
            ],
            'status_id' => [
                'required',
                'integer',
            ],
            'location_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
