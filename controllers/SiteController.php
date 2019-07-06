<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

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
    public function actionIndex($manualsearch=false)
    {
        $searchModel = new \app\models\ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$manualsearch);

        return $this->render('@app/views/product/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'manualsearch'=>$manualsearch
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
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->goBack();
    }

    /**
     * Signup action.
     *
     * @return Response|string
     */
    public function actionSignup($key="")
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        
        if(!empty($key)){
            $patient=\app\models\Patient::findOne(['signupkey'=>$key]);
            if(empty($patient)){
                return $this->goHome();
            }
        }

        $model = new \app\models\SignupForm();
        
        if ($model->load(Yii::$app->request->post())) {
            if(!empty($patient)){
                $model->signuppatient($patient);
                Yii::$app->session->setFlash('success','Registratie succesvol. U kan nu inloggen.');
                return $this->redirect('index');
            }
            elseif($model->signup()){
                $model->sendsignupmessage($this->renderPartial("@app/mail/activate",[
                    'model'=>$model,
                    'activationkey'=>$model->tempactkey
                ]));
                Yii::$app->session->setFlash('success','Registratie succesvol. Check je inbox om je account te activeren.');
                return $this->redirect('index');
            }
            else{
                Yii::$app->session->setFlash('danger',"Registratie is niet gelukt. Misschien heeft dit email adres al een account?");
            }
            
        }
        return $this->render('signup', [
            'model' => $model,
            'key'=> $key
        ]);
    }
    /**
     * resetpassword action.
     *
     * @return Response|string
     */
    public function actionForgotpassword()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new \app\models\ResetpasswordForm();
        $model->scenario=  \app\models\ResetpasswordForm::SCENARIO_SENDPASSWORDKEY;
        if ($model->load(Yii::$app->request->post())) {
            if($model->setpasswordkey()){
                $model->sendpasswordkey($this->renderPartial("@app/mail/resetpassword",[
                    'model'=>$model,
                    'resetpasswordkey'=>$model->tempresetpasswordkey
                ]));
                Yii::$app->session->setFlash('success','Aanvraag nieuw paswoord succesvol. Check je inbox om terug toegang te krijgen tot je account');
            }
            else{
                Yii::$app->session->setFlash('danger',"Aanvraag nieuw paswoord is niet gelukt.");
            }
            return $this->redirect('index');
            
        }
        return $this->render('forgotpassword', [
            'model' => $model,
        ]);
    }
    /**
     * resetpassword action.
     *
     * @return Response|string
     */
    public function actionResetpassword($key='')
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new \app\models\ResetpasswordForm();
        $model->scenario=  \app\models\ResetpasswordForm::SCENARIO_RESETPASSWORD;
        if ($model->load(Yii::$app->request->post())) {
            if($model->resetpassword($key)){
                Yii::$app->session->setFlash('success','Uw account is geactiveerd. U kan zich nu aanmelden.');
            }
            else{
                Yii::$app->session->setFlash('danger',"Resetten van paswoord is niet gelukt");
            }
        }
        elseif($key!=''){
            $user= \app\models\User::findIdentityByPasswordResetToken($key);

            if(!empty($user)){
                return $this->render('resetpassword', [
                    'model' => $model,
                    'key'=>$key
                ]);
            }
            
            
        }
        return $this->redirect('index');
        
        
    }
    public function actionSignupsuccessful(){
        return $this->render('signupsuccessful');
    }
    public function actionSendpasswordsuccesful(){
        return $this->render('sendpasswordsuccesful');
    }

    
    public function actionActivate($key){
        $user= \app\models\User::findIdentityByAccessToken($key);

        if(!empty($user)){
            if($user->activate($key)){
                $user->asignprofile();
                Yii::$app->session->setFlash('success','Uw account is geactiveerd. U kan zich nu aanmelden.');
            }
            
        }
        return $this->redirect('index');
        
    }
    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->redirect('index');
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
