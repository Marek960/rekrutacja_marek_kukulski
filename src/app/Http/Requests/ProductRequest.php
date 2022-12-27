<?php

namespace App\Http\Requests;

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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
            'name' => ['required', 'max:255', 'string', 'min:2'],
            'description' => ['required', 'max:255', 'string', 'min:1'],
            'prices' => ['required'],
            'prices.*.price' => ['required', 'integer']
        ];

        if (in_array($this->method(), ['PUT'])) {
            $rules['prices.*.id'] = [
                'required',
                'integer'
            ];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => __('Name field is required'),
            'name.max:255' => __('Name field must be not longer than 255 characters'),
            'name.string' => __('Name field must be a string'),
            'name.min:2' => __('Name field must be longer than 2 characters'),
            'description.required' => __('Description field is required'),
            'description.max:255' => __('Description field must be not longer than 255 characters'),
            'description.string' => __('Description field must be a string'),
            'description.min:1' => __('Description field must be longer than 1 characters'),
            'prices.*.price.required' => __('Description field is required'),
            'prices.*.price.integer' => __('Description field must be a integer'),
            'prices.*.id.required' => __('Id price field is required'),
        ];
    }
}
