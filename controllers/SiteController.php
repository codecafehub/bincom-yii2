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
        // $query->orderBy(['date_entered' => SORT_DESC]);
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

    public function actionDisplayResultse()
    {
        $request = Yii::$app->request;
        $selectedLgaUniqueId = $request->post('lga_uniqueid');
        $pollingUnits = PollingUnit::find()->where(['lga_id' => $selectedLgaUniqueId])->all();
        $selectedLga = Lga::findOne(['uniqueid' => $selectedLgaUniqueId]);
        $selectedLgaName = ($selectedLga !== null) ? $selectedLga->lga_name : '';
        $announcedResults = AnnouncedPuResults::find()
            ->joinWith('pollingUnit')  
            ->where(['polling_unit.lga_id' => $selectedLgaUniqueId])
            ->all();

        return $this->render('display-results', [
            'pollingUnits' => $pollingUnits,
            'selectedLgaName' => $selectedLgaName,
            'announcedResults' => $announcedResults,
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

        return $this->render('display-results', [
            'pollingUnits' => $pollingUnits,
            'announcedResults' => $announcedResults,
            'selectedLgaName' => $selectedLgaName,
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
