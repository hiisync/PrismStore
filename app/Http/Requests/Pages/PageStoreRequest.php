<?php

namespace App\Http\Requests\Pages;

use Illuminate\Foundation\Http\FormRequest;

class PageStoreRequest extends FormRequest
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
            'name_uk' => 'required|string|min:1|max:250',
            'name_en' => 'required|string|min:1|max:250',
            'content_uk' => 'required|string|min:1',
            'content_en' => 'required|string|min:1',
            'description_uk' => 'required|string|min:1',
            'description_en' => 'required|string|min:1',
            'slug' => 'required|regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/|unique:pages,slug',
        ];
    }
}
