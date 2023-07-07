<?php

namespace App\Http\Requests\Products;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name_uk' => 'required|string',
            'name_en' => 'required|string',
            'price' => 'required|numeric',
            'description_uk' => 'required|string',
            'description_en' => 'required|string',
            'category_id' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'type' => 'required|string',
            'command' => 'required_if:type,command',
            'item' => 'required_if:type,item',
        ];
    }
}
