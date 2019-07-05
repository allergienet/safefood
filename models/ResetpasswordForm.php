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
class ResetpasswordForm extends Model
{
    public $username;
    public $password;
    public $password_repeat;
    public $tempresetpasswordkey;


    private $_user=false;
    
    const SCENARIO_SENDPASSWORDKEY="sendpasswordkey";
    const SCENARIO_RESETPASSWORD="resetpassword";
    
     /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Email adres',
            'password' => 'Paswoord',
            'password_repeat' => 'Confirmatie paswoord',
        ];
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
        [['password','password_repeat'], 'required','on'=> self::SCENARIO_RESETPASSWORD],
        [['username'], 'required','on'=> self::SCENARIO_SENDPASSWORDKEY],
        ['password', 'string', 'min' => 6],
        ['password_repeat', 'compare', 'compareAttribute'=>'password' ],
        ['username','email']
        ];
    }


    /**
     * signs up a user using the provided username.
     * @return bool whether registration is success
     */
    public function setpasswordkey()
    {
        if ($this->validate()) {
            $user = $this->getUser();
            if($user){
                $user->deactivate();
                $this->tempresetpasswordkey=$user->getPasswordresetkey();
                
                return true;
            }
            
        }
        return false;
    }
    
    public function resetpassword($key){
        $user= User::findIdentityByPasswordResetToken($key);
        if(!empty($user)){
            
            
            $user->setPassword($this->password);
            $user->activated=1;
            $user->password_resetkey=null;
            
            $user->save();
            
            return true;
        }
        return false;
    }    

    public function sendpasswordkey($body)
    {
        if(
            Yii::$app->mailer->compose('@app/mail/layouts/html.php',['content'=>$body])
            ->setTo($this->username)
            ->setFrom('webmaster@klasmixer.be')
            ->setSubject('Klasmixer - Account heractivatie')
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
