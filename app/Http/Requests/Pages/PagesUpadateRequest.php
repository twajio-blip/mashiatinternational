<?php

namespace App\Http\Requests\Pages;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Http\FormRequest;

class PagesUpadateRequest extends FormRequest
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
        $id =    Route::current()->parameter('pages');
        return [
            'name' => 'required',
            'permalink' => 'required',
            'description' => 'nullable',
            'status' => 'required',
            'image' => 'nullable|image|mimes:png,jpg,gif|max:1024',
            'seo_image' => 'nullable|image|mimes:png,jpg,jpeg|max:1024',
        ];
    }
    public function messages()
    {
        return [
            'image.mimes' => 'Only PNG, JPG, GIF.',
            'image.max' => 'Max upload size 1MB.',
            'seo_image.mimes' => 'Only PNG, JPG, JPEG.',
            'seo_image.max' => 'Max upload size 1MB.',
        ];
    }
}
