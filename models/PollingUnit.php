<?php

namespace app\models;

use yii\db\ActiveRecord;

class PollingUnit extends ActiveRecord
{
    public function getAnnouncedResults()
    {
        return $this->hasMany(AnnouncedPuResults::class, ['polling_unit_uniqueid' => 'uniqueid']);
    }
}