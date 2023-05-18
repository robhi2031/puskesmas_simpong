<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Services;
use App\Traits\SiteCommon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class InstitutionServicesController extends Controller
{
    use SiteCommon;
    /**
     * __construct
     *
     * @return void
     */
    public function __construct() {
        $this->middleware(['direct_permission:layanan-read'])->only(['index', 'show']);
        $this->middleware(['direct_permission:layanan-create'])->only('store');
        $this->middleware(['direct_permission:layanan-update'])->only(['update', 'update_status']);
        $this->middleware(['direct_permission:layanan-delete'])->only('delete');
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
            'title' => 'Kelola Data Layanan',
            'url' => url()->current(),
            'app_version' => config('app.version'),
            'app_name' => $getSiteInfo->name,
            'user_session' => $getUserSession
        );
        //Data Source CSS
        $data['css'] = array(
            '/dist/plugins/custom/datatables/datatables.bundle.v817.css',
            '/dist/plugins/summernote/summernote-lite.min.css',
            '/dist/plugins/bootstrap-select/css/bootstrap-select.min.css',
            '/dist/plugins/Magnific-Popup/magnific-popup.css',
            '/dist/plugins/dropify-master/css/dropify.min.css',
        );
        //Data Source JS
        $data['js'] = array(
            '/dist/plugins/custom/datatables/datatables.bundle.v817.js',
            '/dist/plugins/summernote/summernote-lite.min.js',
            '/dist/plugins/summernote/lang/summernote-id-ID.min.js',
            '/dist/plugins/bootstrap-select/js/bootstrap-select.min.js',
            '/dist/plugins/Magnific-Popup/jquery.magnific-popup.min.js',
            '/dist/plugins/dropify-master/js/dropify.min.js',
            '/dist/js/backend_app.init.js',
            '/scripts/backend/manage_institutionservices.init.js'
        );

        addToLog('Mengakses halaman ' .$data['title']. ' - Backend');
        return view('backend.manage_institutionservices', compact('data'));
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
                $getRow = Services::whereId($request->idp)
                    ->first();
                if($getRow != null){
                    //File Image
                    $thumb = $getRow->thumb;
                    if($thumb==''){
                        $getRow->url_thumb = NULL;
                    } else {
                        if (!file_exists(public_path(). '/dist/img/services-img/'.$thumb)){
                            $getRow->url_thumb = NULL;
                            $getRow->thumb = NULL;
                        }else{
                            $getRow->url_thumb = url('dist/img/services-img/'.$thumb);
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
            $data = Services::orderByDesc('id')->get();
            $output = Datatables::of($data)->addIndexColumn()
                ->editColumn('thumb', function ($row) {
                    $thumb = $row->thumb;
                    if($thumb==''){
                        $url_thumb = asset('dist/img/default-placeholder.png');
                    } else {
                        if (!file_exists(public_path(). '/dist/img/services-img/'.$thumb)){
                            $url_thumb = asset('dist/img/default-placeholder.png');
                            $thumb = NULL;
                        }else{
                            $url_thumb = url('dist/img/services-img/'.$thumb);
                        }
                    }
                    $fileCustom = '<a class="d-block overlay w-100 image-popup" href="'.$url_thumb.'" title="'.$thumb.'">
                        <img src="'.$url_thumb.'" class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover rounded w-100" alt="'.$thumb.'" />
                        <div class="overlay-layer card-rounded bg-dark bg-opacity-25">
                            <span class="badge badge-dark"><i class="las la-search fs-3 text-light"></i></span>
                        </div>    
                    </a>';
                    return $fileCustom;
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
                    $btnEdit = '<button type="button" class="btn btn-icon btn-circle btn-sm btn-dark mb-1 ms-1" data-bs-toggle="tooltip" title="Edit data!" onclick="_editService('."'".$row->id."'".');"><i class="la la-edit fs-3"></i></button>';
                    $btnDelete = '<button type="button" class="btn btn-icon btn-circle btn-sm btn-danger mb-1 ms-1" data-bs-toggle="tooltip" title="Hapus data!" onclick="_deleteService('."'".$row->id."'".');"><i class="las la-trash-alt fs-3"></i></button>';
                    return $btnEdit.$btnDelete;
                })
                ->rawColumns(['thumb', 'is_public', 'action'])
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
            'description' => 'required',
            'thumb' => 'mimes:png,jpg,jpeg|max:2048',
        ];
        DB::beginTransaction();
        $request->validate($form);
        try {
            //array data
            $data = array(
                'name' => $request->name,
                'description' => $request->description,
                'user_add' => $userSesIdp
            );
            //Upload File
            if(!empty($_FILES['thumb']['name'])) {
                $destinationPath = public_path('/dist/img/services-img');
                $file = $request->file('thumb');
                $extension = $file->getClientOriginalExtension();
                //Cek and Create Destination Path
                if(!is_dir($destinationPath)){ mkdir($destinationPath, 0755, TRUE); }

                $originName = $file->getClientOriginalName();
                $newName = strtolower(Str::slug($request->name.bcrypt(pathinfo($originName, PATHINFO_FILENAME)))) . time();
                $newNameExt = $newName . '.' . $extension;
                $file->move($destinationPath, $newNameExt);

                $data['thumb'] = $newNameExt;
            }
            $insert = Services::insertGetId($data);
            addToLog('Service has been successfully added');
            DB::commit();
            return jsonResponse(true, 'Data layanan berhasil ditambahkan', 200);
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
            'description' => 'required',
            'thumb' => 'mimes:png,jpg,jpeg|max:2048',
        ];
        DB::beginTransaction();
        $request->validate($form);
        try {
            //array data
            $data = array(
                'name' => $request->name,
                'description' => $request->description,
                'is_public' => isset($request->is_public) ? 'Y' : 'N',
                'user_updated' => $userSesIdp
            );
            //If Update File Link
            if(!empty($_FILES['thumb']['name'])) {
                $destinationPath = public_path('/dist/img/services-img');
                $getFile = Services::whereId($request->id)->first();
                $getFileThumb = $destinationPath.'/'.$getFile->thumb;

                if(file_exists($getFileThumb) && $getFile->thumb)
                    unlink($getFileThumb);

                $file = $request->file('thumb');
                $extension = $file->getClientOriginalExtension();
                //Cek and Create Destination Path
                if(!is_dir($destinationPath)){ mkdir($destinationPath, 0755, TRUE); }

                $originName = $file->getClientOriginalName();
                $newName = strtolower(Str::slug($request->name.bcrypt(pathinfo($originName, PATHINFO_FILENAME)))) . time();
                $newNameExt = $newName . '.' . $extension;
                $file->move($destinationPath, $newNameExt);

                $data['thumb'] = $newNameExt;
            }
            Services::whereId($request->id)->update($data);
            addToLog('Service has been successfully updated');
            DB::commit();
            return jsonResponse(true, 'Layanan berhasil diperbarui', 200);
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
            Services::whereId($idp)->update($data);
            if($value=='N') {
                addToLog('Service status has been successfully updated to Inactive');
                $textMsg = 'Status Layanan berhasil diubah menjadi <strong>Nonaktif</strong>';
            } else {
                addToLog('Service status has been successfully updated to Active');
                $textMsg = 'Status Layanan berhasil diubah menjadi <strong>Aktif</strong>';
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
            $destinationPath = public_path('/dist/img/services-img');
            $getFile = Services::whereId($idp)->first();
            $getFileThumb = $destinationPath.'/'.$getFile->thumb;
            if(file_exists($getFileThumb) && $getFile->thumb)
                unlink($getFileThumb);

            Services::whereId($idp)->delete();
            addToLog('Service has been successfully deleted');
            $textMsg = 'Layanan berhasil dihapus';

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