<?php

namespace App\Domains\Images\Actions;


use App\Domains\Images\Models\Image;
use Illuminate\Http\UploadedFile;

class CreateImageAction
{
    /**
     * @param UploadedFile $file
     * @param int $user_id
     * @return Image
     */
    public function execute(UploadedFile $file, int $user_id ): Image
    {
        $file_name = $file->getClientOriginalName().time();
        $file_path = $file->storeAs("images/{$user_id}", $file_name);

        return Image::create([
            'user_id' => $user_id,
            'filename' => $file_name,
            'file_path' => $file_path,
            'extension' => $file->getClientOriginalExtension(),
        ]);
    }
}
