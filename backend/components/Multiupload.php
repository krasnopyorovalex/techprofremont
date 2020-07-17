<?php

namespace backend\components;

use Yii;
use yii\base\Action;
use yii\base\Exception;
use yii\web\UploadedFile;
use common\models\ProductImages;
use yii\imagine\Image;
use yii\helpers\FileHelper;

class Multiupload extends Action
{
    /**
     * @return bool
     * @throws Exception
     */
    public function run()
    {
        $productId = Yii::$app->request->post('productId');
        $path = Yii::getAlias('@frontend'.ProductImages::PATH . $productId . DIRECTORY_SEPARATOR);

        if (!file_exists($path)) {
            FileHelper::createDirectory($path, 0755, true);
        }

        $image = new ProductImages();
        $image->file = UploadedFile::getInstanceByName('file');

        $image->product_id = $productId;
        $image->basename = md5($image->file->baseName . microtime());
        $image->ext = $image->file->extension;

        if($image->validate() && $image->save()){
            $image->file->saveAs($path . $image->basename . '.' . $image->ext);
            //thumb
            Image::thumbnail($path . $image->basename . '.' . $image->ext, 450, 225)
                ->save($path . $image->basename . '_thumb.' . $image->ext, ['quality' => 100]);
            return true;
        }

        return false;
    }
} 