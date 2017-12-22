<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/22
 * Time: 18:46
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TourGoodsDetail extends Model
{
    use SoftDeletes;
    protected $table = 'tour_goods_details';
    public $timestamps = true;
    protected $dates=['deleted_at'];
}