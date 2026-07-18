<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * StoreAgendaRequest
 * Validates the incoming request data for creating a new agenda.
 */
class StoreAgendaRequest extends FormRequest
{
    /**
     * All authenticated users reaching this point are authorized (role check is in middleware).
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation rules for agenda creation.
     */
    public function rules(): array
    {
        return [
            'reason'         => 'required|string|max:500',
            'scheduled_date' => 'required|date|after:now',
            'phone'          => 'required|string|max:20',
        ];
    }

    /**
     * Custom validation error messages.
     */
    public function messages(): array
    {
        return [
            'reason.required'         => 'La razon de contacto es obligatoria.',
            'scheduled_date.required' => 'La fecha agendada es obligatoria.',
            'scheduled_date.after'    => 'La fecha agendada debe ser futura.',
            'phone.required'          => 'El telefono es obligatorio.',
        ];
    }
}