<?php

namespace DurianSoftware\Http\Requests\BackOffice\Setting\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'publisher_id' => 'required|integer',
            'image' => 'nullable',
            'product_code' => 'nullable',
            'name' => 'required|string',
            'description' => 'required|string',
            'release_date' => 'nullable',
            'initial_purchase_date' => 'nullable',
            'cost' => 'nullable',
            'is_stock_control' => 'nullable',
            'is_serial_control' => 'nullable',
            'sales_tax' => 'nullable',
            'weight' => 'nullable|integer|digits_between::0,3',
            'width' => 'nullable|integer|digits_between::0,3',
            'height' => 'nullable|integer|digits_between::0,3',
            'depth' => 'nullable|integer|digits_between::0,3',
            'genre' => 'required|string',
            'number_of_player' => 'required|integer',
            'minimum_stock' => 'nullable',
            'rating' => 'required|integer',
            'import_duty' => 'nullable',
            'aging_alert' => 'nullable',
            'warranty' => 'nullable',
            'pre_order_gifts' => 'nullable',
            'other' => 'nullable'
        ];
    }
}
