<?php

namespace app\models;

use yii\base\Model;
use app\models\Contacts;

class NewContactForm extends Model
{
    public $first_name;
    public $last_name;
    public $email;
    public $phone;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'email', 'phone'], 'required'],
            ['email', 'email'],
            ['email', 'emailExists'],
            [['phone', 'first_name', 'last_name'], 'string'],
            ['phone', 'match', 'pattern' => '/^(8)[(](\d{3})[)](\d{3})[-](\d{2})[-](\d{2})/', 'message' => 'Телефона, должно быть в формате 8(XXX)XXX-XX-XX']
        ];
    }

    public function emailExists($attribute, $params)
    {
        if((new Contacts())->contactExists($this->email)) {
            $this->addError($attribute, 'Такой контакт уже есть!');
        }
    }
}
