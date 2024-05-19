<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AprioriSampleSetItem extends Model
{
    public function item()
    {
        return $this->belongsTo(AprioriSampleItem::class, 'apriori_sample_items_id');
    }
}
