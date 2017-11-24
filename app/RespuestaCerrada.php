<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RespuestaCerrada extends Model
{
	protected $table = 'respuesta_cerradas';

    protected $fillable = ['respuesta', 'cerrada_id'];

    // Uno a muchos cerrada-respuestaCerrada
    public function cerrada()
    {
        return $this->belongsTo('App\Cerrada');
    }
}
