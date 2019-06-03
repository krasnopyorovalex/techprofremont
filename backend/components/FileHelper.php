<?php

namespace backend\components;


class FileHelper
{
    public static function removeFile($name, $path)
    {
        return unlink(\Yii::getAlias('@frontend/web'.$path.$name));
    }

    public static function deleteAllImages(array $images, $path)
    {
        if($images){
            foreach ($images as $image){
                self::removeFile($image['basename'].'.'.$image['ext'], $path);
            }
        }
        return true;
    }
}