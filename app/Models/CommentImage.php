<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/23
 * Time: 9:03
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class CommentImage extends Model
{
    use SoftDeletes;
    protected $table = 'comment_images';
    public $timestamps = true;
    protected $dates=['deleted_at'];
}