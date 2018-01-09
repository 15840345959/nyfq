<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/9
 * Time: 10:42
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IntegralHistory extends Model
{
    use SoftDeletes;
    protected $table = 'integral_histories';
    public $timestamps = true;
    protected $dates=['deleted_at'];
}