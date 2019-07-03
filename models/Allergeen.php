<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "allergeen".
 *
 * @property int $id
 * @property string $created_at
 * @property int $created_by
 * @property string $updated_at
 * @property int $updated_by
 * @property string $naam
 *
 * @property Allergeenproduct[] $allergeenproducts
 */
class Allergeen extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'allergeen';
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
            'id' => Yii::t('allergeen', 'ID'),
            'created_at' => Yii::t('allergeen', 'Created At'),
            'created_by' => Yii::t('allergeen', 'Created By'),
            'updated_at' => Yii::t('allergeen', 'Updated At'),
            'updated_by' => Yii::t('allergeen', 'Updated By'),
            'naam' => Yii::t('allergeen', 'Naam'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAllergeenproducts()
    {
        return $this->hasMany(Allergeenproduct::className(), ['allergeen_id' => 'id']);
    }
}
