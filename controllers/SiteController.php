<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\Login;
use app\models\NewContactForm;
use app\models\UpdateContactForm;


class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
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
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        $login_model = new Login();
        if(Yii::$app->request->post('Login'))
        {
            $login_model->attributes = Yii::$app->request->post('Login');
            if($login_model->validate())
            {
               Yii::$app->user->login($login_model->getUser());

               return $this->goHome();
            }
        }

        return $this->render('login', ['login_model' => $login_model]);
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

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $new_contact_model = new NewContactForm();
        if(Yii::$app->request->post('NewContactForm'))
        {
            $new_contact_model->attributes = Yii::$app->request->post('NewContactForm');
            if($new_contact_model->validate()){
                $data = Yii::$app->request->post('NewContactForm');
                Yii::$app->db->createCommand()->insert( 'contacts',
                    [
                        'first_name' => $data['first_name'],
                        'last_name' => $data['last_name'],
                        'email' => $data['email'],
                        'phone' => $data['phone'],
                        'user_id' => Yii::$app->user->id
                    ])->execute();
                $this->redirect('all-contacts');
            }
        }

        return $this->render('new_contact', ['model' => $new_contact_model]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAllContacts()
    {
        if(Yii::$app->request->isAjax) {
            $user_id = Yii::$app->user->id;
            $abs = $_GET['query'];
            $abs ? 
                $query = "SELECT * FROM `contacts` WHERE user_id = $user_id AND first_name LIKE '%$abs%' OR last_name LIKE '%$abs%' OR phone LIKE '%$abs%'" :
                $query = "SELECT * FROM `contacts` WHERE user_id = $user_id";

            return json_encode(Yii::$app->db->createCommand($query)->queryAll());
        }

        return $this->render('all_contacts');
    }

    public function actionShow($id)
    {
        if(!Yii::$app->user->isGuest) {
            $user_id = Yii::$app->user->id;
            $query = "SELECT * FROM `contacts` WHERE user_id = $user_id AND id = $id";
            $contact = Yii::$app->db->createCommand($query)->queryOne();
        }

        return $this->render('contact', ['contact' => $contact ?? null]);
    }

    public function actionShowUpdate($id)
    {
        $new_contact_model = new UpdateContactForm();
        if(!Yii::$app->user->isGuest) {
            $user_id = Yii::$app->user->id;
            $query = "SELECT * FROM `contacts` WHERE user_id = $user_id AND id = $id";
            $contact = Yii::$app->db->createCommand($query)->queryOne();
        }
        if(Yii::$app->request->post('UpdateContactForm'))
        {
            $new_contact_model->attributes = Yii::$app->request->post('UpdateContactForm');
            if($new_contact_model->validate()){
 
                $data = Yii::$app->request->post('UpdateContactForm');
                Yii::$app->db->createCommand()->update( 'contacts',[
                        'first_name' => $data['first_name'],
                        'last_name' => $data['last_name'],
                        'email' => $data['email'],
                        'phone' => $data['phone'],
                        'user_id' => Yii::$app->user->id
                    ], 'id = :id', [':id' => $id] )->execute();
                $this->redirect('all-contacts');
            }
        }

        return $this->render('update_contact', ['model' => $new_contact_model, 'contact' => $contact ?? null]);
    }
}
