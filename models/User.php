<?php

namespace app\models;
/*
 * @property integer $id
 * @property string $username
 * @property integer $activated
 * @property string $password_hash
 * @property string $activation_key
 * @property string $password_resetkey
 * @property integer $role
 
 * @property Product[] $products
 * @property Product[] $productsupdated
*/


class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    public $password;
    public $authKey;
    
    const ROLE_USER=10;
    const ROLE_VOEDINGSDESKUNDIGE=20;
    const ROLE_PRODUCENT=30;
    
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }
    

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['activation_key' => $token]);
    }

    public static function findIdentityByPasswordResetToken($token, $type = null)
    {
        return static::findOne(['password_resetkey' => $token]);
    }
    
    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username,'activated'=>1]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->activation_key;
    }
    
    public function getPasswordresetkey()
    {
        return $this->password_resetkey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->activation_key === $authKey;
    }

    /**$password
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = \Yii::$app->security->generatePasswordHash($password);
    }
    /**$password
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setActivationkey()
    {
        $this->activation_key = \Yii::$app->security->generatePasswordHash(random_bytes(15));
    }
    
    
    public function setpasswordresetkey()
    {
        $this->password_resetkey = \Yii::$app->security->generatePasswordHash(random_bytes(15));
    }
    
    public function validatePasswordKey($passkey)
    {
        return $this->password_resetkey === $passkey;
    }
    
    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return \Yii::$app->security->validatePassword($password, $this->password_hash);
    }
    
    public function activate($key){
        if($this->validateAuthKey($key)){
            $this->updateAttributes(['activated'=>1,'activation_key'=>null]);
            return true;
        }
        return false;
    }
    
    public function deactivate(){
        $this->setpasswordresetkey();
        $this->updateAttributes(['activated'=>0,'password_resetkey'=>$this->password_resetkey]);
        return true;
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductsupdated()
    {
        return $this->hasMany(Product::className(), ['updated_by' => 'id']);
    }
    
    public function asignprofile(){
        if($this->role===User::ROLE_USER){
            $profile=new Patient();
            $profile->user_id=$this->id;
        }
        elseif($this->role===User::ROLE_VOEDINGSDESKUNDIGE){
            $profile=new Dietist();
            $profile->user_id=$this->id;
        }
        if(isset($profile)){
            $profile->save();
        }
    }
}
