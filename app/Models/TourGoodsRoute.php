<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/22
 * Time: 17:44
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TourGoodsRoute extends Model
{
    use SoftDeletes;
    protected $table = 'tour_goods_routes';
    public $timestamps = true;
    protected $dates=['deleted_at'];
}