<?php
namespace App\Repository;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class UploadRepository {
    public static function save($image) {
        $file = $image;
        // $file_name = url('media/' . $file->hashName());
        $file_name = url('media/'.time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension());

        $destinasi = 'media/';
        $file->move($destinasi, $file_name);

        return $file_name;
    }

    public function update($old_image, $image)
    {
        if ($old_image) {
            $old_file_name = basename($old_image);
            $old_path = public_path('media/' . $old_file_name);
            if (File::exists($old_path)) {
                File::delete($old_path);
            }
        }

        $file_name = time() . '_' . Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME))
            . '.' . $image->getClientOriginalExtension();
        $destinasi = public_path('media/');
        $image->move($destinasi, $file_name);

        return url('media/' . $file_name);
    }

    public function delete($image)
    {
        if ($image) {
            $file_name = basename($image);
            $file_path = public_path('media/' . $file_name);
            if (File::exists($file_path)) {
                File::delete($file_path);
            }
        }
    }
}
