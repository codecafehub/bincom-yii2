<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\AnnouncedPuResults $model */ // Change the model class

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Bincom poll|score';
?>

<div class="site ">
    <?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>

        <div class="alert alert-success">
            Thank you for contacting us. We will respond to you as soon as possible.
        </div>
    <?php else: ?>
        <div class="row d-flex justify-content-between align-items-center py-5 px-5 shadow-md" style="background:#3DAD66">
            <div class="col-lg-5 text-light">
                <h6 class="text-light">Fill the Form below to Store result for all parties</h6>
                <?php $form = ActiveForm::begin(['id' => 'store-score']); ?>

                    <?= $form->field($model, 'polling_unit_uniqueid')->dropDownList(
                        ['' => '--- select polling unit ---'] + array_column($polling_units, 'polling_unit_name', 'uniqueid')
                    )->label(false) ?>

                    <?= $form->field($model, 'party_abbreviation')->dropDownList(
                        ['' => '--- select party ---'] + array_column($party_names, 'partyname', 'partyname')
                    )->label(false) ?>

                   <?= $form->field($model, 'party_score')->textInput(['class' => 'form-control mb-3', 'placeholder' => 'Enter party score'])->label(false) ?>

                   <?= $form->field($model, 'entered_by_user')->textInput(['class' => 'form-control mb-3', 'placeholder' => 'Enter your name'])->label(false) ?>

                   <?= $form->field($model, 'date_entered')->textInput(['type' => 'date', 'class' => 'form-control mb-3'])->label(false) ?>

                    <div class="form-group">
                        <?= Html::submitButton('Submit', ['class' => 'btn btn-light', 'name' => 'contact-button']) ?>
                    </div>
                <?php ActiveForm::end(); ?>
            </div>
            <div class="col-lg-5 ">
                <img src="<?= Yii::$app->urlManager->baseUrl ?>/assets/img/2023-election.webp" alt="" class="img-fluid">
            </div>
        </div>
    <?php endif; ?>
</div>
