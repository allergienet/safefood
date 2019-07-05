<?php

namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\web\UploadedFile;
/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string $created_at
 * @property int $created_by
 * @property string $updated_at
 * @property int $updated_by
 * @property string $naam
 * @property string $foto
 * @property int $productgroep_id
 *
 * @property Allergeenproduct[] $allergeenproducts
 * @property Ingredientproduct[] $ingredientproducts
 * @property Productgroep $productgroep
 * @property User $createdBy 
 * @property User $updatedBy
 */
class Product extends \yii\db\ActiveRecord
{
    public $gridproductgroep;
    public $file;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'safe'],
            [['created_by', 'updated_by', 'productgroep_id'], 'integer'],
            [['naam'], 'string', 'max' => 300],
            [['foto'], 'string', 'max' => 50],
            [['file'], 'file','extensions' => 'jpg,png'],
            [['productgroep_id'], 'exist', 'skipOnError' => true, 'targetClass' => Productgroep::className(), 'targetAttribute' => ['productgroep_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']], 
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']], 
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
            'id' => Yii::t('product', 'ID'),
            'created_at' => Yii::t('product', 'Created At'),
            'created_by' => Yii::t('product', 'Created By'),
            'updated_at' => Yii::t('product', 'Updated At'),
            'updated_by' => Yii::t('product', 'Updated By'),
            'naam' => Yii::t('product', 'Naam'),
            'foto' => Yii::t('product', 'Foto'),
            'file' => Yii::t('product', 'Foto'),
            'productgroep_id' => Yii::t('product', 'Productgroep'),
            'gridproductgroep' => Yii::t('product', 'Productgroep'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAllergeenproducts()
    {
        return $this->hasMany(Allergeenproduct::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIngredientproducts()
    {
        return $this->hasMany(Ingredientproduct::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductgroep()
    {
        return $this->hasOne(Productgroep::className(), ['id' => 'productgroep_id']);
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
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }
    
    
    public function beforeSave($insert) {
        if(parent::beforeSave($insert)){
            
            if(empty($this->foto)){
                $this->file = UploadedFile::getInstance($this, 'file');

                if ($this->file && $this->file->size>0) {  

                    $dir='product/'.Yii::$app->user->id;
                    if (!file_exists($dir)) {
                        mkdir($dir, 0777, true);
                    }
                    $this->foto='product/'.Yii::$app->user->id.'/' . md5($this->file->baseName). '.' . $this->file->extension;
                    $this->file->saveAs($this->foto);

                }
                else{
                    Yii::$app->session->setFlash('danger',Yii::t('app','Gelieve een foto op te laden'));
                    return false;
                }
            }
        
            return true;
        }
        else{
            return false;
        }
       
    }
}
