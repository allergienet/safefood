<?php

namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;
/**
 * This is the model class for table "ingredientproduct".
 *
 * @property int $id
 * @property string $created_at
 * @property int $created_by
 * @property string $updated_at
 * @property int $updated_by
 * @property int $ingredient_id
 * @property int $product_id
 *
 * @property Ingredient $ingredient
 * @property Product $product
  * @property User $createdBy 
 * @property User $updatedBy
 */
class Ingredientproduct extends \yii\db\ActiveRecord
{
    public $ingredientnaam;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ingredientproduct';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'safe'],
            [['created_by', 'updated_by', 'ingredient_id', 'product_id'], 'integer'],
            [['ingredient_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ingredient::className(), 'targetAttribute' => ['ingredient_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']], 
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']], 
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('ingredientprodukt', 'ID'),
            'created_at' => Yii::t('ingredientprodukt', 'Created At'),
            'created_by' => Yii::t('ingredientprodukt', 'Created By'),
            'updated_at' => Yii::t('ingredientprodukt', 'Updated At'),
            'updated_by' => Yii::t('ingredientprodukt', 'Updated By'),
            'ingredient_id' => Yii::t('ingredientprodukt', 'Ingredient ID'),
            'product_id' => Yii::t('ingredientprodukt', 'Product ID'),
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
     * @return \yii\db\ActiveQuery
     */
    public function getIngredient()
    {
        return $this->hasOne(Ingredient::className(), ['id' => 'ingredient_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
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
}
