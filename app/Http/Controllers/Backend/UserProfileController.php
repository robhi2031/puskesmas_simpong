<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Traits\SiteCommon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{
    use SiteCommon;
    /**
     * index
     *
     * @return void
     */
    public function index(Request $request, $username)
    {
        $getSiteInfo = $this->get_siteinfo();
        $getUserSession = Auth::user();
        //Data WebInfo
        $data = array(
            'title' => $getUserSession->name.' on User Profile',
            'url' => url()->current(),
            'app_version' => config('app.version'),
            'app_name' => $getSiteInfo->name,
            'user_session' => $getUserSession
        );
        //Data Source CSS
        $data['css'] = array(
            '/dist/plugins/Magnific-Popup/magnific-popup.css',
        );
        //Data Source JS
        $data['js'] = array(
            '/dist/js/jquery.mask.min.js',
            '/dist/plugins/Magnific-Popup/jquery.magnific-popup.min.js',
            '/dist/js/backend_app.init.js',
            '/scripts/backend/user_profile.init.js'
        );

        addToLog('Mengakses halaman ' .$getUserSession->name. ' on User Profile - Backend');
        return view('backend.user_profile', compact('data'));
    }
}