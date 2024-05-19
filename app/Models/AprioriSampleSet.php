<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AprioriSampleSet extends Model
{
    public function items()
    {
        return $this->hasMany(AprioriSampleSetItem::class, 'apriori_sample_sets_id');
    }
}
