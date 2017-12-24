<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/24
 * Time: 11:58
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommentConsent extends Model
{
    use SoftDeletes;
    protected $table = 'comment_consents';
    public $timestamps = true;
    protected $dates=['deleted_at'];
}