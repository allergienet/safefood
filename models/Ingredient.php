<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ingredient".
 *
 * @property int $id
 * @property string $created_at
 * @property int $created_by
 * @property string $updated_at
 * @property int $updated_by
 * @property string $naam
 *
 * @property Ingredientproduct[] $ingredientproducts
 */
class Ingredient extends \yii\db\ActiveRecord
{
    public $aantalproducten;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ingredient';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
            [['naam'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('ingredient', 'ID'),
            'created_at' => Yii::t('ingredient', 'Created At'),
            'created_by' => Yii::t('ingredient', 'Created By'),
            'updated_at' => Yii::t('ingredient', 'Updated At'),
            'updated_by' => Yii::t('ingredient', 'Updated By'),
            'naam' => Yii::t('ingredient', 'Naam'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIngredientproducts()
    {
        return $this->hasMany(Ingredientproduct::className(), ['ingredient_id' => 'id']);
    }
}
