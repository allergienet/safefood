<?php

namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\web\UploadedFile;
/**
 * This is the model class for table "dietist".
 *
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property int $user_id
 * @property string $naam
 * @property string $voornaam
 * @property string $tel
 * @property string $gsm
 * @property string $adres
 * @property string $email
 * @property string $logo
 *
 * @property User $updatedBy
 * @property User $createdBy
 * @property User $user
 * @property Patient[] $patients
 */
class Dietist extends \yii\db\ActiveRecord
{
    
    public $file;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dietist';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'safe'],
            [['created_by', 'updated_by', 'user_id'], 'integer'],
            [['naam', 'voornaam', 'logo'], 'string', 'max' => 50],
            [['tel', 'gsm'], 'string', 'max' => 20],
            [['adres'], 'string', 'max' => 250],
            [['email'], 'email'],
            [['email'], 'string', 'max' => 255],
            [['file'], 'file','extensions' => 'jpg,png','maxSize' => 512000, 'tooBig' => Yii::t('app','Limiet foto is 500KB')],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }
    
    public function behaviors()
    {
        return [
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'user_id' => Yii::t('app', 'User ID'),
            'naam' => Yii::t('app', 'Naam'),
            'voornaam' => Yii::t('app', 'Voornaam'),
            'tel' => Yii::t('app', 'Tel'),
            'gsm' => Yii::t('app', 'Gsm'),
            'adres' => Yii::t('app', 'Adres'),
            'logo' => Yii::t('app', 'Logo'),
            'email' => Yii::t('app', 'Email'),
            'file' => Yii::t('app', 'Logo'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPatients()
    {
        return $this->hasMany(Patient::className(), ['dietist_id' => 'id']);
    }
    
    public function getprofile(){
        return \app\models\Dietist::findOne([
            'user_id'=>Yii::$app->user->id
        ]);
    }
    public function beforeSave($insert) {
        if(parent::beforeSave($insert)){
            
            $this->file = UploadedFile::getInstance($this, 'file');

            if ($this->file && $this->file->size>0) {  
                
                $dir='dietist/'.Yii::$app->user->id;
                if (!file_exists($dir)) {
                    mkdir($dir, 0777, true);
                }
                $this->logo='dietist/'.Yii::$app->user->id.'/' . md5($this->file->baseName.$this->naam.date('H:i:s')). '.' . $this->file->extension;
                $this->file->saveAs($this->logo);
                
            }
            return true;
            
        }
        else{
            return false;
        }
       
    }
}
