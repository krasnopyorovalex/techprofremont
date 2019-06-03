<?php

namespace backend\modules\catalog\controllers;

use backend\controllers\ModuleController;
use common\models\Catalog;
use backend\components\FileHelper as FH;

/**
 * Default controller for the `catalog` module
 */
class DefaultController extends ModuleController
{

    /**
     * @param $id
     * @return bool
     */
    public function actionRemoveImage($id)
    {
        $model = Catalog::findOne($id);
        if(FH::removeFile($model->image,$model::PATH)){
            $model->image = '';
            return $model->save();
        }
        return false;
    }

}
