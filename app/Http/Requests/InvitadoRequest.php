<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvitadoRequest extends FormRequest
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
            'lista_id'=>'required',
            'nombre'=>'required',
            'apellido'=>'required',
            'dni'=>'required',
            'email'=>'required',
        ];
    }
}
