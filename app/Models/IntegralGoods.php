<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/9
 * Time: 10:40
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IntegralGoods extends Model
{
    use SoftDeletes;
    protected $table = 'integral_goodses';
    public $timestamps = true;
    protected $dates=['deleted_at'];
}