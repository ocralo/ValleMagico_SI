<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GuRecordIntelligenceIndDescStyle extends Model
{
    protected $fillable = [
        'game_user_record_id', 'intelligence_indicator_id', 'description_style_id', 
        'vocational_orientation_id', 'competence_id', 'percentage_value', 'created_at', 
        'updated_at'
    ];
}
