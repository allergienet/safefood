<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "allergeenproduct".
 *
 * @property int $id
 * @property string $created_at
 * @property int $created_by
 * @property string $updated_at
 * @property int $updated_by
 * @property int $allergeen_id
 * @property int $product_id
 * @property bool $bevatsporen
 * @property bool $bevatinproductielijn
 *
 * @property Allergeen $allergeen
 * @property Product $product
 */
class Allergeenproduct extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'allergeenproduct';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'safe'],
            [['created_by', 'updated_by', 'allergeen_id', 'product_id'], 'integer'],
            [['bevatsporen', 'bevatinproductielijn'], 'boolean'],
            [['allergeen_id'], 'exist', 'skipOnError' => true, 'targetClass' => Allergeen::className(), 'targetAttribute' => ['allergeen_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('allergeenprodukt', 'ID'),
            'created_at' => Yii::t('allergeenprodukt', 'Created At'),
            'created_by' => Yii::t('allergeenprodukt', 'Created By'),
            'updated_at' => Yii::t('allergeenprodukt', 'Updated At'),
            'updated_by' => Yii::t('allergeenprodukt', 'Updated By'),
            'allergeen_id' => Yii::t('allergeenprodukt', 'Allergeen ID'),
            'product_id' => Yii::t('allergeenprodukt', 'Product ID'),
            'bevatsporen' => Yii::t('allergeenprodukt', 'Bevatsporen'),
            'bevatinproductielijn' => Yii::t('allergeenprodukt', 'Bevatinproductielijn'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAllergeen()
    {
        return $this->hasOne(Allergeen::className(), ['id' => 'allergeen_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
}
