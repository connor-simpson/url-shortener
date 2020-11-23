<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'url' => 'required|url',
            'description' => 'nullable|string|max:140',
            'shortcode' => 'nullable|exists:dictionary,id,used,0',
            'custom_shortcode' => 'nullable|unique:short_urls,short_url'
        ];
    }

    /**
     *  Customise the error messages for each
     */
    public function messages()
    {
        return [
            'url.required' => 'You haven\'t entered a URL to shorten!',
            'url.url' => 'That isn\'t a valid URL!', 
            'description.max' => "Your description cannot be longer than 140 characters!",
            'shortcode.exists' => "That shortcode doesn't exist or has already been used!",
            'custom_shortcode.unique' => "You cannot use that custom shortcode as it already exists!"
        ];
    }
}
