<?php
namespace backend\components;

use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

/**
 * Class FileBehavior
 * @package backend\components
 */
class FileBehavior extends Behavior
{
    const SUB_FOLDER = 'web';

    /**
     * path_to_save_image
     */
    public $path;

    /**
     * @var
     */
    public $entity_db;

    /**
     * @var
     */
    private $_attribute;

    /**
     * @param \yii\base\Component $owner
     */
    public function attach($owner)
    {
        parent::attach($owner);
        $owner->on(ActiveRecord::EVENT_BEFORE_INSERT, [$this, 'onBeforeSave']);
        $owner->on(ActiveRecord::EVENT_BEFORE_UPDATE, [$this, 'onBeforeSave']);
        $owner->on(ActiveRecord::EVENT_BEFORE_DELETE, [$this, 'onBeforeDelete']);
    }

    /**
     * @throws \yii\base\Exception
     */
    public function onBeforeSave()
    {
        $makePath = $this->getFileDir();
        if (!file_exists($makePath)) { FileHelper::createDirectory($makePath, 755, true); }
        if($this->_attribute = UploadedFile::getInstance($this->owner, 'file')){
            $file = md5($this->_attribute->baseName . '_'.microtime()).'.' . $this->_attribute->extension;
            $this->_attribute->saveAs($makePath.$file);
            $this->owner->{$this->entity_db} = $file;
        }
    }

    public function onBeforeDelete()
    {
        if($this->owner->{$this->entity_db}){
            unlink($this->getFileDir() . $this->owner->{$this->entity_db});
        }
    }

    /**
     * @return bool|string
     */
    public function getFileDir()
    {
        return Yii::getAlias('@files/' . $this->path);
    }

}