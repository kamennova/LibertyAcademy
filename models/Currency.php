<?php

namespace app\models;


/**
 * This is the model class for table "currency".
 * @property integer $id
 * @property string $currency_name
 * @property string $currency_code
 * @property string $currency_symbol
 */
class Currency extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'currency';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['currency_name', 'currency_code', 'currency_symbol'], 'required'],
            [['currency_name', 'currency_code'], 'string']
        ];
    }
}