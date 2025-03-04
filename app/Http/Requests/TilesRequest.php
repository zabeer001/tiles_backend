<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TilesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',          // Name is required and should be a string with a max length of 255 characters
            'price' => 'nullable|numeric',                // Price is optional, but if provided, it must be numeric
            'description' => 'nullable|string',           // Description is optional and should be a string if provided
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Image is optional, but if present, it must be an image file and no larger than 2MB
        ];
    }

}
