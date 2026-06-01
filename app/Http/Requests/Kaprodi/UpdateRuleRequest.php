<?php

namespace App\Http\Requests\Kaprodi;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRuleRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama_rule' => ['required', 'string', 'max:120'],
            'mata_kuliah_prasyarat_id' => ['nullable', 'integer', 'exists:mata_kuliahs,id'],
            'nilai_minimum' => ['nullable', 'string', 'in:A,AB,B,BC,C,D,E'],
            'minat_topik_id' => ['nullable', 'integer', 'exists:minat_topiks,id'],
            'mata_kuliah_rekomendasi_id' => ['required', 'integer', 'exists:mata_kuliahs,id'],
            'bobot_skor' => ['required', 'integer', 'min:1', 'max:100'],
            'is_active' => ['required', 'boolean'],
        ];
    }
}
