<?php

/** @var yii\web\View $this */
use yii\helpers\Html;
use yii\widgets\LinkPager;

$this->title = 'Bincom poll';

?>
<div class="site-index">
    <div class="body-content">
        <div class="row">
            <p class="text py-2">List of All Polling Units</p>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">SNO</th>
                        <th scope="col">PU Name</th>
                        <th scope="col">PU Number</th>
                        <th scope="col">PU Description</th>
                        <th scope="col">PU Ward</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($punit as $index => $pu): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= $pu->polling_unit_name ?></td>
                            <td><?= $pu->polling_unit_number ?></td>
                            <td><?= $pu->polling_unit_description ?></td>
                            <td><?= $pu->ward_id ?></td>
                            <td>
                            <?= Html::a('View Result', ['site/view', 'id' => $pu->uniqueid], ['class' => 'btn btn-secondary']) ?>

                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <?= LinkPager::widget(['pagination' => $pagination]) ?>
        </div>
    </div>
</div>
