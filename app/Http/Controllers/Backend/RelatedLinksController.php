<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Traits\SiteCommon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class RelatedLinksController extends Controller
{
    use SiteCommon;
    /**
     * __construct
     *
     * @return void
     */
    public function __construct() {
        $this->middleware(['direct_permission:link-terkait-read'])->only(['index', 'show']);
        $this->middleware(['direct_permission:link-terkait-create'])->only('store');
        $this->middleware(['direct_permission:link-terkait-update'])->only(['update', 'update_status']);
        $this->middleware(['direct_permission:link-terkait-delete'])->only('delete');
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
            'title' => 'Kelola Konten Link Terkait',
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
            '/scripts/backend/manage_relatedlinks.init.js'
        );

        addToLog('Mengakses halaman Kelola Konten Link Terkait - Backend');
        return view('backend.manage_relatedlinks', compact('data'));
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
                $getRow = DB::table('public_relatedlinks')
                    ->whereId($request->idp)
                    ->first();
                if($getRow != null){
                    //File Image
                    $img_file = $getRow->img_file;
                    if($img_file==''){
                        $getRow->url_imgFile = NULL;
                    } else {
                        if (!file_exists(public_path(). '/dist/img/links-img/'.$img_file)){
                            $getRow->url_imgFile = NULL;
                            $getRow->img_file = NULL;
                        }else{
                            $getRow->url_imgFile = url('dist/img/links-img/'.$img_file);
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
            $data = DB::table('public_relatedlinks')->orderByDesc('id')->get();
            $output = Datatables::of($data)->addIndexColumn()
                ->editColumn('link_url', function ($row) {
                    return '<a href="'.$row->link_url.'" target="_blank">'.$row->link_url.'</a>';
                })
                ->editColumn('img_file', function ($row) {
                    if($row->section_position == 'relatedLinkWithImage') {
                        $img_file = $row->img_file;
                        if($img_file==''){
                            $url_imgFile = asset('dist/img/default-placeholder.png');
                        } else {
                            if (!file_exists(public_path(). '/dist/img/links-img/'.$img_file)){
                                $url_imgFile = asset('dist/img/default-placeholder.png');
                                $img_file = NULL;
                            }else{
                                $url_imgFile = url('dist/img/links-img/'.$img_file);
                            }
                        }
                        $fileCustom = '<a class="d-block overlay w-100 image-popup" href="'.$url_imgFile.'" title="'.$img_file.'">
                            <img src="'.$url_imgFile.'" class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover rounded w-100" alt="'.$img_file.'" />
                            <div class="overlay-layer card-rounded bg-dark bg-opacity-25">
                                <span class="badge badge-dark"><i class="las la-search fs-3 text-light"></i></span>
                            </div>    
                        </a>';
                    } else {
                        $fileCustom = '-';
                    }
                    return $fileCustom;
                })
                ->editColumn('section_position', function ($row) {
                    $sectionPositionCustom = '<span class="badge badge-light-success me-1 mb-1">'.$row->section_position.'</span>';
                    return $sectionPositionCustom;
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
                    $btnEdit = '<button type="button" class="btn btn-icon btn-circle btn-sm btn-dark mb-1 ms-1" data-bs-toggle="tooltip" title="Edit data!" onclick="_editLink('."'".$row->id."'".');"><i class="la la-edit fs-3"></i></button>';
                    $btnDelete = '<button type="button" class="btn btn-icon btn-circle btn-sm btn-danger mb-1 ms-1" data-bs-toggle="tooltip" title="Hapus data!" onclick="_deleteLink('."'".$row->id."'".');"><i class="las la-trash-alt fs-3"></i></button>';
                    return $btnEdit.$btnDelete;
                })
                ->rawColumns(['link_url', 'img_file', 'section_position', 'is_public', 'action'])
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
            'name' => 'required|max:150',
            'link_url' => 'required',
            'section_position' => 'required',
            // 'img_file' => 'mimes:png,jpg,jpeg|max:2048',
        ];
        DB::beginTransaction();
        $request->validate($form);
        try {
            $linkTarget = NULL;
            if(isset($request->link_target)) {
                $linkTarget = '_blank';
            }
            //array data
            $data = array(
                'name' => $request->name,
                'link_url' => $request->link_url,
                'link_target' => $linkTarget,
                'section_position' => $request->section_position,
                'user_add' => $userSesIdp
            );
            //Upload File
            if(!empty($_FILES['img_file']['name'])) {
                $destinationPath = public_path('/dist/img/links-img');
                $file = $request->file('img_file');
                $extension = $file->getClientOriginalExtension();
                //Cek and Create Destination Path
                if(!is_dir($destinationPath)){ mkdir($destinationPath, 0755, TRUE); }

                $originName = $file->getClientOriginalName();
                $newName = strtolower(Str::slug($request->section_position.bcrypt(pathinfo($originName, PATHINFO_FILENAME)))) . time();
                $newNameExt = $newName . '.' . $extension;
                $file->move($destinationPath, $newNameExt);

                $data['img_file'] = $newNameExt;
            }
            $insert = DB::table('public_relatedlinks')->insertGetId($data);
            addToLog('Related link has been successfully added');
            DB::commit();
            return jsonResponse(true, 'Link terkait berhasil ditambahkan', 200);
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
            'name' => 'required|max:150',
            'link_url' => 'required',
            'section_position' => 'required',
            // 'img_file' => 'mimes:png,jpg,jpeg|max:2048',
        ];
        DB::beginTransaction();
        $request->validate($form);
        try {
            $linkTarget = NULL;
            if(isset($request->link_target)) {
                $linkTarget = '_blank';
            }
            //array data
            $data = array(
                'name' => $request->name,
                'link_url' => $request->link_url,
                'link_target' => $linkTarget,
                'section_position' => $request->section_position,
                'is_public' => isset($request->is_public) ? 'Y' : 'N',
                'user_updated' => $userSesIdp
            );
            //If Update File Link
            if(!empty($_FILES['img_file']['name'])) {
                $destinationPath = public_path('/dist/img/links-img');
                $getFile = DB::table('public_relatedlinks')->select()->whereId($request->id)->first();
                $getFileLink = $destinationPath.'/'.$getFile->img_file;

                if(file_exists($getFileLink) && $getFile->img_file)
                    unlink($getFileLink);

                $file = $request->file('img_file');
                $extension = $file->getClientOriginalExtension();
                //Cek and Create Destination Path
                if(!is_dir($destinationPath)){ mkdir($destinationPath, 0755, TRUE); }

                $originName = $file->getClientOriginalName();
                $newName = strtolower(Str::slug($request->section_position.bcrypt(pathinfo($originName, PATHINFO_FILENAME)))) . time();
                $newNameExt = $newName . '.' . $extension;
                $file->move($destinationPath, $newNameExt);

                $data['img_file'] = $newNameExt;
            }
            DB::table('public_relatedlinks')->whereId($request->id)->update($data);
            addToLog('Related link has been successfully updated');
            DB::commit();
            return jsonResponse(true, 'Link terkait berhasil diperbarui', 200);
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
            DB::table('public_relatedlinks')->whereId($idp)->update($data);
            if($value=='N') {
                addToLog('Related link status has been successfully updated to Inactive');
                $textMsg = 'Status link terkait berhasil diubah menjadi <strong>Nonaktif</strong>';
            } else {
                addToLog('Related link status has been successfully updated to Active');
                $textMsg = 'Status link terkait berhasil diubah menjadi <strong>Aktif</strong>';
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
            $destinationPath = public_path('/dist/img/links-img');
            $getFile = DB::table('public_relatedlinks')->select()->whereId($idp)->first();
            if($getFile->section_position == 'relatedLinkWithImage') {
                $getFileLink = $destinationPath.'/'.$getFile->img_file;
                if(file_exists($getFileLink) && $getFile->img_file)
                    unlink($getFileLink);
            }

            DB::table('public_relatedlinks')->whereId($idp)->delete();
            addToLog('Related link has been successfully deleted');
            $textMsg = 'Link terkait berhasil dihapus';

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