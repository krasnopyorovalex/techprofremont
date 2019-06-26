<?php

namespace backend\modules\parser_csv\controllers;

use backend\components\ParserCsvService;
use backend\controllers\SiteController;
use backend\models\ParserCsv;
use common\models\Subdomains;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use yii\web\UploadedFile;
use League\Csv\Exception as ExceptionCsv;

/**
 * Default controller for the `parser_csv` module
 */
class DefaultController extends SiteController
{

    /**
     * @var ParserCsvService
     */
    private $parserCsvService;

    public function __construct($id, $module, ParserCsvService $parserCsvService, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->parserCsvService = $parserCsvService;
    }
    /**
     * @return array
     */
    public function behaviors(): array
    {
        return ArrayHelper::merge(parent::behaviors(),[
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['upload'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'upload' => ['post']
                ],
            ],
        ]);
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex(): string
    {
        $subdomains = Subdomains::find()->asArray()->all();

        return $this->render('index', [
            'subdomains' => ArrayHelper::map($subdomains,'id','domain_name'),
            'model' => new ParserCsv
        ]);
    }

    /**
     * @return Response
     */
    public function actionUpload(): Response
    {
        $model = new ParserCsv();
        $model->load(Yii::$app->request->post());
        $model->file = UploadedFile::getInstance($model, 'file');

        if ($model->validate() && $path = $model->upload()) {
            try {
                $this->parserCsvService->parse($path, $model->subdomain);
            } catch (ExceptionCsv $exception) {
                Yii::error($exception->getMessage());
            }
        }

        return $this->redirect(Yii::$app->homeUrl . $this->module->id);
    }
}
