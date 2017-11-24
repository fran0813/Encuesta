<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Respuesta extends Model
{
	protected $table = 'respuestas';

    protected $fillable = ['pregunta', 'respuesta', 'realizarEncuesta_id'];
	
    // Uno a muchos responderEncuesta-respuesta
    public function responderEncuesta()
    {
        return $this->belongsTo('App\ResponderEncuesta');
    }
}
