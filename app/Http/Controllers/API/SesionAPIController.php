<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController as InfyOmBaseController;
use InfyOm\Generator\Utils\ResponseUtil;
use Response;
use JWTAuth;
use App\Repositories\ContributorRepository;
use App\Repositories\NeedyRepository;

/**
 * Class SesionController
 * @package App\Http\Controllers\API
 */

class SesionAPIController extends InfyOmBaseController
{


    public function store(Request $request,ContributorRepository $cr, NeedyRepository $nr)
    {
        $credentials = $request->only(['email','password']);
        $rol = $request->input('rol');

        $credentials['email'] = strtolower($credentials['email']);

        if(!$token = JWTAuth::attempt($credentials)){
            return Response::json(ResponseUtil::makeError('failure logging'), 200);
        }

        $user = JWTAuth::toUser($token);
        
        if($rol == 1){
          $userrol = $cr->findWhere(['users_id'=>$user->id]);
        }else{
          $userrol = $nr->findWhere(['users_id'=>$user->id]);
        }

        return $this->sendResponse([
                        'user'=>$user,
                        'userrol'=>$userrol,
                        'token' => compact('token')
                        ],'Sesion saved successfully');
    }


    public function destroy()
    {
        try {
            $token = JWTAuth::getToken();
            // JWTAuth::removeToken($token);
            if ($token) {
              JWTAuth::setToken($token)->invalidate();
            }
        } catch (Exception $e) {

        }

        return $this->sendResponse('-', 'Sesion deleted successfully');
    }
}
