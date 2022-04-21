<?php

namespace Modules\User\Http\Controllers\Api\V1\Auth;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class LogoutController extends Controller
{
    public function logout()
    {
        auth()->user()->tokens()->delete();
        return successResponse('logged out', 200);
    }
}
