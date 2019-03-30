<?php
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
?>

<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="row">
                <div class="col-md-12 text-center">
                    <?php echo Html::img('@web/uploads/car/' . $oModel->id . '/thumbs/' . $oModel->largeImage->name,
                        ['width' => 500, 'height' => 300, 'class' => 'card-img-top', 'id' => 'large-image']) ?>
                </div>
                <?php if (!empty($oModel->smallImages)) : ?>
                    <?php foreach ($oModel->smallImages as $oImage) : ?>
                        <div class="col-md-4">
                            <?php echo Html::img('@web/uploads/car/' . $oModel->id . '/thumbs/' . $oImage->name,
                                ['width' => 146, 'height' => 106, 'class' => 'card-img-top', 'id' => 'small-image', 'data-name' => $oImage->name]) ?>
                        </div>
                    <?php endforeach ; ?>
                <?php endif; ?>
            </div>
        </div>
        <div class="col-md-6 col-md-offset-2">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td>Марка</td>
                        <td>
                            <?php echo $oModel->brand->name ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Модель</td>
                        <td>
                            <?php echo $oModel->type->name ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Телефон</td>
                        <td>
                            <?php echo $oModel->phone ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Пробег</td>
                        <td>
                            <?php echo $oModel->mileage ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Цена</td>
                        <td>
                            <?php echo $oModel->price ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Оборудование</td>
                        <td>
                            <?php if (!empty($oModel->devices)) : ?>
                                <?= implode(', ', ArrayHelper::map($oModel->devices, 'id', 'title')) ?>
                            <?php else: ?>
                                Отсутствует!!!
                            <?php endif; ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>