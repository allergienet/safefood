<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "productgroep".
 *
 * @property int $id
 * @property string $created_at
 * @property int $created_by
 * @property string $updated_at
 * @property int $updated_by
 * @property string $naam
 *
 * @property Product[] $products
 */
class Productgroep extends \yii\db\ActiveRecord
{
    
    public $aantalproducten;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'productgroep';
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
            'id' => Yii::t('productgroep', 'ID'),
            'created_at' => Yii::t('productgroep', 'Created At'),
            'created_by' => Yii::t('productgroep', 'Created By'),
            'updated_at' => Yii::t('productgroep', 'Updated At'),
            'updated_by' => Yii::t('productgroep', 'Updated By'),
            'naam' => Yii::t('productgroep', 'Naam'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['productgroep_id' => 'id']);
    }
}
