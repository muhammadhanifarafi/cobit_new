<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersetujuanAlasan extends Model
{
    use HasFactory;

    protected $table = 'mst_persetujuanalasan';
    protected $primaryKey = 'id_mst_persetujuanalasan';
    protected $guarded = [];
}
