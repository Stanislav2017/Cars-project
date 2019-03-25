<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DeviceType */

$this->title = 'Добавить тп оборудования';
$this->params['breadcrumbs'][] = ['label' => 'Типы оборудования', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="device-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
