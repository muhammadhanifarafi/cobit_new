<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persetujuan extends Model
{
    use HasFactory;

    protected $table = 'mst_persetujuan';
    protected $primaryKey = 'id_mst_persetujuan';
    protected $guarded = [];
}
