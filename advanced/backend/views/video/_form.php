<?php

use yii\helpers\Html;
// use yii\widgets\ActiveForm;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Video */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="video-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>
         <div class="row">
            <div class="col-sm-6">
                <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'description')->textarea(['rows' => 11]) ?>
                <?= $form->field($model, 'tags')->textInput(['maxlength' => true]) ?>
                <div class="form-group">
                    <label><?php echo $model->getAttributeLabel('thumpnail')?></label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="thumpnail">
                        <label class="custom-file-label" for="thumpnail" >Choose file</label>
                    </div>
                </div>
                <?= $form->field($model, 'status')->dropDownList($model->getStatusLabels()) ?> 
                <div class="form-group">
                    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                </div>
            </div>
            <div class="col-sm-1"></div>
            <div class="col-sm-4">
                <div class="row mb-3 ml-1">
                    <div class="mr-5">
                        <div class="text-muted mb-3">VIDEO LINK</div>
                        <a href='<?php echo $model->getVideoLink()?>' > OPEN VIDEO </a>
                    </div>
                    <div class="mr-5">
                        <div class="text-muted mb-3">VIDEO NAME</div>
                        <?php echo $model->video_name?>
                    </div>        
                </div>
                <div class="row mr-5 ml-1">
                    <div class="text-muted mb-3">VIDEO PREVIEW</div>
                    <video class="embed-responsive round mb-3" src='<?php echo $model->getVideoLink()?>' autoplay controls> OPEN VIDEO </video>
                </div>
                <!-- <div class="row mr-5 ml-1">
                    <div class="form-group">
                        <label><?php echo $model->getAttributeLabel('thumpnail')?></label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="thumpnail" aria-describedby="thumpnail">
                            <label class="custom-file-label" for="thumpnail" >Choose file</label>
                            <img class="round mt-3" id="imagePreview" src="not-found-image.jpg"/>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
    <?php ActiveForm::end(); ?>

</div>
