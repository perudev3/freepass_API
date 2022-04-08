<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventoRequest extends FormRequest
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
            'nombre' => 'required|string|max:255',
            'tipo_id' => 'required|integer',
            'fecha' => 'required|date',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i',
            'lugar' => 'required|string|max:255',
            'descripcion' => 'required|string|max:255',
            'numero_promotor' => 'required|string|max:9',
            'place_id' => 'required|integer',
            'portada_img' => 'required',
        ];
    }
}
