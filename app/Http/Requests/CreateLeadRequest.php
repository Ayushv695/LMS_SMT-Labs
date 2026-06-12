<?php

namespace App\Http\Requests;

use App\Models\Lead;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateLeadRequest extends FormRequest
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
            'name' => 'required|string|max:200',
            'email' => 'nullable|email',
            'status' => ['required',Rule::in(Lead::NEW,Lead::CONTACTED,Lead::CONVERTED,Lead::LOST)],
            'phone' => 'nullable|string',
            'source' => 'nullable|string',
            'notes' => 'nullable|string',
            'followed_up_at' => 'nullable|date',
        ];
    }
}
