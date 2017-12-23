<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/23
 * Time: 11:14
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TicketGoods
{
    use SoftDeletes;
    protected $table = 'ticket_goodses';
    public $timestamps = true;
    protected $dates=['deleted_at'];
}