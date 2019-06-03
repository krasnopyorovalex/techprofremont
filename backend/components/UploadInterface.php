<?php

namespace backend\components;


interface UploadInterface
{

    /**
     * @param $id
     * @param $path
     * @param $nameField
     * @return mixed
     */
    public function upload($id, $path, $nameField);

}