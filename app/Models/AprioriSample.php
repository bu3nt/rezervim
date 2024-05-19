<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AprioriSample extends Model
{
    public function items()
    {
        return $this->hasMany(AprioriSampleItem::class, 'apriori_samples_id');
    }

    public function sets()
    {
        return $this->hasMany(AprioriSampleSet::class, 'apriori_samples_id');
    }
}
