<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
    protected $guarded = [];

    public function dailyOverviews()
    {
        return $this->hasMany(DailyOverview::class);
    }
}
