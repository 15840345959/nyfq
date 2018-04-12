<?php
/**
 * Created by PhpStorm.
 * User: mtt17
 * Date: 2018/4/12
 * Time: 9:39
 */

namespace App\Http\Controllers\api;


use App\Components\OrganizationManager;
use App\Components\RequestValidator;
use App\Http\Controllers\ApiResponse;
use Illuminate\Http\Request;

class OrganizationsController
{

    /*
     * 根据id获取旅行社信息
     *
     * By mtt
     *
     * 2018-4-12
     */
    public function getOrganizations(Request $request){
        $data = $request->all();
        //合规校验
        $requestValidationResult = RequestValidator::validator($request->all(), [
            'id' => 'required',
        ]);
        if ($requestValidationResult !== true) {
            return ApiResponse::makeResponse(false, $requestValidationResult, ApiResponse::MISSING_PARAM);
        }
        $organizations = OrganizationManager::getOrganizationById($data['id']);
        return ApiResponse::makeResponse(true,$organizations,ApiResponse::SUCCESS_CODE);
    }

}