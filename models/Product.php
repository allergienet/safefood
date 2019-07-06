<?php

namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;
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
    public $arrallergenen;
    public $arringredienten;
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
            [['productgroep_id','naam'],'required'],
            [['created_at', 'updated_at','arrallergenen','arringredienten'], 'safe'],
            [['created_by', 'updated_by', 'productgroep_id'], 'integer'],
            [['naam'], 'string', 'max' => 300],
            [['foto'], 'string', 'max' => 50],
            [['file'], 'file','extensions' => 'jpg,png','maxSize' => 512000, 'tooBig' => Yii::t('app','Limiet foto is 500KB')],
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
        return $this->hasMany(Allergeenproduct::className(), ['product_id' => 'id'])->orderBy('bevatsporen asc,bevatinproductielijn asc');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIngredientproducts()
    {
        return $this->hasMany(Ingredientproduct::className(), ['product_id' => 'id'])->joinwith('ingredient')->orderBy('ingredient.naam');
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
            
            $this->file = UploadedFile::getInstance($this, 'file');

            if ($this->file && $this->file->size>0) {  
                
                $dir='product/'.Yii::$app->user->id;
                if (!file_exists($dir)) {
                    mkdir($dir, 0777, true);
                }
                $this->foto='product/'.Yii::$app->user->id.'/' . md5($this->file->baseName.$this->naam.$this->productgroep_id.date('H:i:s')). '.' . $this->file->extension;
                $this->file->saveAs($this->foto);
            }
            if(empty($this->foto)){
                return false;
            }
        
            return true;
        }
        else{
            return false;
        }
       
    }
    public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);
        $transaction = \Yii::$app->db->beginTransaction();
        try{
            $oldItems=  ArrayHelper::map(Allergeenproduct::find()->where(['product_id'=>$this->id])->all(), 'id', 'id');
            $newItems=array();
            if(!empty($this->arrallergenen)){
                foreach ($this->arrallergenen as $allergeen_id=>$item){
                    $apmodel=  Allergeenproduct::findOne(['product_id'=>$this->id,'allergeen_id'=>$allergeen_id]);

                    if(empty($apmodel)){
                        $apmodel=new Allergeenproduct();
                    }

                    $apmodel->product_id= $this->id;
                    $apmodel->allergeen_id= $allergeen_id;
                    if(isset($item['sporen'])){
                        $apmodel->bevatsporen=$item['sporen'];
                    }
                    else{
                        $apmodel->bevatsporen=null;
                    }
                    if(isset($item['productielijn'])){
                        $apmodel->bevatinproductielijn=$item['productielijn'];
                    }
                    else{
                        $apmodel->bevatinproductielijn=null;
                    }

                    $apmodel->save();
                    array_push($newItems,['id'=>$apmodel->id]);


                }
            }

            $deletedItems = array_diff($oldItems, array_filter(ArrayHelper::map($newItems, 'id', 'id')));
            if (! empty($deletedItems)) {
                Allergeenproduct::deleteAll(['id' => $deletedItems]);
            }
            
            
            $oldItems=  ArrayHelper::map(Ingredientproduct::find()->where(['product_id'=>$this->id])->all(), 'id', 'id');
            $newItems=array();
            if(!empty($this->arringredienten)){
                foreach ($this->arringredienten as $item){
                    $ipmodel=  Ingredientproduct::findOne(['product_id'=>$this->id,'ingredient_id'=>$item]);

                    if(empty($ipmodel)){
                        $ipmodel=new Ingredientproduct();
                    }

                    $ipmodel->product_id= $this->id;
                    $ipmodel->ingredient_id= $item;
                    
                    $ipmodel->save();
                    array_push($newItems,['id'=>$ipmodel->id]);


                }
            }

            $deletedItems = array_diff($oldItems, array_filter(ArrayHelper::map($newItems, 'id', 'id')));
            if (! empty($deletedItems)) {
                Ingredientproduct::deleteAll(['id' => $deletedItems]);
            }
            
            
            $transaction->commit();
            
        } catch (\Exception $e) {
            $transaction->rollBack();
            Yii::$app->getSession()->setFlash('danger', 'Er heeft zich een onbekende fout voorgedaan.');
            return false;
        }
        
        return true;
    }
}
