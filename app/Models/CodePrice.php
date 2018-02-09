<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 邀请码价格返利表
 * Class CodePrice
 * @package App\Models
 */
class CodePrice extends Model
{
    protected $table = "xmt_pygj_code_price";
    protected $guarded = ['id'];
    public $timestamps = false;
}
