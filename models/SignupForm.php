<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class SignupForm extends Model
{
    public $username;
    public $password;
    public $password_repeat;
    public $type;
    
    public $tempactkey;
    


    private $_user=false;
    
     /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Email adres',
            'password' => 'Paswoord',
            'password_repeat' => 'Confirmatie paswoord',
            'type' => 'type',
        ];
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
        [['password','username','password_repeat'], 'required'],
        ['password', 'string', 'min' => 6],
        ['password_repeat', 'compare', 'compareAttribute'=>'password' ],
        ['username','email']
        ];
    }

    
    public function getusertypes(){
        return [ 
            1=>Yii::t('app','gebruiker'),
            2=>Yii::t('app','voedingsdeskundige'),
            3=>Yii::t('app','producent') 
        ];
    }

    /**
     * signs up a user using the provided username.
     * @return bool whether registration is success
     */
    public function signup()
    {
        if ($this->validate()) {
            $user = $this->getUser();
            if(!$user){
                
                
                //user bestaat nog niet
                $newuser=new User([
                    'username'=>$this->username,
                    'role'=>$this->type
                ]);
                $newuser->setPassword($this->password);
                $newuser->setActivationkey();
                $this->tempactkey=$newuser->getAuthKey();
                $newuser->save();
                
                
                return true;
            }
            
        }
        return false;
    }

    public function sendsignupmessage($body)
    {
        if(
            Yii::$app->mailer->compose('@app/mail/layouts/html.php',['content'=>$body])
            ->setTo($this->username)
            ->setFrom(['inf@safefood.be' => 'Safefood'])
            ->setSubject('Safefood - Account confirmatie')
            ->send()){
                return true;
        }
        return false;
    }
    
    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}
