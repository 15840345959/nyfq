<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/21
 * Time: 14:30
 */

namespace App\Http\Controllers\API;

use App\Components\HomeManager;
use App\Components\IndexManager;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function getBanners(){
        return IndexManager::getBannnerLists();
    }
}