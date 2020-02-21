<?php

namespace app\models;

use app\models\NewContactForm;
use app\models\Contacts;

class UpdateContactForm extends NewContactForm
{
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'email', 'phone'], 'required'],
            ['email', 'email'],
            [['phone', 'first_name', 'last_name'], 'string'],
            ['phone', 'match', 'pattern' => '/^(8)[(](\d{3})[)](\d{3})[-](\d{2})[-](\d{2})/', 'message' => 'Телефона, должно быть в формате 8(XXX)XXX-XX-XX']
        ];
    }
}