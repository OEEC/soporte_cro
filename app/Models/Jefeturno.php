<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jefeturno extends Model
{
    use HasFactory;
    protected $table = 'jefeturno';
    protected $primaryKey = 'id_jt';
    public $timestamps = false;
}
