<?php

namespace App\Http\Requests\RosterEvent;

use App\Models\RosterEvent;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\RequiredIf;

class QueryRosterEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'type' => ['bail', 'nullable', 'string', Rule::in(RosterEvent::EVENTS)],
            'arrival_location' => ['bail', 'nullable', 'string'],
            'destination_location' => ['bail', 'nullable', 'string'],
            'metrics' => ['bail', 'nullable', 'string', Rule::in(['today', 'week', 'nextWeek', 'month', '30days', '90days', 'year', 'allyear', 'custom'])],
            'from_date' => ['bail', new RequiredIf($this->metrics == 'custom'), 'date_format:m/d/Y'],
            'to_date' => ['bail', new RequiredIf($this->metrics == 'custom'), 'date_format:m/d/Y'],
            'per_page' => 'bail|nullable|integer',           
        ];
    }
}
