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
        $filename = $file->getClientOriginalName().time();
        $path = $file->storeAs("images/{$user_id}", $filename);
        return Image::create([
            'user_id' => $user_id,
            'filename' => $filename,
            'path' => $path,
            'extension' => $file->getClientOriginalExtension(),
        ]);
    }
}
