<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = 'Машины';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="container">
        <div class="row">
            <?php if (!empty($models)) :?>
                <?php foreach ($models as $key => $model) : ?>
                    <div class="col-sm-2">
                        <div class="card mb-2 box-shadow" id="car-img">
                            <?php echo Html::img('@web/uploads/car/' . $model->id . '/thumbs/' . $model->smallImage->name,
                                ['class' => 'card-img-top']) ?>
                            <div class="card-body">
                                <p class="card-text">Марка : <a href=""><?php echo $model->brand->name ?></a></p>
                                <p class="card-text">Модель : <a href="<?php echo Url::to(['site/car-detail', 'id' => $model->id]) ?>"><?php echo $model->type->name ?></a></p>
                                <p class="card-text">Цена : <?php echo $model->price ?></p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <?php echo Html::a('Удалить', Url::to(['/site/remove-car', 'id' => $model->id]),
                                        ['data-method' => 'POST', 'class' => 'btn btn-danger btn-block']) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <?php echo LinkPager::widget([
            'pagination' => $pages,
        ]); ?>

    </div>

</div>
