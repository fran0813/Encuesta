<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Encuesta extends Model
{
    protected $table = 'encuestas';

    protected $fillable = ['titulo', 'descripcion', 'user_id'];

    // Uno a muchos usuario-encuesta
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    // Uno a muchos encuesta-pregunta
    public function pregunta()
    {
        return $this->hasMany('App\Pregunta');
    }
}
