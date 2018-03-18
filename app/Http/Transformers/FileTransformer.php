<?php
namespace App\Http\Transformers;

use App\File;
use League\Fractal\TransformerAbstract;

class FileTransformer extends TransformerAbstract
{
    /**
     * transform a file
     * @param  File $file
     * @return array
     */
    public function transform(File $file)
    {
        return [
            'id' => (int) $file->id,
            'filename' => $file->filename,
            'download' => $file->download,
        ];
    }
}
