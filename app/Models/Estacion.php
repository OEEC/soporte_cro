<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estacion extends Model
{
    use HasFactory;
    protected $table = 'estacion';
    protected $primaryKey = 'id_estacion';
    public $timestamps = false;
}
