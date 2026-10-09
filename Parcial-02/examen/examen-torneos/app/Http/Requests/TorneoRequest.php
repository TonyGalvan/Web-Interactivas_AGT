<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class TorneoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        // El checkbox desmarcado no envía nada, así que lo convertimos a true/false
        $this->merge(['abierto' => $this->boolean('abierto')]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */

    public function rules(): array
    {
        // Al crear exige fecha futura; al editar acepta también hoy
        $reglaFecha = $this->isMethod('post') ? 'after:today' : 'after_or_equal:today';

        return [
            'nombre'      => ['required', 'string', 'max:255'],
            'juego'       => ['required', 'string', 'max:255'],
            'fecha'       => ['required', 'date', $reglaFecha],
            'cupo'        => ['required', 'integer', 'min:' . max(2, $this->inscritos()), 'max:100'],
            'descripcion' => ['nullable', 'string', 'max:1000'],
            'abierto'     => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required'       => 'El nombre del torneo es obligatorio.',
            'nombre.max'            => 'El nombre no puede tener más de 255 caracteres.',
            'juego.required'        => 'Indica el juego o deporte.',
            'juego.max'             => 'El juego o deporte no puede tener más de 255 caracteres.',
            'fecha.required'        => 'La fecha del torneo es obligatoria.',
            'fecha.date'            => 'La fecha no es válida.',
            'fecha.after'           => 'La fecha debe ser posterior a hoy.',
            'fecha.after_or_equal'  => 'La fecha no puede ser anterior a hoy.',
            'cupo.required'         => 'Indica el cupo del torneo.',
            'cupo.integer'          => 'El cupo debe ser un número entero.',
            'cupo.min' => $this->inscritos() > 2
                ? 'No puedes reducir el cupo por debajo de los ' . $this->inscritos() . ' jugadores ya inscritos.'
                : 'El cupo debe estar entre 2 y 100 jugadores.',
            'cupo.max' => 'El cupo debe estar entre 2 y 100 jugadores.',
            'descripcion.max'       => 'La descripción no puede tener más de 1000 caracteres.',
        ];
    }

    private function inscritos(): int
    {
        $torneo = $this->route('torneo'); // null al crear, el torneo al editar

        return $torneo ? $torneo->jugadores()->count() : 0;
    }
}
