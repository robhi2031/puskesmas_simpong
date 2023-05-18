<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Traits\SiteCommon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class BannerSlidesController extends Controller
{
    use SiteCommon;
    /**
     * __construct
     *
     * @return void
     */
    public function __construct() {
        $this->middleware(['direct_permission:slide-banner-read'])->only(['index', 'show']);
        $this->middleware(['direct_permission:slide-banner-create'])->only('store');
        $this->middleware(['direct_permission:slide-banner-update'])->only(['update', 'update_status']);
        $this->middleware(['direct_permission:slide-banner-delete'])->only('delete');
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
        //Data WebInfo
        $data = array(
            'title' => 'Kelola Konten Banner Slide',
            'url' => url()->current(),
            'app_version' => config('app.version'),
            'app_name' => $getSiteInfo->name,
            'user_session' => $getUserSession
        );
        //Data Source CSS
        $data['css'] = array(
            '/dist/plugins/custom/datatables/datatables.bundle.v817.css',
            '/dist/plugins/bootstrap-select/css/bootstrap-select.min.css',
            '/dist/plugins/Magnific-Popup/magnific-popup.css',
            '/dist/plugins/dropify-master/css/dropify.min.css',
        );
        //Data Source JS
        $data['js'] = array(
            '/dist/plugins/custom/datatables/datatables.bundle.v817.js',
            '/dist/plugins/bootstrap-select/js/bootstrap-select.min.js',
            '/dist/plugins/Magnific-Popup/jquery.magnific-popup.min.js',
            '/dist/plugins/dropify-master/js/dropify.min.js',
            '/dist/js/backend_app.init.js',
            '/scripts/backend/manage_bannerslides.init.js'
        );

        addToLog('Mengakses halaman Kelola Konten Banner Slide - Backend');
        return view('backend.manage_bannerslides', compact('data'));
    }
    /**
     * show
     *
     * @param  mixed $request
     * @return void
     */
    public function show(Request $request)
    {
        if(isset($request->idp)){
            try {
                $getRow = DB::table('public_bannerslide')
                    ->whereId($request->idp)
                    ->first();
                if($getRow != null){
                    //File Slide
                    $file_name = $getRow->file_name;
                    if($file_name==''){
                        $getRow->url_file = NULL;
                    } else {
                        if (!file_exists(public_path(). '/dist/img/slides-img/'.$file_name)){
                            $getRow->url_file = NULL;
                            $getRow->file_name = NULL;
                        }else{
                            $getRow->url_file = url('dist/img/slides-img/'.$file_name);
                        }
                    }
                    return jsonResponse(true, 'Success', 200, $getRow);
                } else {
                    return jsonResponse(false, "Credentials not match", 401);
                }
            } catch (Exception $exception) {
                return jsonResponse(false, $exception->getMessage(), 401, [
                    "Trace" => $exception->getTrace()
                ]);
            }
        } else {
            $data = DB::table('public_bannerslide')->orderByDesc('id')->get();
            $output = Datatables::of($data)->addIndexColumn()
                ->editColumn('file_name', function ($row) {
                    $file_name = $row->file_name;
                    if($file_name==''){
                        $url_file = asset('dist/img/default-placeholder.png');
                    } else {
                        if (!file_exists(public_path(). '/dist/img/slides-img/'.$file_name)){
                            $url_file = asset('dist/img/default-placeholder.png');
                            $file_name = NULL;
                        }else{
                            $url_file = url('dist/img/slides-img/'.$file_name);
                        }
                    }
                    $fileCustom = '<a class="d-block overlay w-100 image-popup" href="'.$url_file.'" title="'.$file_name.'">
                        <img src="'.$url_file.'" class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover rounded w-100" alt="'.$file_name.'" />
                        <div class="overlay-layer card-rounded bg-dark bg-opacity-25">
                            <span class="badge badge-dark"><i class="las la-search fs-3 text-light"></i></span>
                        </div>    
                    </a>';
                    return $fileCustom;
                })
                ->editColumn('section_position', function ($row) {
                    $sectionPositionCustom = '<span class="badge badge-light-success me-1 mb-1">'.$row->section_position.'</span>';
                    return $sectionPositionCustom;
                })
                ->editColumn('is_link', function ($row) {
                    if($row->is_link == 'Y'){
                        $linkCustom = '<span class="badge badge-info me-1 mb-1" data-bs-toggle="tooltip" title="Slide memiliki link"><i class="fas fa-toggle-on fs-2"></i></span>
                            <br/> <span class="text-muted"><a href="'.$row->link_url.'" target="_blank">'.$row->link_url.'</a></span>';
                    } else {
                        $linkCustom = '<span class="badge badge-light me-1 mb-1" data-bs-toggle="tooltip" title="Slide tidak memiliki link"><i class="fas fa-toggle-off fs-2"></i></span>';
                    }
                    return $linkCustom;
                })
                ->editColumn('is_public', function ($row) {
                    if($row->is_public == 'Y'){
                        $activeCustom = '<button type="button" class="btn btn-sm btn-info mb-1" data-bs-toggle="tooltip" title="Status Aktif, Nonaktifkan ?" onclick="_updateStatus('."'".$row->id."'".', '."'N'".');"><i class="fas fa-toggle-on fs-2"></i></button>';
                    } else {
                        $activeCustom = '<button type="button" class="btn btn-sm btn-light mb-1" data-bs-toggle="tooltip" title="Status Tidak Aktif, Aktifkan ?" onclick="_updateStatus('."'".$row->id."'".', '."'Y'".');"><i class="fas fa-toggle-off fs-2"></i></button>';
                    }
                    return $activeCustom;
                })
                ->addColumn('action', function($row){
                    $btnEdit = '<button type="button" class="btn btn-icon btn-circle btn-sm btn-dark mb-1 ms-1" data-bs-toggle="tooltip" title="Edit data!" onclick="_editSlide('."'".$row->id."'".');"><i class="la la-edit fs-3"></i></button>';
                    $btnDelete = '<button type="button" class="btn btn-icon btn-circle btn-sm btn-danger mb-1 ms-1" data-bs-toggle="tooltip" title="Hapus data!" onclick="_deleteSlide('."'".$row->id."'".');"><i class="las la-trash-alt fs-3"></i></button>';
                    return $btnEdit.$btnDelete;
                })
                ->rawColumns(['file_name', 'section_position', 'is_link', 'is_public', 'action'])
                ->make(true);

            return $output;
        }
    }
    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request) {
        $userSesIdp = Auth::user()->id;
        $form = [
            'file_slide' => 'mimes:png,jpg,jpeg|max:2048',
            'section_position' => 'required',
        ];
        DB::beginTransaction();
        $request->validate($form);
        try {
            $linkTarget = NULL;
            if(isset($request->is_link)) {
                if(isset($request->link_target)) {
                    $linkTarget = '_blank';
                }
            }
            //array data
            $data = array(
                'section_position' => $request->section_position,
                'is_link' => isset($request->is_link) ? 'Y' : 'N',
                'link_url' => isset($request->is_link) ? $request->link_url : NULL,
                'link_target' => $linkTarget,
                'user_add' => $userSesIdp
            );
            //Upload File
            if(!empty($_FILES['file_slide']['name'])) {
                $destinationPath = public_path('/dist/img/slides-img');
                $file = $request->file('file_slide');
                $extension = $file->getClientOriginalExtension();
                //Cek and Create Destination Path
                if(!is_dir($destinationPath)){ mkdir($destinationPath, 0755, TRUE); }

                $originName = $file->getClientOriginalName();
                $newName = strtolower(Str::slug($request->section_position.bcrypt(pathinfo($originName, PATHINFO_FILENAME)))) . time();
                $newNameExt = $newName . '.' . $extension;
                $file->move($destinationPath, $newNameExt);

                $data['file_name'] = $newNameExt;
            }
            $insert = DB::table('public_bannerslide')->insertGetId($data);
            addToLog('Banner Slide has been successfully added');
            DB::commit();
            return jsonResponse(true, 'Banner slide berhasil ditambahkan', 200);
        } catch (Exception $exception) {
            DB::rollBack();
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
    public function update(Request $request) {
        $userSesIdp = Auth::user()->id;
        $form = [
            'file_slide' => 'mimes:png,jpg,jpeg|max:2048',
            'section_position' => 'required',
        ];
        DB::beginTransaction();
        $request->validate($form);
        try {
            $linkTarget = NULL;
            if(isset($request->is_link)) {
                if(isset($request->link_target)) {
                    $linkTarget = '_blank';
                }
            }
            //array data
            $data = array(
                'section_position' => $request->section_position,
                'is_link' => isset($request->is_link) ? 'Y' : 'N',
                'link_url' => isset($request->is_link) || $request->link_url !='' ? $request->link_url : NULL,
                'link_target' => $linkTarget,
                'is_public' => isset($request->is_public) ? 'Y' : 'N',
                'user_updated' => $userSesIdp
            );
            //If Update File Slide
            if(!empty($_FILES['file_slide']['name'])) {
                $destinationPath = public_path('/dist/img/slides-img');
                $getFile = DB::table('public_bannerslide')->select()->whereId($request->id)->first();
                $getFileSlide = $destinationPath.'/'.$getFile->file_name;

                if(file_exists($getFileSlide) && $getFile->file_name)
                    unlink($getFileSlide);

                $file = $request->file('file_slide');
                $extension = $file->getClientOriginalExtension();
                //Cek and Create Destination Path
                if(!is_dir($destinationPath)){ mkdir($destinationPath, 0755, TRUE); }

                $originName = $file->getClientOriginalName();
                $newName = strtolower(Str::slug($request->section_position.bcrypt(pathinfo($originName, PATHINFO_FILENAME)))) . time();
                $newNameExt = $newName . '.' . $extension;
                $file->move($destinationPath, $newNameExt);

                $data['file_name'] = $newNameExt;
            }
            DB::table('public_bannerslide')->whereId($request->id)->update($data);
            addToLog('Banner Slide has been successfully updated');
            DB::commit();
            return jsonResponse(true, 'Banner Slide berhasil diperbarui', 200);
        } catch (Exception $exception) {
            DB::rollBack();
            return jsonResponse(false, $exception->getMessage(), 401, [
                "Trace" => $exception->getTrace()
            ]);
        }
    }
    /**
     * update_status
     *
     * @param  mixed $request
     * @return void
     */
    public function update_status(Request $request) {
        $userSesIdp = Auth::user()->id;
        $idp = $request->idp;
        $value = $request->value;
        DB::beginTransaction();
        try {
            $data = array(
                'is_public' => $value,
                'user_updated' => $userSesIdp
            );
            DB::table('public_bannerslide')->whereId($idp)->update($data);
            if($value=='N') {
                addToLog('Banner slide status has been successfully updated to Inactive');
                $textMsg = 'Status slide berhasil diubah menjadi <strong>Nonaktif</strong>';
            } else {
                addToLog('Banner slide status has been successfully updated to Active');
                $textMsg = 'Status slide berhasil diubah menjadi <strong>Aktif</strong>';
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
     * delete
     *
     * @param  mixed $request
     * @return void
     */
    public function delete(Request $request) {
        $userSesIdp = Auth::user()->id;
        $idp = $request->idp;
        DB::beginTransaction();
        try {
            $destinationPath = public_path('/dist/img/slides-img');
            $getFile = DB::table('public_bannerslide')->select()->whereId($idp)->first();
            $getFileSlide = $destinationPath.'/'.$getFile->file_name;

            if(file_exists($getFileSlide) && $getFile->file_name)
                unlink($getFileSlide);

            DB::table('public_bannerslide')->whereId($idp)->delete();
            addToLog('Banner slide has been successfully deleted');
            $textMsg = 'Banner slide berhasil dihapus';

            DB::commit();
            return jsonResponse(true, $textMsg, 200);
        } catch (Exception $exception) {
            DB::rollBack();
            return jsonResponse(false, $exception->getMessage(), 401, [
                "Trace" => $exception->getTrace()
            ]);
        }
    }
}