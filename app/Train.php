<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Train extends Model
{

    protected $table = 'train';

    protected $fillable = [
        'id', 'name', 'qtd_per_day', 'qtd_movement', 'days_week', 'dt_start', 'dt_end', 'created_at', 'updated_at',
        'patient_id', 'therapist_id', 'typetrain_id'
    ];

    protected $dates = ['deleted_at'];

    public function patient()
    {
        return $this->belongsTo('App\User', 'patient_id');
    }

    public function therapist()
    {
        return $this->belongsTo('App\User', 'therapist_id');
    }
    
    public function getTypeTrain()
    {
        return $this->belongsTo('App\TypeTrain', 'typetrain_id');
    }
}
