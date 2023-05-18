<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\SiteInfo;
use App\Traits\SiteCommon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SiteInfoController extends Controller
{
    use SiteCommon;    
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['direct_permission:site-info-read'])->only('index');
        $this->middleware(['direct_permission:site-info-update'])->only('update');
    }
    /**
     * index
     *
     * @return void
     */
    public function index(Request $request)
    {
        $getSiteInfo = $this->get_siteinfo();
        $getUserSession = Auth::user();
        //Data Page Info
        $data = array(
            'title' => 'Kelola Informasi Situs Web',
            'url' => url()->current(),
            'app_version' => config('app.version'),
            'app_name' => $getSiteInfo->name,
            'user_session' => $getUserSession
        );
        //Data Source CSS
        $data['css'] = array(
            '/dist/plugins/summernote/summernote-lite.min.css',
            '/dist/plugins/dropify-master/css/dropify.min.css',
        );
        //Data Source JS
        $data['js'] = array(
            '/dist/plugins/summernote/summernote-lite.min.js',
            '/dist/plugins/summernote/lang/summernote-id-ID.min.js',
            '/dist/plugins/dropify-master/js/dropify.min.js',
            '/dist/js/backend_app.init.js',
            '/scripts/backend/manage_siteinfo.init.js'
        );

        addToLog('Mengakses halaman ' .$data['title']. ' - Backend');
        return view('backend.manage_siteinfo', compact('data'));
    }    
    /**
     * update
     *
     * @param  mixed $request
     * @return void
     */
    public function update(Request $request)
    {
        $userSesIdp = Auth::user()->id;
        $form = [
            'name' => 'required|max:255',
            'short_name' => 'required|max:60',
            'description' => 'required|max:160',
            'keyword' => 'required',
            'copyright' => 'required',
            'frontend_logo' => 'mimes:png,jpg,jpeg|max:2048',
            'login_bg' => 'mimes:png,jpg,jpeg|max:2048',
            'login_logo' => 'mimes:png,jpg,jpeg|max:2048',
            'backend_logo' => 'mimes:png,jpg,jpeg|max:2048',
            'backend_logo_icon' => 'mimes:png,jpg,jpeg|max:2048',
        ];
        DB::beginTransaction();
        $request->validate($form);
        try {
            //keyword to implode
            if(!empty($request->keyword)){
                $keyword = implode(", ", $request->keyword);
            }
            //array data
            $data = array(
                'name' => $request->name,
                'short_name' => $request->short_name,
                'description' => $request->description,
                'keyword' => $keyword,
                'copyright' => $request->copyright,
                'user_updated' => $userSesIdp
            );
            //UPDATE FILE
            if(!empty($_FILES['frontend_logo']['name']) || !empty($_FILES['login_bg']['name']) || !empty($_FILES['login_logo']['name']) || !empty($_FILES['backend_logo']['name']) || !empty($_FILES['backend_logo_icon']['name'])) {
                $destinationPath = public_path('/dist/img/site-img');
                //Cek and Create Destination Path
                if(!is_dir($destinationPath)){ mkdir($destinationPath, 0755, TRUE); }
                //Get & Cek File
                $getFile = SiteInfo::select()->whereId(1)->first();
                //Frontend Logo
                if(!empty($_FILES['frontend_logo']['name'])){
                    if($getFile==true) {
                        $getFileFrontendLogo = $destinationPath.'/'.$getFile->frontend_logo;
                        if(file_exists($getFileFrontendLogo) && $getFile->frontend_logo)
                            unlink($getFileFrontendLogo);
                    }
                    $doUploadFile = $this->_doUploadFileSiteInfo($request->file('frontend_logo'), $destinationPath, 'frontend_logo');
                    $data['frontend_logo'] = $doUploadFile['file_name'];
                }
                //Login Background
                if(!empty($_FILES['login_bg']['name'])){
                    if($getFile==true) {
                        $getFileLoginBg = $destinationPath.'/'.$getFile->login_bg;
                        if(file_exists($getFileLoginBg) && $getFile->login_bg)
                            unlink($getFileLoginBg);
                    }
                    $doUploadFile = $this->_doUploadFileSiteInfo($request->file('login_bg'), $destinationPath, 'login_bg');
                    $data['login_bg'] = $doUploadFile['file_name'];
                }
                //Login Logo
                if(!empty($_FILES['login_logo']['name'])){
                    if($getFile==true) {
                        $getFileLoginLogo = $destinationPath.'/'.$getFile->login_logo;
                        if(file_exists($getFileLoginLogo) && $getFile->login_logo)
                            unlink($getFileLoginLogo);
                    }
                    $doUploadFile = $this->_doUploadFileSiteInfo($request->file('login_logo'), $destinationPath, 'login_logo');
                    $data['login_logo'] = $doUploadFile['file_name'];
                }
                //Backend Logo
                if(!empty($_FILES['backend_logo']['name'])){
                    if($getFile==true) {
                        $getFileBackendLogo = $destinationPath.'/'.$getFile->backend_logo;
                        if(file_exists($getFileBackendLogo) && $getFile->backend_logo)
                            unlink($getFileBackendLogo);
                    }
                    $doUploadFile = $this->_doUploadFileSiteInfo($request->file('backend_logo'), $destinationPath, 'backend_logo');
                    $data['backend_logo'] = $doUploadFile['file_name'];
                }
                //Backend Icon Logo
                if(!empty($_FILES['backend_logo_icon']['name'])){
                    if($getFile==true) {
                        $getFileBackendLogoIcon = $destinationPath.'/'.$getFile->backend_logo_icon;
                        if(file_exists($getFileBackendLogoIcon) && $getFile->backend_logo_icon)
                            unlink($getFileBackendLogoIcon);
                    }
                    $doUploadFile = $this->_doUploadFileSiteInfo($request->file('backend_logo_icon'), $destinationPath, 'backend_logo_icon');
                    $data['backend_logo_icon'] = $doUploadFile['file_name'];
                }
            }

            SiteInfo::whereId(1)->update($data);
            addToLog('The site info has been successfully updated');
            DB::commit();
            return jsonResponse(true, 'Informasi situs web berhasil diperbarui', 200);
        } catch (Exception $exception) {
            DB::rollBack();
            return jsonResponse(false, $exception->getMessage(), 401, [
                "Trace" => $exception->getTrace()
            ]);
        }
    }    
    /**
     * _doUploadFileSiteInfo
     *
     * @param  mixed $fileInput
     * @param  mixed $destinationPath
     * @param  mixed $nameInput
     * @return void
     */
    private function _doUploadFileSiteInfo($fileInput, $destinationPath, $nameInput) {
        try {
            $fileExtension = $fileInput->getClientOriginalExtension();
            $fileOriginName = $fileInput->getClientOriginalName();
            $fileNewName = strtolower(Str::slug($nameInput.bcrypt(pathinfo($fileOriginName, PATHINFO_FILENAME)))) . time();
            $fileNewNameExt = $fileNewName . '.' . $fileExtension;
            $fileInput->move($destinationPath, $fileNewNameExt);

            return [
                'file_name' => $fileNewNameExt
            ];
        } catch (Exception $exception) {
            return [
                "Message" => $exception->getMessage(),
                "Trace" => $exception->getTrace()
            ];
        }
    }
}