<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/21
 * Time: 16:10
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class TourCategorie extends Model
{
    use SoftDeletes;
    protected $table = 'tour_categories';
    public $timestamps = true;
    protected $dates=['deleted_at'];
}