<!-- views/site/display-results.php -->
<?php
use yii\helpers\Html;
use app\models\AnnouncedPuResults;

/** @var yii\web\View $this */

$this->title = 'Bincon poll|state results';
?>

<div class="display-results">
    <?php if (!empty($pollingUnits)): ?>
        <p class="text ">Polling Units in  <?= $selectedLgaName ?> Local Government Area</p>
            <div class="card shadow-sm p-5 mx-3">
                <div class="card-body">
                    <h5 class="card-title mb-4">Party Total scores in <?= $selectedLgaName ?> LGA</h5>
                    <ul class="list-group">
                        <?php foreach ($partyTotals as $partyAbbreviation => $totalScore): ?>
                            <li class="list-group-item">
                                <?= "{$partyAbbreviation} total score: {$totalScore}" ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <p class="card-text text-muted my-2 py-3 px-3 shadow-sm">LGA TOTAL Score is <?= $totalLgaScore ?></p>
                </div>
            </div>
        
                <?php foreach ($pollingUnits as $index => $pollingUnit): ?>
                    <div class="row">
                        <div class="card p-5 mx-3  my-4 shadow-sm">
                            <div class="card-body">
                                    <div class="">
                                        <?= $index + 1 ?>
                                        <div class="mb-3">
                                            <h6 class="bold m-0">Polling Unit Name </h6> 
                                            <span class="text-muted"><?= Html::encode($pollingUnit->polling_unit_name) ?></span>
                                        </div>
                                        <div class="mb-3">
                                            <h6 class="bold m-0">Polling Unit Number:</h6>
                                            <span class="text-muted"><?= Html::encode($pollingUnit->polling_unit_number) ?></span> 
                                        </div>  
                                    </div>
                                    <div class="mb-3">
                                        <h6 class="bold m-0">Party Votes</h6>
                                        <span class="text-muted">
                                            <?php
                                                $partyScores = [];
                                                foreach ($pollingUnit->announcedResults as $result) {
                                                    $partyAbbreviation = $result->party_abbreviation;
                                                    $partyScore = $result->party_score;

                                                    $partyScores[$partyAbbreviation] = ($partyScores[$partyAbbreviation] ?? 0) + $partyScore;
                                                }
                                                foreach ($partyScores as $partyAbbreviation => $totalScore) {
                                                    echo "({$partyAbbreviation} = {$totalScore}),   ";
                                                }
                                            ?>
                                        </span>
                                    </div>
                                <div>
                                <h6 class="bold m-0">Total polling Unit Votes</h6>
                                <span class="text-muted"><?= array_sum($partyScores) ?></span> 
                                </div>
                            </div>
                        </div>
                    </div>         
                <?php endforeach; ?>
                
            </tbody>
        </table>
    <?php else: ?>
        <p>No polling units found for the selected LGA.</p>
    <?php endif; ?>
</div>
