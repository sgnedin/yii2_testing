<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Все ваши контакты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <?php if (!Yii::$app->user->isGuest): ?>
        <? if($contact): ?>
            <h2>Детальная информация</h2>
            <div class="card mb-3" style="max-width: 540px;">
                <div class="row no-gutters">
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title"><?= $contact['first_name'] . ' ' . $contact['last_name'] ?></h5>
                            <p class="card-text"><?= $contact['email'] ?></p>
                            <p class="card-text"><?= $contact['phone'] ?></small></p>
                        </div>
                    </div>
                </div>
            </div>
        <a href="show-update?id=<?= $contact['id'] ?>" class="btn btn-info">Изменить</a>
    <?php endif ?>
</div>
