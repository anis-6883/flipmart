<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $dateFormat = 'Y-m-d H:i:s';
}
