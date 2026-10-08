<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RecetaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'titulo'         => ['required', 'string', 'max:255'],
            'categoria'      => ['required', 'in:desayuno,almuerzo,cena,postre,bebida'],
            'tiempo_minutos' => ['required', 'integer', 'min:1'],
            'dificultad'     => ['required', 'in:fácil,media,difícil'],
            'ingredientes'   => ['required', 'string'],
            'pasos'          => ['required', 'string'],
            'nota'           => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'titulo.required'         => 'El título es obligatorio.',
            'titulo.max'              => 'El título no puede tener más de 255 caracteres.',
            'categoria.required'      => 'Elige una categoría.',
            'categoria.in'            => 'La categoría no es válida.',
            'tiempo_minutos.required' => 'Indica el tiempo en minutos.',
            'tiempo_minutos.integer'  => 'El tiempo debe ser un número entero.',
            'tiempo_minutos.min'      => 'El tiempo debe ser mayor a 0.',
            'dificultad.required'     => 'Elige la dificultad.',
            'dificultad.in'           => 'La dificultad debe ser fácil, media o difícil.',
            'ingredientes.required'   => 'Escribe al menos un ingrediente.',
            'pasos.required'          => 'Escribe al menos un paso.',
        ];
    }
}
