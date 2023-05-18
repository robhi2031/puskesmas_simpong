<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\SiteCommon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Artisan;
use Hash;
use Session;
use Carbon\Carbon;

class DashboardController extends Controller
{
    use SiteCommon;
    /**
     * index
     *
     * @return void
     */
    public function index(Request $request)
    {
        $getSiteInfo = $this->get_siteinfo();
        $getUserSession = Auth::user();
        //Data WebInfo
        $data = array(
            'title' => 'Dashboard',
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
            '/dist/plugins/Magnific-Popup/jquery.magnific-popup.min.js',
            '/dist/js/backend_app.init.js',
            '/scripts/backend/main.init.js'
        );

        addToLog('Mengakses halaman Dashboard - Backend');
        return view('backend.index', compact('data'));
    }
}