<?php

namespace app\models;

use Yii;

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
 */
class Product extends \yii\db\ActiveRecord
{
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
            [['productgroep_id'], 'exist', 'skipOnError' => true, 'targetClass' => Productgroep::className(), 'targetAttribute' => ['productgroep_id' => 'id']],
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
            'productgroep_id' => Yii::t('product', 'Productgroep ID'),
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
}
