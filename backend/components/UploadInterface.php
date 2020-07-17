<?php

namespace backend\components;


interface UploadInterface
{

    /**
     * @param $id
     * @return mixed
     */
    public function upload($id);

}