<?php

namespace App\Http\Requests\Mahasiswa;

use Illuminate\Foundation\Http\FormRequest;

class StoreAcademicProfileRequest extends FormRequest
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
            'minat_topik_ids' => ['required', 'array', 'min:1'],
            'minat_topik_ids.*' => ['integer', 'exists:minat_topiks,id'],
            'nilai' => ['required', 'array', 'min:1'],
            'nilai.*.mata_kuliah_id' => ['required', 'integer', 'exists:mata_kuliahs,id'],
            'nilai.*.nilai_huruf' => ['required', 'string', 'in:A,AB,B,BC,C,D,E'],
            'nilai.*.nilai_angka' => ['nullable', 'numeric', 'between:0,4'],
        ];
    }
}
