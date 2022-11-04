<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
            'title' => ['required', 'unique:posts', 'min:3'],
            'description' => ['required', 'min:10'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:50000'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => 'title is required',
            'title.min' => 'title must be at least 3 character',
            'title.unique' => 'title must be unique',
            'description.required' => 'Description is required',
            'description.min' => 'Description must be at least 10 characters',
            'image.image' => 'you must upload an image',
            'image.mimes' => 'Please upload an image with one of those extensions:jpeg,png,jpg,gif,svg',
            'image.required' => 'Image is required',
            'image.max' => 'Image size must not exceed 50000 mb'

        ];
    }
}
