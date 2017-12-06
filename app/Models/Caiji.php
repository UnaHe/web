<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * banner表
 * Class Banner
 * @package App\Models
 */
class Caiji extends Model
{
    protected $table = "xmt_caiji";
    protected $guarded = ['id'];
    public $timestamps = false;

}
