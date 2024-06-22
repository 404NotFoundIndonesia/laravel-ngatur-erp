<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'sku' => ['required', Rule::unique('products', 'sku')->ignore($this->id)],
            'description' => ['nullable', 'string'],
            'specification' => ['nullable'],
            'status' => ['required', 'string'],
            'height' => ['required', 'numeric', 'gt:0'],
            'width' => ['required', 'numeric', 'gt:0'],
            'length' => ['required', 'numeric', 'gt:0'],
            'dimension_unit' => ['required', 'string'],
            'weight' => ['required', 'numeric', 'gt:0'],
            'weight_unit' => ['required', 'string'],
            'currency' => ['required', 'string'],
            'original_price' => ['required', 'numeric', 'gte:0'],
            'sale_price' => ['required', 'numeric', 'gte:0'],
            'product_cost' => ['required', 'numeric', 'gte:0'],
            'pre_order' => ['boolean', 'nullable'],
            'allow_cod' => ['boolean', 'nullable'],
            'contains_hazardous_material' => ['boolean', 'nullable'],
        ];
    }
}
