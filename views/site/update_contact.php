<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Изменить контакт';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">

    <?php if(!Yii::$app->user->isGuest):?>
        
        <h1><?= Html::encode($this->title) ?></h1>

        <?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>

            <div class="alert alert-success">
                Контакт сохранен
            </div>

        <?php else: ?>

            <p>
                Изменеие контакта
            </p>

            <div class="row">
                <div class="col-lg-5">

                    <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

                        <?= $form->field($model, 'first_name')->textInput(['autofocus' => true, 'value' => $contact['first_name']])?>

                        <?= $form->field($model, 'last_name')->textInput(['value' => $contact['last_name']]) ?>

                        <?= $form->field($model, 'email')->textInput(['value' => $contact['email']]) ?>

                        <?= $form->field($model, 'phone')->textInput(['value' => $contact['phone']]) ?>

                        <div class="form-group">
                            <?= Html::submitButton('Обновить', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                        </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>

        <?php endif ?>

    <?php else: ?>

        <h1>Войдите чтобы редактировать контакт</h1>

    <?php endif ?>
</div>
