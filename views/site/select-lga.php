<!-- views/site/select-lga.php -->
<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
/** @var yii\web\View $this */
$this->title = 'Bincon poll|state view';
?>

<div class="select-lga">
    <p class="py-2 text">Kindly select a local government from the select box to view the <span class="muted"> election summary</span> </p>

    <?php $form = ActiveForm::begin(['action' => ['site/display-results']]); ?>

        <select name="lga_uniqueid" class="form-control my-3">
            <?php foreach($lgas as $lga) : ?>
                <option value="<?= $lga->uniqueid ?>"><?= $lga->lga_name ?></option>
            <?php endforeach ?>
        </select>
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-light shadow']) ?>
        </div>
    <?php ActiveForm::end(); ?>
</div>
<div id="carouselExampleControls" class="carousel slide d-flex justify-content-center align-items-center " data-bs-ride="carousel">
    <div class="carousel-indicators mt-2">
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner w-50">
        <div class="carousel-item active">
            <img src="<?= Yii::$app->urlManager->baseUrl ?>/assets/img/2023-election.webp" alt="" class="img-fluid">
        </div>

        <div class="carousel-item w-100">
            <img src="<?= Yii::$app->urlManager->baseUrl ?>/assets/img/slider-2.jpg" alt="" class="img-fluid">
            <div class="carousel-caption d-none d-md-block  rounded" style="background-color: rgba(0, 0, 0, 0.4);">
                <h5>Vote and not Fight</h5>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ducimus rerum iure dolores earum atque pariatur facere, </p>
            </div>
        </div>
        <div class="carousel-item">
            <img src="<?= Yii::$app->urlManager->baseUrl ?>/assets/img/slider-3.webp" alt="" class="img-fluid rounded">
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
        <span class="carousel-control-prev-icon bg-success p-4 rounded" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
        <span class="carousel-control-next-icon bg-success p-4 rounded" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>
