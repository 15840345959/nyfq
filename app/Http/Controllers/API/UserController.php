<?php
/**
 * File_Name:UserController.php
 * Author: leek
 * Date: 2017/8/23
 * Time: 15:24
 */

namespace App\Http\Controllers\API;

use App\Components\HomeManager;
use App\Components\UserManager;
use App\Http\Controllers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Libs\wxDecode\ErrorCode;
use App\Libs\wxDecode\WXBizDataCrypt;
use App\Models\User;
use App\Models\ViewModels\HomeView;
use Illuminate\Http\Request;
use App\Components\RequestValidator;
use Qiniu\Auth;

class UserController extends Controller
{

    const APPID = "wx84ba56e72f32fae2";    //微信小程序APPID
    const APPSECRET = "afea8911393009247eac345d244a8a99";    //微信小程序APPSECRET
    const QN_ACCESSKEY="JXanCoTnAoyJd4WclS-zPhA8JmWooPTqvK5RCHXb";  //七牛accessKey
    const QN_SECRETKEY="ouc-dLEY42KijHeUaTzTBzFeM2Q1mKk_M_3vNpmT";  //七牛secretKey
    const QN_BUCKET="dsyy"; //七牛图片上传空间

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getQiniuToken(Request $request)
    {
//        $accessKey = 'JXanCoTnAoyJd4WclS-zPhA8JmWooPTqvK5RCHXb';
//        $secretKey = 'ouc-dLEY42KijHeUaTzTBzFeM2Q1mKk_M_3vNpmT';
        $accessKey = QN_ACCESSKEY;
        $secretKey = QN_SECRETKEY;

        $auth = new Auth($accessKey, $secretKey);

//        $bucket = 'dsyy';
        $bucket = QN_BUCKET;
        $upToken = $auth->uploadToken($bucket);

        return ApiResponse::makeResponse(true, $upToken, ApiResponse::SUCCESS_CODE);
    }

    /*
     * 新建用户信息
     *
     * By TerryQi
     *
     * 2017-12-19
     *
     *
     */
    public function createUser(Request $request)
    {
        $data = $request->all();
//        dd($data);
        $user = new User();
        if(array_key_exists('id',$data)){
            $user = UserManager::getUserInfoById($data['id']);
        }
        $user=UserManager::setUser($user,$data);
        $user->save();
        return ApiResponse::makeResponse(true, $user, ApiResponse::SUCCESS_CODE);

    }

    /*
     * 通过code换取open_id和session_key
     *
     * By TerryQi
     *
     * 2017-10-08
     */
    public function getXCXOpenId(Request $request)
    {
        $data = $request->all();
        //合规校验account_type
        $requestValidationResult = RequestValidator::validator($request->all(), [
            'code' => 'required',
        ]);
        if ($requestValidationResult !== true) {
            return ApiResponse::makeResponse(false, $requestValidationResult, ApiResponse::MISSING_PARAM);
        }
        $code = $data['code'];  //获取小程序code
        //触发后端
        $ret_str = file_get_contents("https://api.weixin.qq.com/sns/jscode2session?appid=" . self::APPID . "&secret=" . self::APPSECRET . "&js_code=" . $code . "&grant_type=authorization_code");//通过code换取网页授权access_token

        $ret_val = json_decode($ret_str, true);

        return ApiResponse::makeResponse(true, $ret_val, ApiResponse::SUCCESS_CODE);
    }


    /*
     * 用户登录
     *
     * @request 用户相关信息
     *
     * By TerryQi
     *
     */
    public function login(Request $request)
    {
        $data = $request->all();    //request转array
        $user = null;          //返回user信息
        //合规校验account_type
        $requestValidationResult = RequestValidator::validator($request->all(), [
            'account_type' => 'required',
        ]);
        if ($requestValidationResult !== true) {
            return ApiResponse::makeResponse(false, $requestValidationResult, ApiResponse::MISSING_PARAM);
        }
        //如果是小程序
        if ($data['account_type'] == 'xcx') {
            //合规校验account_type
            $requestValidationResult = RequestValidator::validator($request->all(), [
                'open_id' => 'required',
            ]);
            if ($requestValidationResult !== true) {
                return ApiResponse::makeResponse(false, $requestValidationResult, ApiResponse::MISSING_PARAM);
            }
            //进行注册
            $user = UserManager::login($data);
        }
        //如果注册失败，返回失败
        if ($user == null) {
            return ApiResponse::makeResponse(false, ApiResponse::$errorMassage[ApiResponse::REGISTER_FAILED], ApiResponse::REGISTER_FAILED);
        } else {
            return ApiResponse::makeResponse(true, $user, ApiResponse::SUCCESS_CODE);
        }
    }

    /*
     * 根据id更新用户信息
     *
     * @request id:用户id
     *
     * By TerryQi
     *
     */
    public function updateUserById(Request $request)
    {
        $requestValidationResult = RequestValidator::validator($request->all(), [
            'user_id' => 'required',
        ]);
        if ($requestValidationResult !== true) {
            return ApiResponse::makeResponse(false, $requestValidationResult, ApiResponse::MISSING_PARAM);
        }
        $data = $request->all();
        $user = UserManager::updateUser($data);
        return ApiResponse::makeResponse(true, $user, ApiResponse::SUCCESS_CODE);
    }


    /*
     * 根据id获取用户信息
     *
     * @request id：用户id
     *
     * By TerryQi
     *
     * 2017-09-28
     *
     */
    public function getUserById(Request $request)
    {
        $requestValidationResult = RequestValidator::validator($request->all(), [
            'id' => 'required',
        ]);
        if ($requestValidationResult !== true) {
            return ApiResponse::makeResponse(false, $requestValidationResult, ApiResponse::MISSING_PARAM);
        }
        $data = $request->all();

        $user = UserManager::getUserInfoById($data['id']);
        if ($user) {
            return ApiResponse::makeResponse(true, $user, ApiResponse::SUCCESS_CODE);
        } else {
            return ApiResponse::makeResponse(false, ApiResponse::$errorMassage[ApiResponse::NO_USER], ApiResponse::NO_USER);
        }
    }

    /*
     * 根据id获取用户信息带token
     *
     * @request id：用户id
     *
     * By TerryQi
     *
     * 2017-09-28
     *
     */
    public function getUserInfoByIdWithToken(Request $request)
    {
        $requestValidationResult = RequestValidator::validator($request->all(), [
            'id' => 'required',
        ]);

        $data = $request->all();

        if ($requestValidationResult !== true) {
            return ApiResponse::makeResponse(false, $requestValidationResult, ApiResponse::MISSING_PARAM);
        }

        $user = UserManager::getUserInfoByIdWithToken($data['id']);
        if ($user) {
            return ApiResponse::makeResponse(true, $user, ApiResponse::SUCCESS_CODE);
        } else {
            return ApiResponse::makeResponse(false, ApiResponse::$errorMassage[ApiResponse::NO_USER], ApiResponse::NO_USER);
        }
    }

}