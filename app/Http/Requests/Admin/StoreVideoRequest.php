<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreVideoRequest extends FormRequest
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
           'name.*'=>'nullable|string',
           'des.*'=>'nullable|string',
           'link'=>'required|string',
            'image' =>'nullable|image',
            'group_media'=>'required|integer'
        ];
   
    }
}
