<?php

use app\models\Brand;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Car */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="car-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'brand_id')->dropDownList(
        ArrayHelper::map(Brand::find()->all(),'id','name'), ['prompt' => 'Выбор марку авто']) ?>

    <?= $form->field($model, 'type_id')->dropDownList(ArrayHelper::map($types,'id','name'),
        empty($types) ? ['prompt' => 'Выбор модеи авто'] : []) ?>

    <?= $form->field($model, 'mileage')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <div class="container">
            <div class="row">
                <?php if (!empty($aDeviceTypes)) : ?>
                    <?php foreach ($aDeviceTypes as $iKey => $oDeviceType) : ?>
                        <div class="col-sm-3">
                            <label class="control-label"><?php echo $iKey ?></label><br>
                            <?php foreach ($oDeviceType as $oDevice) : ?>
                                <input type="checkbox" name="devices[]" value="<?php echo $oDevice['id'] ?>" multiple <?php echo (!empty($model->devices) && in_array($oDevice['id'], ArrayHelper::map($model->devices, 'id', 'id'))) ? 'checked' : false ?>> <?php echo $oDevice['title'] ?><br>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?= $form->field($model, 'images[]')->fileInput(['multiple' => true, 'accept' => 'image/*']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>


</div>
