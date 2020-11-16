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
            'description' => 'nullable|string|max:140'
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
            'description.max' => "Your description cannot be longer than 140 characters!"
        ];
    }
}
