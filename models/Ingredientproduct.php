<?php

namespace app\models;

use Yii;

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
 */
class Ingredientproduct extends \yii\db\ActiveRecord
{
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
}
