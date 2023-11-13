<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supxest extends Model
{
    use HasFactory;
    protected $table = 'supxest';
    protected $primaryKey = 'id_sxe';
    public $timestamps = false;
}
