<?php

namespace app\models;

use yii\db\ActiveRecord;

class AnnouncedPuResults extends ActiveRecord
{
  
    
     public function getPollingUnit()
     {
         return $this->hasOne(PollingUnit::class, ['uniqueid' => 'polling_unit_uniqueid']);
     }

     public function rules()
     {
         return [
             [['polling_unit_uniqueid', 'party_abbreviation', 'party_score', 'entered_by_user', 'date_entered'], 'required'],
             [['polling_unit_uniqueid'], 'exist', 'targetClass' => PollingUnit::class, 'targetAttribute' => ['polling_unit_uniqueid' => 'uniqueid']],
             [['party_score'], 'integer', 'min' => 0], 
             [['date_entered'], 'date', 'format' => 'yyyy-MM-dd'],
         ];
     }
}