<?php

namespace backend\components;

use backend\controllers\SiteController;
use Yii;
use yii\base\Action;
use yii\helpers\FileHelper;

/**
 * Class UploadImageCkEditor
 * @package backend\components
 */
class UploadImageCkEditor extends Action{

    const CKEDITOR_PATH = '/web/ckeditor/';

    /**
     * @throws \yii\base\Exception
     */
    public function run()
    {
        $path = $this->_getFileDir();
        if (!file_exists($path)) FileHelper::createDirectory($path, 0755, true);
        $file = $path . basename($_FILES['upload']['name']);

        if (move_uploaded_file($_FILES['upload']['tmp_name'], $file)) {
            $callback = $_REQUEST['CKEditorFuncNum'];
            $message = 'Загрузка прошла успешно:)\n';
            $file = str_replace('/web','',self::CKEDITOR_PATH) . str_replace($path,'',$file);
            exit('<script type="text/javascript">window.parent.CKEDITOR.tools.callFunction("'.$callback.'", "'.$file.'", "'.$message.'" );</script>');
        } else {
            exit("Возможная атака с помощью файловой загрузки!\n");
        }
    }

    private function _getFileDir()
    {
        return Yii::getAlias('@frontend'.self::CKEDITOR_PATH);
    }

} 