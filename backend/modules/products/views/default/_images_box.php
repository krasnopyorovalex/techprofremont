<?php

use yii\helpers\Html;

/* @var $model common\models\Products */
?>
<?php if ($model->images): ?>
    <div class="row">
        <?php foreach ($model->images as $img): ?>
            <div class="col-md-2 image-thumb">
                <div class="thumbnail">
                    <div class="thumb">
                        <?= Html::img('/userfiles/product_images/' . $model->id . '/' . $img->basename . '_thumb.' . $img->ext)?>
                        <div class="caption-overflow">
                        <span>
                            <a class="btn btn-flat border-white text-white btn-rounded btn-icon" href="/_root/products/delete-image/<?= $img->id?>">
                                <i class="icon-trash"></i>
                            </a>
                        </span>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>