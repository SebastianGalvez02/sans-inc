<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAgendaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'reason'         => 'required|string|max:500',
            'scheduled_date' => 'required|date|after:now',
            'phone'          => 'required|string|max:20',
        ];
    }

    public function messages(): array
    {
        return [
            'reason.required'         => 'La razón de contacto es obligatoria.',
            'scheduled_date.required' => 'La fecha agendada es obligatoria.',
            'scheduled_date.after'    => 'La fecha agendada debe ser futura.',
            'phone.required'          => 'El teléfono es obligatorio.',
        ];
    }
}