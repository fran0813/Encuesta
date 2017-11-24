<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cerrada extends Model
{
    protected $table = 'cerradas';

    protected $fillable = ['pregunta', 'correcta', 'pregunta_id'];
    
    // Uno a uno pregunta-cerrada
    public function pregunta()
    {
        return $this->belongsTo('App\Pregunta');
    }

    // Uno a muchos cerrada-respuestaCerrada
    public function respuestaCerrada()
    {
        return $this->hasMany('App\RespuestaCerrada');
    }
}
