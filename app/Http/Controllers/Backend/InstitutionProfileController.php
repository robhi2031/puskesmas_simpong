<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Traits\Select2Common;
use App\Traits\SiteCommon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InstitutionProfileController extends Controller
{
    use SiteCommon;
    use Select2Common;
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['direct_permission:profil-read'])->only(['index', 'show', 'selectpicker_employmentstatus', 'select2_rankgrade', 'select2_position']);
        $this->middleware(['direct_permission:profil-update'])->only(['update', 'update_itemoptionselect2']);
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
            'title' => 'Kelola Profil Institusi',
            'url' => url()->current(),
            'app_version' => config('app.version'),
            'app_name' => $getSiteInfo->name,
            'user_session' => $getUserSession
        );
        //Data Source CSS
        $data['css'] = array(
            '/dist/plugins/summernote/summernote-lite.min.css',
            '/dist/plugins/dropify-master/css/dropify.min.css',
            '/dist/plugins/bootstrap-select/css/bootstrap-select.min.css',
        );
        //Data Source JS
        $data['js'] = array(
            '/dist/plugins/summernote/summernote-lite.min.js',
            '/dist/plugins/summernote/lang/summernote-id-ID.min.js',
            '/dist/plugins/dropify-master/js/dropify.min.js',
            '/dist/plugins/bootstrap-select/js/bootstrap-select.min.js',
            '/dist/js/jquery.mask.min.js',
            '/dist/js/backend_app.init.js',
            '/scripts/backend/manage_institutionprofile.init.js'
        );

        addToLog('Mengakses halaman ' .$data['title']. ' - Backend');
        return view('backend.manage_institutionprofile', compact('data'));
    }    
    /**
     * show
     *
     * @param  mixed $request
     * @return void
     */
    public function show(Request $request)
    {
        try {
            if(isset($request->tab_method)){
                if($request->tab_method=='headOfCenter_tab') {
                    $getRow = DB::table('organization_team')->where('position', 'KEPALA BALAI')->first();
                    if($getRow != null){
                        //Thumb Kepala Balai
                        $thumb = $getRow->thumb;
                        if($thumb==''){
                            $getRow->url_thumb = NULL;
                        } else {
                            if (!file_exists(public_path(). '/dist/img/organization-img/'.$thumb)){
                                $getRow->url_thumb = NULL;
                                $getRow->thumb = NULL;
                            }else{
                                $getRow->url_thumb = url('dist/img/organization-img/'.$thumb);
                            }
                        }
                        return jsonResponse(true, 'Success', 200, $getRow);
                    } else {
                        return jsonResponse(false, "Credentials not match", 401);
                    }
                }
            } else {
                $getRow = DB::table('organization_information')->where('id', 1)->first();
                if($getRow != null){
                    //Logo Instansi/ Organisasi
                    $organizationLogo = $getRow->logo;
                    if($organizationLogo==''){
                        $getRow->url_logo = NULL;
                    } else {
                        if (!file_exists(public_path(). '/dist/img/organization-img/'.$organizationLogo)){
                            $getRow->url_logo = NULL;
                            $getRow->logo = NULL;
                        }else{
                            $getRow->url_logo = url('dist/img/organization-img/'.$organizationLogo);
                        }
                    }
                    //Struktur Organisasi
                    $strukturOrganisasi = $getRow->organization_structure;
                    if($strukturOrganisasi==''){
                        $getRow->url_organizationStructure = NULL;
                    } else {
                        if (!file_exists(public_path(). '/dist/img/organization-img/'.$strukturOrganisasi)){
                            $getRow->url_organizationStructure = NULL;
                            $getRow->organization_structure = NULL;
                        }else{
                            $getRow->url_organizationStructure = url('dist/img/organization-img/'.$strukturOrganisasi);
                        }
                    }
                    return jsonResponse(true, 'Success', 200, $getRow);
                } else {
                    return jsonResponse(false, "Credentials not match", 401);
                }
            }
        } catch (Exception $exception) {
            return jsonResponse(false, $exception->getMessage(), 401, [
                "Trace" => $exception->getTrace()
            ]);
        }
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
        if(isset($request->tab_method)){
            if($request->tab_method=='headOfCenter_tab') {
                $form = [
                    'avatar' => 'mimes:png,jpg,jpeg|max:2048',
                    'nama_kepalabalai' => 'required|max:225',
                    'gender' => 'required',
                    'employment_status' => 'required',
                    'cbo_rank_grade' => 'required',
                    'awards' => 'required',
                ];
                DB::beginTransaction();
                $request->validate($form);
                try {
                    //array data
                    $data = array(
                        'name' => $request->nama_kepalabalai,
                        'gender' => $request->gender,
                        'employment_status' => $request->employment_status,
                        'rank_grade' => $request->cbo_rank_grade,
                        'awards' => $request->awards,
                        'user_updated' => $userSesIdp
                    );
                    //UPDATE FILE
                    if(!empty($_FILES['avatar']['name'])) {
                        $destinationPath = public_path('/dist/img/organization-img');
                        //Cek and Create Destination Path
                        if(!is_dir($destinationPath)){ mkdir($destinationPath, 0755, TRUE); }
                        //Get & Cek File
                        $getFile = DB::table('organization_team')->where('position', 'KEPALA BALAI')->first();
                        //Foto Kepala Balai
                        if(!empty($_FILES['avatar']['name'])){
                            if($getFile==true) {
                                $getFileThumb = $destinationPath.'/'.$getFile->thumb;
                                if(file_exists($getFileThumb) && $getFile->thumb)
                                    unlink($getFileThumb);
                            }
                            $doUploadFile = $this->_doUploadFileOrganization($request->file('avatar'), $destinationPath, 'avatar');
                            $data['thumb'] = $doUploadFile['file_name'];
                        }
                    }
        
                    DB::table('organization_team')->where('position', 'KEPALA BALAI')->update($data);
                    addToLog('Head of center institution has been successfully updated');
                    DB::commit();
                    return jsonResponse(true, 'Profil Kepala Balai berhasil diperbarui', 200);
                } catch (Exception $exception) {
                    DB::rollBack();
                    return jsonResponse(false, $exception->getMessage(), 401, [
                        "Trace" => $exception->getTrace()
                    ]);
                }
            }
        } else {
            $form = [
                'name' => 'required|max:225',
                'short_description' => 'required|max:255',
                'logo' => 'mimes:png,jpg,jpeg|max:2048',
                'profile' => 'required',
                'vision_mission' => 'required',
                'organization_structure' => 'mimes:png,jpg,jpeg|max:2048',
                'email' => 'required',
                'phone_number' => 'required|max:15',
                'office_address' => 'required|max:225',
                'office_lat_coordinate' => 'required|max:100',
                'office_long_coordinate' => 'required|max:100',
                'facebook_account' => 'required|max:225',
                'instagram_account' => 'required|max:225',
                'twitter_account' => 'required|max:225',
                'youtube_channel' => 'required|max:225',
            ];
            DB::beginTransaction();
            $request->validate($form);
            try {
                //array data
                $data = array(
                    'name' => $request->name,
                    'short_description' => $request->short_description,
                    'profile' => $request->profile,
                    'vision_mission' => $request->vision_mission,
                    'phone_number' => $request->phone_number,
                    'email' => $request->email,
                    'office_address' => $request->office_address,
                    'office_address_coordinate' => $request->office_lat_coordinate.','.$request->office_long_coordinate,
                    'facebook_account' => $request->facebook_account,
                    'instagram_account' => $request->instagram_account,
                    'twitter_account' => $request->twitter_account,
                    'youtube_channel' => $request->youtube_channel,
                    'user_updated' => $userSesIdp
                );
                //UPDATE FILE
                if(!empty($_FILES['logo']['name']) || !empty($_FILES['organization_structure']['name'])) {
                    $destinationPath = public_path('/dist/img/organization-img');
                    //Cek and Create Destination Path
                    if(!is_dir($destinationPath)){ mkdir($destinationPath, 0755, TRUE); }
                    //Get & Cek File
                    $getFile = DB::table('organization_information')->whereId(1)->first();
                    //Logo Institusi
                    if(!empty($_FILES['logo']['name'])){
                        if($getFile==true) {
                            $getFileLogo = $destinationPath.'/'.$getFile->logo;
                            if(file_exists($getFileLogo) && $getFile->logo)
                                unlink($getFileLogo);
                        }
                        $doUploadFile = $this->_doUploadFileOrganization($request->file('logo'), $destinationPath, 'logo');
                        $data['logo'] = $doUploadFile['file_name'];
                    }
                    //Organization Structure
                    if(!empty($_FILES['organization_structure']['name'])){
                        if($getFile==true) {
                            $getFileOrganizationStructure = $destinationPath.'/'.$getFile->organization_structure;
                            if(file_exists($getFileOrganizationStructure) && $getFile->organization_structure)
                                unlink($getFileOrganizationStructure);
                        }
                        $doUploadFile = $this->_doUploadFileOrganization($request->file('organization_structure'), $destinationPath, 'organization_structure');
                        $data['organization_structure'] = $doUploadFile['file_name'];
                    }
                }
    
                DB::table('organization_information')->whereId(1)->update($data);
                addToLog('The profile info Institution has been successfully updated');
                DB::commit();
                return jsonResponse(true, 'Informasi profil institusi berhasil diperbarui', 200);
            } catch (Exception $exception) {
                DB::rollBack();
                return jsonResponse(false, $exception->getMessage(), 401, [
                    "Trace" => $exception->getTrace()
                ]);
            }
        }
    }
    /**
     * update_itemoptionselect2
     *
     * @param  mixed $request
     * @return void
     */
    public function update_itemoptionselect2(Request $request) {
        $userSesIdp = Auth::user()->id;
        $form = [
            'item_method' => 'required',
            'nameOption' => 'required|max:150',
        ];
        DB::beginTransaction();
        $request->validate($form);
        try {
            $nameUpper = strtoupper($request->nameOption);
            //array data
            $data = array(
                'name' => $nameUpper,
                'user_add' => $userSesIdp
            );
            if($request->item_method=='cbo_rank_grade') {
                $cekClassRankMaster = DB::table('class_rank_master')->where('name', $nameUpper)->first();
                if($cekClassRankMaster==true) {
                    addToLog('Data cannot be saved, the same item name already exists in the system');
                    return jsonResponse(false, 'Gagal menambahkan data, nama item yang sama sudah ada pada sistem. Coba gunakan nama item yang lain', 200, array('error_code' => 'data_available'));
                } else {
                    $insert = DB::table('class_rank_master')->insertGetId($data);
                    addToLog('Class rank master has been successfully added');
                    $textMsg = 'Item option Pangkat/ Golongan berhasil ditambahkan';
                }
            } else {
                $cekPositionMaster = DB::table('position_master')->where('name', $nameUpper)->first();
                if($cekPositionMaster==true) {
                    addToLog('Data cannot be saved, the same item name already exists in the system');
                    return jsonResponse(false, 'Gagal menambahkan data, nama item yang sama sudah ada pada sistem. Coba gunakan nama item yang lain', 200, array('error_code' => 'data_available'));
                } else {
                    $insert = DB::table('position_master')->insertGetId($data);
                    addToLog('Position has been successfully added');
                    $textMsg = 'Item option Jabatan berhasil ditambahkan';
                }
            }
            DB::commit();
            return jsonResponse(true, $textMsg, 200);
        } catch (Exception $exception) {
            DB::rollBack();
            return jsonResponse(false, $exception->getMessage(), 401, [
                "Trace" => $exception->getTrace()
            ]);
        }
    }
    /**
     * _doUploadFileOrganization
     *
     * @param  mixed $fileInput
     * @param  mixed $destinationPath
     * @param  mixed $nameInput
     * @return void
     */
    private function _doUploadFileOrganization($fileInput, $destinationPath, $nameInput) {
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
    /**
     * selectpicker_employmentstatus
     *
     * @param  mixed $request
     * @return void
     */
    public function selectpicker_employmentstatus(Request $request) {
        try {
            $getRow = DB::table('employment_status_master')->where('is_public', 'Y')->get();
            if($getRow != null){
                return jsonResponse(true, 'Success', 200, $getRow);
            } else {
                return jsonResponse(false, "Credentials not match", 401);
            }
        } catch (Exception $exception) {
            return jsonResponse(false, $exception->getMessage(), 401, [
                "Trace" => $exception->getTrace()
            ]);
        }
    }
    /**
     * select2_rankgrade
     *
     * @param  mixed $request
     * @return void
     */
    public function select2_rankgrade(Request $request)
    {
        try {
            $output = $this->select2_rankgrades($request->search, $request->page, '');
            return jsonResponse(true, 'Success', 200, $output);
        } catch (Exception $exception) {
            return jsonResponse(false, $exception->getMessage(), 401, [
                "Trace" => $exception->getTrace()
            ]);
        }
    }
    /**
     * select2_position
     *
     * @param  mixed $request
     * @return void
     */
    public function select2_position(Request $request)
    {
        try {
            $output = $this->select2_positions($request->search, $request->page);
            return jsonResponse(true, 'Success', 200, $output);
        } catch (Exception $exception) {
            return jsonResponse(false, $exception->getMessage(), 401, [
                "Trace" => $exception->getTrace()
            ]);
        }
    }
}