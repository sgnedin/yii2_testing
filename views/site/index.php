<?php

use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">
    <div class="jumbotron">
        <h1>Добро пожаловать, 
            
            <?= Yii::$app->user->identity->user_name ?? 'гость' ?> !
            
        </h1>
        <p class="lead">Вы зашли в веб контакты</p>
    </div>
</div>