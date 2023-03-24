<?php


namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class AuthController
 * @package App\Http\Controllers
 */
class AuthController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function info(Request $request){
        $user = Auth::user();
        unset($user->jwt);
        return response()->json([
            'status_code' => 200,
            'success' => true,
            'message' => 'success',
            'data' => $user
        ]);
    }


}