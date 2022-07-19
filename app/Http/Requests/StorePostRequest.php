<?php

namespace App\Http\Requests;

use App\Rules\IntegerArray;
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required|string|min:5',
            'body' => 'nullable|string|required',
            'user_ids' => [
                'array',
                'required',
                new IntegerArray()
                // function($attr, $value, $fail){
                //     $integerOnly = collect($value)->every(fn ($element) => is_int($element));

                //     if(!$integerOnly){
                //         $fail($attr. ' can only be integers');
                //     }

                // }
            ],
        ];
    }


    public function messages()
    {
        return [
            'body.required' => 'please enter a body value',
            'title.string' => 'title needs to be a string',
        ];
        
    }
}
