<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'sku' => ['required', Rule::unique('products', 'sku')->ignore($this->id)],
            'description' => ['nullable', 'string'],
            'specification' => ['nullable'],
            'status' => ['required', 'string'],
            'height' => ['required', 'numeric', 'min:0'],
            'width' => ['required', 'numeric', 'min:0'],
            'length' => ['required', 'numeric', 'min:0'],
            'dimension_unit' => ['required', 'string'],
            'weight' => ['required', 'numeric', 'min:0'],
            'weight_unit' => ['required', 'string'],
            'currency' => ['required', 'string'],
            'original_price' => ['required', 'numeric', 'min:0'],
            'sale_price' => ['required', 'numeric', 'min:0'],
            'production_cost' => ['required', 'numeric', 'min:0'],
            'pre_order' => ['boolean', 'nullable'],
            'allow_cod' => ['boolean', 'nullable'],
            'contains_hazardous_material' => ['boolean', 'nullable'],
        ];
    }
}
