<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Product;

/**
 * ProductSearch represents the model behind the search form of `app\models\Product`.
 */
class ProductSearch extends Product
{
    public $allergenen;
    public $productgroepen;
    public $ingredienten;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'created_by', 'updated_by', 'naam', 'foto', 'productgroep_id'], 'integer'],
            [['created_at', 'updated_at','productgroepen','allergenen','ingredienten'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Product::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            print_r($this->errors);
            die();
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'naam' => $this->naam,
            'foto' => $this->foto,
            'productgroep_id' => $this->productgroep_id,
        ]);
        
        
        $query->joinWith(['productgroep']);
        
        if(!empty($this->allergenen)){
            $query->andFilterWhere(['not exists',
                (new \yii\db\Query())
                ->from('allergeenproduct')
                ->andFilterWhere(['and',
                    ['in','allergeen_id',$this->allergenen],
                    ['=','allergeenproduct.product_id',new \yii\db\Expression('product.id')]
                ])
            ]);
        }
        if(!empty($this->ingredienten)){
            $query->andFilterWhere(['not exists',
                (new \yii\db\Query())
                ->from('ingredientproduct')
                ->andFilterWhere(['and',
                    ['in','ingredient_id',$this->ingredienten],
                    ['=','ingredientproduct.product_id',new \yii\db\Expression('product.id')]
                ])
            ]);
        }
        
        $query->andFilterWhere([
            'and',
            ['in','productgroep_id',$this->productgroepen]
        ]);
        
       
        $query->groupBy('product.id');
        
        $query->orderBy('productgroep.naam asc ','product.naam asc');
        
        return $dataProvider;
    }
}
