<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/21
 * Time: 15:37
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class TourGoods extends Model
{
    use SoftDeletes;
    protected $table = 'tour_goodses';
    public $timestamps = true;
    protected $dates=['deleted_at'];
}