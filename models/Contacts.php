<?php

namespace app\models;

use yii\db\ActiveRecord;

class Contacts extends ActiveRecord
{
    public $first_name;
    public $last_name;
    public $email;
    public $phone;
    public $user_id;

    public function contactExists($email)
    {
        return self::find()->where(['email' => $email])->exists();
    }
}