<?php

namespace DurianSoftware\Http\Requests\BackOffice\Inquiry;

use Illuminate\Foundation\Http\FormRequest;

class InquiryRequest extends FormRequest
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
    public function rules()
    {
        return [
            'date'           => 'required',
            'company_id'        => 'required',
            // 'products.*.id'     => 'required',
            // 'products.*.warehouse_id' => 'required',
            // 'products.*.type_id' => 'required',
            // 'products.*.quantity' => 'required',
            // 'products.*.unit_price' => 'required',
            // 'products.*.amount' => 'required',

        ];
    }

    public function messages()
    {
        return [
            'date.required'              => 'Please enter inquiry date',
            'company_id.required'           => 'Please enter inquiry company_id',
            // 'products.*.id.required'        => 'Please enter inquiry products_id',
            // 'products.*.warehouse_id.required' => 'Please enter inquiry products_warehouse_id',
            // 'products.*.type_id.required' => 'Please enter inquiry products_type_id',
            // 'products.*.quantity.required' => 'Please enter inquiry products_quantity',
            // 'products.*.amount.required' => 'Please enter inquiry products_amount',
        ];
    }
}
