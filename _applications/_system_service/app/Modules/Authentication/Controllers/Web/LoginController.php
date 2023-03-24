<?php


namespace App\Modules\Authentication\Controllers\Web;


use App\Modules\Authentication\Services\ITenancyService;
use Common\Http\Controllers\Web\AbstractWebController;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

/**
 * Class LoginController
 * @package App\Modules\Authentication\Controllers\Web
 */
class LoginController extends AbstractWebController
{
    /**
     * @param Request $request
     * @return Application|Factory|View
     */
    public function index(Request $request){
        return view('Authentication::login');
    }

    /**
     * @param Request $request
     * @param ITenancyService $tenancyService
     * @return Application|Factory|View|RedirectResponse
     */
    public function login(Request $request, ITenancyService $tenancyService){
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator)->withInput();
        }
        $request->session()->regenerate();
        $param = $request->post();
        $remember = empty($param['remember']) ?  false : true;
        $status = Auth::attempt([
            'username' => $param['username'],
            'password' => $param['password'],
            'remember' => $remember
        ], $remember);
        if (!$status) {
            return back()->withInput()->withErrors(['auth_failed' => __('auth.failed')]);
        }
        return redirect($tenancyService->getCallbackUrlByUsername(Auth::user()->username));
    }

    /**
     * @param Request $request
     * @param ITenancyService $tenancyService
     * @return Application|RedirectResponse|Redirector
     */
    public function redirectAfterLogin(Request $request, ITenancyService $tenancyService){
        return redirect($tenancyService->getCallbackUrlByUsername(Auth::user()->username));
    }
}
