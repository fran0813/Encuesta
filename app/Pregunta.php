<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pregunta extends Model
{
    protected $table = 'preguntas';

    protected $fillable = ['encuesta_id'];

    // Uno a muchos encuesta-pregunta
    public function encuesta()
    {
        return $this->belongsTo('App\Encuesta');
    }

    // Uno a uno pregunta-abierta
    public function abierta()
    {
        return $this->hasOne('App\Abierta');
    }

    // Uno a uno pregunta-cerrada
    public function cerrada()
    {
        return $this->hasOne('App\Cerrada');
    }
}
