<?php


namespace backend\models;


use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * Class ParserCsv
 * @package backend\models
 */
class ParserCsv extends Model
{
    private const PATH = '/web/userfiles/';

    /**
     * @var int
     */
    public $subdomain;

    /**
     * @var UploadedFile
     */
    public $file;

    public function rules(): array
    {
        return [
            ['subdomain', 'integer'],
            [['file'], 'file', 'skipOnEmpty' => false]
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'subdomain' => 'Выберите поддомен, на который происходит импорт',
            'file' => 'Выберите csv-файл на компьютере'
        ];
    }

    /**
     * @return bool|string
     */
    public function upload()
    {
        $fullPath = Yii::getAlias('@backend/' . self::PATH);

        if ($this->validate() && $this->file->saveAs($fullPath . $this->file->name)) {

            return $fullPath . $this->file->name;
        }

        return false;
    }
}
