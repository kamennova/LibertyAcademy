<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Trainer]].
 *
 * @see Trainer
 */
class TrainerQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Trainer[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Trainer|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
