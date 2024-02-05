
<?php

use yii\helpers\Html;
/** @var yii\web\View $this */

$this->title = 'Announced Polling Unit Results';

?>

<div class="body-content">
        <div class="row">
            <p><?= $this->title ?></p>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">SNO</th>
                        <th scope="col">Party Abbreviation</th>
                        <th scope="col">Party Score</th>
                        <th scope="col">Entered By</th>
                        <th scope="col">Date Entered</th>
                        <th scope="col">User IP Address</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $index => $result): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= Html::encode($result->party_abbreviation) ?></td>
                            <td><?= $result->party_score ?></td>
                            <td><?= $result->entered_by_user ?></td>
                            <td><?= $result->date_entered ?></td>
                            <td><?= $result->user_ip_address ?></td>
                            <td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
</div>

</div>

