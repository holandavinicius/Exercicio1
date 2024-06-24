<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Tarefa;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\web\Request;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'index'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $query = Tarefa::find()->select(['Id','TituloTarefa', 'DataCriacao', 'DataConclusao', 'Estado', 'Descricao']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $model = new Tarefa();

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'model' => $model
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->actionIndex();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionModalEditar($id)
    {
        $model = Tarefa::findOne($id);

        if (!$model) {
            throw new NotFoundHttpException('O modelo não foi encontrado.');
        }

        return $this->renderAjax('_modal_content', [
            'model' => $model,
        ]);
    }

    public function actionAdicionarTarefa()
    {
        $model = new Tarefa();

        $data = json_decode(Yii::$app->request->getRawBody(), true);

        $model->TituloTarefa = $data['tituloTarefa'];
        $model->Descricao = $data['descricao'];
        $model->DataCriacao = $data['dataCriacao'];
        $model->DataConclusao = $data['dataConclusao'];
        $model->Estado = $data['estado'];

        if ($model->save()) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ['success' => true, 'message' => 'Tarefa adicionada com sucesso.'];
        } else {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ['success' => false, 'message' => 'Erro ao adicionar a tarefa.', 'errors' => $model->errors];
        }
    }
}
