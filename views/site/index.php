<?php

/* @var $this yii\web\View */
/* @var $model app\models\Url */
/* @var $form yii\widgets\ActiveForm */

use yii\helpers\Html;
use yii\widgets\ActiveForm;


$this->title = 'My Yii Application';

$url = Yii::$app->getUrlManager()->createUrl('url/send');

$this->registerJs("
var loader = $('.loader');
$( '#submit' ).click(function(event) {
    event.preventDefault();
    var result = $('#url-area').val().split(/\\n/);
    if ($(result).length > 0) {
        $.each(result, function( index, value ) {
        loader.css('display', 'block');
        
            $.ajax({
            url: '$url',
            data: { url: value },
            method: 'GET',
            success: function(data){
                loader.css('display', 'none');
                $('#tbody').append( '<tr><td>' + data.url + '</td><td>' + data.title + '</td><td>' + data.status_code + '</td></tr>' );
            }
            })
        
        })
        
    }
});
", \yii\web\View::POS_END);

$this->registerCss('.loader {
    border: 16px solid #f3f3f3; /* Light grey */
    border-top: 16px solid #3498db; /* Blue */
    border-radius: 50%;
    width: 120px;
    height: 120px;
    animation: spin 2s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}');

?>
<div class="site-index">

    <div class="url-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'url')->textarea(['id' => 'url-area']) ?>

        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'id' => 'submit']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
<table class="table" style="">
    <thead>
    <tr>
        <th>Url</th>
        <th>Title</th>
        <th>Status code</th>
    </tr>
    </thead>
    <tbody id="tbody">
    </tbody>
</table>
<div class="loader" style="display: none"></div>
