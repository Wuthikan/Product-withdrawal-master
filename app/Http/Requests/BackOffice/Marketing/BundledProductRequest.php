<?php

namespace DurianSoftware\Http\Requests\BackOffice\Marketing;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class BundledProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {
        $bundledProduct = $this->route()->parameters();
        $id = isset($bundledProduct['bundled_product'])? $bundledProduct['bundled_product'] : '';
        
        // intval($request['promotion_srp']);
        return [
            'bundled_name'  => [
                'required',
                Rule::unique('dim_bundled_product')->ignore($id)
            ],
            'promotion_srp' => 'required|string|digits_between::0,10',
            'start_date_id' => 'required|date_format:d/m/Y',
            'end_date_id' => 'required|date_format:d/m/Y',
            'remark' => 'sometimes|nullable|string',
            'id'    => 'sometimes|number'
        ];
    }

    public function messages()
    {
        return [
            'bundled_name.required' => trans('validation.bundled_name_null'),
            'promotion_srp.required' => trans('validation.bundled_promotion_srp_null'),
            'start_date_id.required' => trans('validation.bundled_start_date_null'),
            'end_date_id.required' => trans('validation.bundled_end_date_null'),
        ];
    }
}
