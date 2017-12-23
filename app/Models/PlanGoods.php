<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/23
 * Time: 10:57
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlanGoods extends Model
{
    use SoftDeletes;
    protected $table = 'plan_goodses';
    public $timestamps = true;
    protected $dates=['deleted_at'];
}