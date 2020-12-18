<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RSSHistory extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $connection = 'sqlite';
    protected $table = 'RSSHistory';
    public $timestamps = false;
}
