<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailySystem extends Model
{
    protected $guarded = [];

    public function website()
    {
        return $this->belongsTo(Website::class);
    }
}
