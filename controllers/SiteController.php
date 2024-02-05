<?php

namespace app\controllers;

use Yii;
use app\models\Lga;
use app\models\Party;
use yii\web\Response;
use yii\web\Controller;
use yii\data\Pagination;
use app\models\PollingUnit;
use app\models\AnnouncedPuResults;

class SiteController extends Controller
{
   
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $query = PollingUnit::find();
            $pagination = new Pagination([
                'defaultPageSize' => 5,
                'totalCount' => $query->count(),
            ]);
            $punit = $query
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        return $this->render('index',
         [
            'punit' => $punit,
            'pagination' => $pagination,
        ]);
    }

    public function actionView($id)
    {
        $results = AnnouncedPuResults::find()->where(['polling_unit_uniqueid' => $id])->all();
        return $this->render('view', ['results' => $results]);
    }


    public function actionSelectLga()
    {
        $query = Lga::find();
        $lgas =  $query->all();
        return $this->render('select-lga', [
            'lgas' => $lgas,
        ]);
    }


    public function actionDisplayResults()
    {
        $request = Yii::$app->request;
        $selectedLgaUniqueId = $request->post('lga_uniqueid');
    
        $selectedLga = Lga::findOne(['uniqueid' => $selectedLgaUniqueId]);
        $pollingUnits = PollingUnit::find()->where(['lga_id' => $selectedLgaUniqueId])->all();
        $selectedLgaName = ($selectedLga !== null) ? $selectedLga->lga_name : '';
        $announcedResults = AnnouncedPuResults::find()
            ->joinWith('pollingUnit')
            ->where(['polling_unit.lga_id' => $selectedLgaUniqueId])
            ->all();
    
        // Calculate the total score for each party in the LGA
        $partyTotals = [];
        foreach ($announcedResults as $result) {
            $partyAbbreviation = $result->party_abbreviation;
            $partyScore = $result->party_score;
    
            if (!isset($partyTotals[$partyAbbreviation])) {
                $partyTotals[$partyAbbreviation] = 0;
            }
    
            $partyTotals[$partyAbbreviation] += $partyScore;
        }
    
        // Calculate the total score for the LGA
        $totalLgaScore = 0;
        foreach ($pollingUnits as $pollingUnit) {
            $partyScores = [];
            foreach ($pollingUnit->announcedResults as $result) {
                $partyScore = $result->party_score;
                $partyScores[] = $partyScore;
            }
            $totalLgaScore += array_sum($partyScores);
        }
    
        return $this->render('display-results', [
            'pollingUnits' => $pollingUnits,
            'announcedResults' => $announcedResults,
            'selectedLgaName' => $selectedLgaName,
            'totalLgaScore' => $totalLgaScore,
            'partyTotals' => $partyTotals,
        ]);
    }
    
    

    public function actionStoreScore()
    {
        $pu = PollingUnit::find();
        $polling_units =  $pu->all();
        $party = Party::find();
        $party_names = $party->all();
        $ip = Yii::$app->request->userIP;
        // $ip = Yii::$app->request->getUserIP();
        $model = new AnnouncedPuResults();
        if ($model->load(Yii::$app->request->post())) {
            $model->user_ip_address = $ip;
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Polling unit result saved successfully.');
                return $this->refresh();     
            } else {
                Yii::error('Failed to save data: ' . json_encode($model->errors));
                Yii::$app->session->setFlash('error', 'Failed to save data.');
            }
        } else {
            Yii::error('An error occured.');
        }
    
        return $this->render('store-score', [
            'model' => $model,
            'polling_units' => $polling_units,
            'party_names' => $party_names,
        ]);
    }
    
}
