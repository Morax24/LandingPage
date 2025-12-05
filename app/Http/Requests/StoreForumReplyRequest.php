<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreForumReplyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'contact_id' => 'required|exists:contacts,id',
            'name' => 'required|string|max:255|min:3',
            'email' => 'required|email:rfc,dns|max:255',
            'message' => 'required|string|min:5|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'message.required' => 'Komentar wajib diisi',
            'message.min' => 'Komentar minimal 5 karakter',
            'message.max' => 'Komentar maksimal 500 karakter',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'name' => trim($this->name ?? ''),
            'email' => trim(strtolower($this->email ?? '')),
            'message' => trim($this->message ?? ''),
        ]);
    }
}
