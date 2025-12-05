<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMediaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'type' => 'required|in:image,video',
            'file' => 'required|file',
            'section' => 'required|in:hero,story,features,whylearn,aktivitas,products,other',
            'order' => 'nullable|integer|min:0',
        ];
    }

    public function messages()
    {
        return [
            'file.required' => 'Pilih file terlebih dahulu',
            'file.file' => 'File tidak valid',
            'type.in' => 'Tipe harus image atau video',
            'section.in' => 'Section tidak valid',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->hasFile('file')) {
                $file = $this->file('file');
                $type = $this->input('type');
                $extension = strtolower($file->getClientOriginalExtension());

                // Validasi berdasarkan tipe
                if ($type == 'image') {
                    $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp'];
                    $maxSize = 10 * 1024 * 1024; // 10MB
                    $errorMsg = 'Image harus berupa JPG, PNG, GIF, WEBP, BMP (max 10MB)';
                } else {
                    $allowed = ['mp4', 'avi', 'mov', 'wmv', 'webm', 'ogg'];
                    $maxSize = 50 * 1024 * 1024; // 50MB
                    $errorMsg = 'Video harus berupa MP4, AVI, MOV, WMV, WEBM, OGG (max 50MB)';
                }

                if (!in_array($extension, $allowed)) {
                    $validator->errors()->add('file', $errorMsg);
                }

                if ($file->getSize() > $maxSize) {
                    $validator->errors()->add('file', "Ukuran file melebihi " . ($maxSize / 1024 / 1024) . "MB");
                }
            }
        });
    }
}
