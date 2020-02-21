<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Все ваши контакты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <?php if(Yii::$app->user->isGuest): ?> 
        <h1>Войдите для просмотра списка контактов</h1>
    <?php else: ?> 
        <h1>Все ваши контакты</h1>
    <?php endif ?>
    <?php if (!Yii::$app->user->isGuest): ?>
    <div class="form-group">
        <label>Поиск</label>
        <input type="text" class="form-control" id="filter" placeholder="Начините вводить ФИО или номер контакта...">
    </div>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Phone</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
    <?php endif ?>
</div>


<?php 
if (!Yii::$app->user->isGuest) {
$js = <<<JS
$(document).ready(function() {
    table();
    $(document).on('keyup', '#filter', function () {
        var query = $(this).val();
        table(query)
    });

    function table(query = null)
    {
        $.ajax({
            url: '/my_test/web/site/all-contacts',
            method: 'GET',
            data: {query:query},
            dataType: 'json',
            success:function (data)
            {
                if(data) {
                    for (var row of data) {
                        var table = table +'<tr><td>' + row.id + '</td><td><a href="show?id=' + row.id + '">' + row.first_name + ' ' + row.last_name + '</a></td><td>' + row.email + '</td><td>' + row.phone + '</td></tr>';
                    }

                    $('tbody').html(table);
                } else {
                    $('tbody').html('Ничего не найдено');
                }
            }
        })
    }
});

JS;
$this->registerJs($js);
} 
?>