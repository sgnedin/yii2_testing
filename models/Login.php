<?php

namespace app\models;

use yii\base\Model;
use app\models\User;

class Login extends Model
{
    public $username;
    public $password;

    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            ['password',  'validatePassword']
        ];
    }

    public function validatePassword($attribute, $params)
    {
        $user = User::findOne(['user_name' => $this->username]);

        if(!$user || $user->password !== sha1($this->password))
        {
            $this->addError($attribute, 'Пароль или пользователь введены неверно');
        }
    }

    public function getUser()
    {
        return User::findOne(['user_name' => $this->username]);
    }
}