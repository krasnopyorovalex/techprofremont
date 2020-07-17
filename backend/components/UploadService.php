<?php

namespace backend\components;

use common\models\ProductImages;
use Intervention\Image\ImageManager;
use Yii;
use yii\base\Exception;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

class UploadService implements UploadInterface
{

    public function upload($id)
    {
        $path = Yii::getAlias('@frontend/web'.ProductImages::PATH . $id . '/');

        if (!file_exists($path)) {
            try {
                FileHelper::createDirectory($path, 755, true);
            } catch (Exception $e) {
            }
        }

        $file = UploadedFile::getInstanceByName('Products[filesGallery]');
        if ($file) {
            $fileName = md5($file->baseName . microtime());
            $fileExt = $file->extension;
            $fileFull = $path . $fileName . '.' . $fileExt;
            if($file->saveAs($fileFull))
            {
                (new ImageManager())->make($fileFull)->resize(340, 340)->save($path.$fileName.'_thumb.'.$fileExt);
                return [
                    'name' => $fileName,
                    'ext' => $fileExt
                ];
            }
        }

        return false;
    }
}
