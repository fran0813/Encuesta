<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ResponderEncuesta extends Model
{
    protected $table = 'responder_encuestas';

    protected $fillable = ['titulo', 'descripcion', 'user_id'];
    
    // Uno a muchos usuario-responderEncuesta
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    // Uno a muchos responderEncuesta-respuesta
    public function respuesta()
    {
        return $this->hasMany('App\Respuesta');
    }
}
