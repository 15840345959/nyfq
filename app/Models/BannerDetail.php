<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/21
 * Time: 15:10
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class BannerDetail extends Model
{
    use SoftDeletes;
    protected $table = 'banner_details';
    public $timestamps = true;
    protected $dates=['deleted_at'];
}