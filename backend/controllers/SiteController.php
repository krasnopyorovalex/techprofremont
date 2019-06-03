<?php
namespace backend\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\LoginForm;
use yii\filters\VerbFilter;

/**
 * Site controller
 */
class SiteController extends Controller
{
    public $enableCsrfValidation = false;
    public $actions = [
        'update' => 'Обновление',
        'add' => 'Добавление',
        'delete' => 'Удаление',
    ];

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'upload-ckeditor', 'multiupload', 'add', 'update', 'delete', 'remove-image', 'update-pos'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                    'multiupload' => ['post'],
                    'remove-image' => ['post'],
                    'update-pos' => ['post'],
                    'upload' => ['post']
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'upload-ckeditor' => [
                'class' => 'backend\components\UploadImageCkEditor'
            ],
            'multiupload' => [
                'class' => 'backend\components\Multiupload'
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        $this->layout = false;
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function findData($query)
    {
        return new ActiveDataProvider([
            'query' => $query,
            'sort' => false,
            'pagination' => false
        ]);
    }


    public function loadData(yii\db\ActiveRecord $model, $redirect = null)
    {
        if($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) {
            if($redirect){
                return $this->redirect($redirect);
            }
            return $this->redirect(Yii::$app->homeUrl . $this->module->id);
        }
        return false;
    }
}
