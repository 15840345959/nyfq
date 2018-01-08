<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/8
 * Time: 18:42
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Collection extends Model
{
    use SoftDeletes;
    protected $table = 'collections';
    public $timestamps = true;
    protected $dates=['deleted_at'];
}