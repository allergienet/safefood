<?php

namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "patient".
 *
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property int $user_id
 * @property int $dietist_id
 * @property string $naam
 * @property string $voornaam
 * @property string $tel
 * @property string $gsm
 * @property string $adres
 * @property string $extrainfo
 * @property string $email
 * @property string $verzoekregistratie
 * @property string $verzoekemail
 * @property string $signupkey
 *
 * @property Dietist $dietist
 * @property User $updatedBy
 * @property User $createdBy
 * @property User $user
 * @property Patientallergeen[] $patientallergeens
 */
class Patient extends \yii\db\ActiveRecord
{
    
    public $allergenen;
    public $ingredienten;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'patient';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at','allergenen','ingredienten'], 'safe'],
            [['created_by', 'updated_by', 'user_id', 'dietist_id'], 'integer'],
            [['extrainfo','verzoekregistratie'], 'string'],
            [['naam', 'voornaam'], 'string', 'max' => 50],
            [['email','signupkey'], 'string', 'max' => 255],
            [['verzoekemail'], 'string', 'max' => 255],
            [['email'], 'email'],
            [['verzoekemail'], 'email'],
            [['email'], 'string', 'max' => 255],
            [['tel', 'gsm'], 'string', 'max' => 20],
            [['adres'], 'string', 'max' => 250],
            [['dietist_id'], 'exist', 'skipOnError' => true, 'targetClass' => Dietist::className(), 'targetAttribute' => ['dietist_id' => 'id']],
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
            'id' => Yii::t('patient', 'ID'),
            'created_at' => Yii::t('patient', 'Created At'),
            'updated_at' => Yii::t('patient', 'Updated At'),
            'created_by' => Yii::t('patient', 'Created By'),
            'updated_by' => Yii::t('patient', 'Updated By'),
            'user_id' => Yii::t('patient', 'User ID'),
            'dietist_id' => Yii::t('patient', 'Dietist ID'),
            'naam' => Yii::t('patient', 'Naam'),
            'voornaam' => Yii::t('patient', 'Voornaam'),
            'tel' => Yii::t('patient', 'Tel'),
            'gsm' => Yii::t('patient', 'Gsm'),
            'adres' => Yii::t('patient', 'Adres'),
            'extrainfo' => Yii::t('patient', 'Extra informatie (enkel zichtbaar voor u)'),
            'allergenen' => Yii::t('patient', 'Intolerantie voor allergenen:'),
            'ingredienten' => Yii::t('patient', 'Intolerantie voor ingrediënten:'),
            'email' => Yii::t('patient', 'Email'),
            'verzoekregistratie' => Yii::t('patient', 'Datum wanneer uitnodiging is verstuurd'),
            'verzoekemail' => Yii::t('patient', 'Email naar waar uitnodiging is verstuurd'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDietist()
    {
        return $this->hasOne(Dietist::className(), ['id' => 'dietist_id']);
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
    public function getPatientallergeens()
    {
        return $this->hasMany(Patientallergeen::className(), ['patient_id' => 'id']);
    }
    
    public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);
        
        $transaction = \Yii::$app->db->beginTransaction();
        try{
            
            $oldItems=  ArrayHelper::map(Patientallergeen::find()->where(['patient_id'=>$this->id])->all(), 'id', 'id');
            $newItems=array();
            if(!empty($this->allergenen)){
                foreach ($this->allergenen as $item){
                    $pamodel=  Patientallergeen::findOne(['patient_id'=>$this->id,'allergeen_id'=>$item]);

                    if(empty($pamodel)){
                        $pamodel=new Patientallergeen();
                    }

                    $pamodel->patient_id= $this->id;
                    $pamodel->allergeen_id= $item;
                    
                    $pamodel->save();
                    array_push($newItems,['id'=>$pamodel->id]);


                }
            }

            $deletedItems = array_diff($oldItems, array_filter(ArrayHelper::map($newItems, 'id', 'id')));
            if (! empty($deletedItems)) {
                Patientallergeen::deleteAll(['id' => $deletedItems]);
            }
            $oldItems=  ArrayHelper::map(Patientingredient::find()->where(['patient_id'=>$this->id])->all(), 'id', 'id');
            $newItems=array();
            if(!empty($this->ingredienten)){
                foreach ($this->ingredienten as $item){
                    $pimodel=  Patientingredient::findOne(['patient_id'=>$this->id,'ingredient_id'=>$item]);

                    if(empty($pimodel)){
                        $pimodel=new Patientingredient();
                    }

                    $pimodel->patient_id= $this->id;
                    $pimodel->ingredient_id= $item;
                    
                    $pimodel->save();
                    array_push($newItems,['id'=>$pimodel->id]);


                }
            }

            $deletedItems = array_diff($oldItems, array_filter(ArrayHelper::map($newItems, 'id', 'id')));
            if (! empty($deletedItems)) {
                Patientingredient::deleteAll(['id' => $deletedItems]);
            }
            
            
            $transaction->commit();
            
        } catch (\Exception $e) {
            $transaction->rollBack();
            Yii::$app->getSession()->setFlash('danger', 'Er heeft zich een onbekende fout voorgedaan.');
            return false;
        }
    }
    
    public function hasaccess(){
        if($this->hasaccount()){
            if($this->user->activated==1){
                return true;
            }
        }
        return false;
    }
    public function hasaccount(){
        if(!empty($this->user)){
            return true;
        }
        return false;
    }
    
    public function setsignupkey(){
        $this->signupkey=\Yii::$app->security->generatePasswordHash(random_bytes(15).date('Y-m-d H:i:s'));
        $this->updateAttributes([
            'signupkey'=>$this->signupkey
        ]);
    }
    public function sendsingupinvitation($body){
        if(
            Yii::$app->mailer->compose('@app/mail/layouts/html.php',['content'=>$body])
            ->setTo($this->email)
            ->setFrom(['inf@safefood.be' => 'Safefood'])
            ->setSubject('Safefood - Uitnodiging om je account te registeren')
            ->send()){
                $this->updateAttributes([
                    'verzoekregistratie'=>date('Y-m-d H:i:s'),
                    'verzoekemail'=>$this->email,
                ]);
            return true;
        }
        return false;
    }
    
    public function getprofile(){
        return \app\models\Patient::findOne([
            'user_id'=>Yii::$app->user->id
        ]);
    }
}
