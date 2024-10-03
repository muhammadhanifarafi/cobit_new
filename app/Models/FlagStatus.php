<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlagStatus extends Model
{
    use HasFactory;

    protected $table = 'flag_status';
    protected $primaryKey = 'id';
    protected $guarded = [];
}
