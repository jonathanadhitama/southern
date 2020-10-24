<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCharacterRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'height' => 'required|numeric|min:0',
            'mass' => 'required|numeric|min:0',
            'hair_colour' => 'required|string|max:255',
            'birth_year' => 'required|string|max:255',
            'gender' => 'required|string|max:255',
            'homeworld' => 'required|string|max:255',
            'species' => 'required|string|max:255'
        ];
    }
}
