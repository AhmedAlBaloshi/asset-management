<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Supplier;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class MassDestroySupplierRequest extends FormRequest  {





public function authorize()
{
    abort_if(Gate::denies('supplier_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');




return true;
    
}
public function rules()
{
    



return [
'ids' => 'required|array',
    'ids.*' => 'exists:suppliers,id',
]
    
}

}