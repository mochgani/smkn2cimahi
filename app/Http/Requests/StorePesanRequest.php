<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePesanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'min:3', 'max:100'],
            'email' => ['required', 'email', 'max:150'],
            'telepon' => ['nullable', 'string', 'max:30'],
            'subjek' => ['required', 'string', 'in:ppdb,bkk,kemitraan,alumni,kunjungan,lain'],
            'pesan' => ['required', 'string', 'min:10', 'max:5000'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Nama wajib diisi.',
            'nama.min' => 'Nama minimal 3 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'subjek.required' => 'Pilih topik pesan.',
            'subjek.in' => 'Topik tidak valid.',
            'pesan.required' => 'Pesan tidak boleh kosong.',
            'pesan.min' => 'Pesan minimal 10 karakter.',
            'pesan.max' => 'Pesan maksimal 5000 karakter.',
        ];
    }
}
