<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class abierta extends Model
{
	protected $table = 'abiertas';

    protected $fillable = ['pregunta', 'pregunta_id'];

    // Uno a uno pregunta-abierta
    public function pregunta()
    {
        return $this->belongsTo('App\Pregunta');
    }
}
