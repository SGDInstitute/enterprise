<?php

namespace App\Http\Controllers;

use Lab404\Impersonate\Services\ImpersonateManager;

class ImpersonationController extends Controller
{
    /** @var ImpersonateManager */
    protected $manager;

    /**
     * ImpersonateController constructor.
     */
    public function __construct()
    {
        $this->manager = app()->make(ImpersonateManager::class);

        $guard = $this->manager->getDefaultSessionGuard();
        // $this->middleware('auth:' . $guard)->only('take');
    }

    public function __invoke()
    {
        if (! $this->manager->isImpersonating()) {
            abort(403);
        }

        $this->manager->leave();

        if (session('after_impersonation') !== null) {
            return redirect(session('after_impersonation'));
        }

        return redirect()->back();
    }
}
