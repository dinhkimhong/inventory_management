<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MaterialRequest extends FormRequest
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
                'material_description'=>'required|max:100',
                'unit'=>'required',
                'material_group_id'=>'required',
                'origin'=>'required',
                'tarrif_code'=>'required',
                'currency'=>'required',
        ];
    }

    public function messages()
    {
        return[
            'material_description.required'=>'Please input Material Description',
            'material_description.max'=>'Number of letter in Material Description must be less than 100',
            'unit.required'=>'Please input Unit',
            'material_group_id.required'=>'Please input Material Group',
            'origin.required'=>'Please input Origin',
            'tarrif_code.required'=>'Please input Tarrif Code',
            'currency.required'=>'Please input Currency',
        ];
    }
}
