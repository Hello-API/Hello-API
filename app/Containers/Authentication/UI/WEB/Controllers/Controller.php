<?php

namespace App\Containers\Authentication\UI\WEB\Controllers;

use App\Containers\Authentication\Actions\WebAdminLoginAction;
use App\Containers\Authentication\Actions\WebLogoutAction;
use App\Containers\Authentication\Exceptions\AuthenticationFailedException;
use App\Containers\Authentication\UI\WEB\Requests\LoginRequest;
use App\Containers\Authentication\UI\WEB\Requests\ViewDashboardRequest;
use App\Port\Controller\Abstracts\PortWebController;

/**
 * Class Controller
 *
 * @author  Mahmoud Zalt  <mahmoud@zalt.me>
 */
class Controller extends PortWebController
{

    /**
     * @return  \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLoginPage()
    {
        return view('authentication::login');
    }

    /**
     * @param \App\Containers\Authentication\UI\WEB\Requests\LoginRequest $request
     * @param \App\Containers\Authentication\Actions\WebAdminLoginAction  $action
     *
     * @return  $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function loginAdmin(LoginRequest $request, WebAdminLoginAction $action)
    {
        try {
            $result = $action->run($request->email, $request->password, $request->remember_me);
        } catch (AuthenticationFailedException $e) {
            return redirect('login')->with('error', $e->getMessage());
        }

        if (is_array($result)) {
            return view('authentication::login')->with($result);
        }

        return redirect('dashboard');
    }

    /**
     * @param \App\Containers\Authentication\UI\WEB\Requests\ViewDashboardRequest $request
     *
     * @return  \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function viewDashboardPage(ViewDashboardRequest $request)
    {
        return view('authentication::dashboard');
    }

    /**
     * @param \App\Containers\Authentication\Actions\WebLogoutAction $action
     *
     * @return  \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function logoutAdmin(WebLogoutAction $action)
    {
        $action->run();

        return view('authentication::login');
    }


}
