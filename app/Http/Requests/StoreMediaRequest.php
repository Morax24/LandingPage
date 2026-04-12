<?php
// app/Http/Requests/StoreMediaRequest.php

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
            'price' => 'nullable|numeric|min:0', // TAMBAHKAN INI
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
            'price.numeric' => 'Harga harus berupa angka',
            'price.min' => 'Harga tidak boleh kurang dari 0',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $section = $this->input('section');
            $price = $this->input('price');

            // Harga wajib jika section adalah products
            if ($section === 'products' && (empty($price) || $price <= 0)) {
                $validator->errors()->add('price', 'Harga wajib diisi untuk produk.');
            }

            // File validation
            if ($this->hasFile('file')) {
                $file = $this->file('file');
                $type = $this->input('type');
                $extension = strtolower($file->getClientOriginalExtension());

                if ($type == 'image') {
                    $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp'];
                    $maxSize = 1 * 1024 * 1024; // 10MB
                    $errorMsg = 'Image harus berupa JPG, PNG, GIF, WEBP, BMP (max 1MB)';
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
