<?php

namespace backend\components;

use Intervention\Image\ImageManager;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

class UploadService implements UploadInterface
{

    /**
     * @param $id
     * @param $path
     * @param $nameField
     * @return array|bool
     */
    public function upload($id, $path, $nameField)
    {
        if (!file_exists($path))
            FileHelper::createDirectory($path, 0755, true);
        $file = UploadedFile::getInstanceByName($nameField);
        $fileName = md5($file->baseName . microtime());
        $fileExt = $file->extension;
        $fileFull = $path . $fileName . '.' . $fileExt;
        if($file->saveAs($fileFull))
        {
            (new ImageManager())->make($fileFull)->resize(320, 300)->save($path.$fileName.'_thumb.'.$fileExt);
            return [
                'name' => $fileName,
                'ext' => $fileExt
            ];
        }
        return false;
    }

}