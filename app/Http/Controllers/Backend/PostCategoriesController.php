<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\PostCategories;
use App\Models\Posts;
use App\Traits\SiteCommon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class PostCategoriesController extends Controller
{
    use SiteCommon;
    /**
     * __construct
     *
     * @return void
     */
    public function __construct() {
        $this->middleware(['direct_permission:kategori-read'])->only(['index', 'show']);
        $this->middleware(['direct_permission:kategori-create'])->only('store');
        $this->middleware(['direct_permission:kategori-update'])->only(['update', 'update_status']);
        $this->middleware(['direct_permission:kategori-delete'])->only('delete');
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
            'title' => 'Kelola Data Kategori Postingan',
            'url' => url()->current(),
            'app_version' => config('app.version'),
            'app_name' => $getSiteInfo->name,
            'user_session' => $getUserSession
        );
        //Data Source CSS
        $data['css'] = array(
            '/dist/plugins/custom/datatables/datatables.bundle.v817.css',
            '/dist/plugins/bootstrap-select/css/bootstrap-select.min.css',
        );
        //Data Source JS
        $data['js'] = array(
            '/dist/plugins/custom/datatables/datatables.bundle.v817.js',
            '/dist/plugins/bootstrap-select/js/bootstrap-select.min.js',
            '/dist/js/backend_app.init.js',
            '/scripts/backend/manage_postcategories.init.js'
        );

        addToLog('Mengakses halaman Kelola Data Kategori Postingan - Backend');
        return view('backend.manage_postcategories', compact('data'));
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
                $getRow = PostCategories::whereId($request->idp)
                    ->first();
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
        } else {
            $data = PostCategories::orderByDesc('id')->get();
            $output = Datatables::of($data)->addIndexColumn()
                ->addColumn('count_post', function($row){
                    $countPost = Posts::selectRaw('COUNT(IF(is_public = "Y", id, NULL)) AS count_active, COUNT(IF(is_public = "N", id, NULL)) AS count_nonactive')->where('fid_category', $row->id)->first();
                    $ttlPost = (float)$countPost->count_active+(float)$countPost->count_nonactive;
                    $countCustom = '<span class="fw-bold text-hover-primary" data-bs-toggle="tooltip" data-bs-html="true" title="Active = '.$countPost->count_active.' Post <br />Non-Active = '.$countPost->count_nonactive.' Post">'.$ttlPost.'</span>';
                    return $countCustom;
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
                    $btnEdit = '<button type="button" class="btn btn-icon btn-circle btn-sm btn-dark mb-1 ms-1" data-bs-toggle="tooltip" title="Edit data!" onclick="_editCategory('."'".$row->id."'".');"><i class="la la-edit fs-3"></i></button>';
                    // $btnDelete = '<button type="button" class="btn btn-icon btn-circle btn-sm btn-danger mb-1 ms-1" data-bs-toggle="tooltip" title="Hapus data!" onclick="_deleteCategory('."'".$row->id."'".');"><i class="las la-trash-alt fs-3"></i></button>';
                    return $btnEdit; //.$btnDelete;
                })
                ->rawColumns(['count_post', 'is_public', 'action'])
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
        ];
        DB::beginTransaction();
        $request->validate($form);
        try {
            //array data
            $data = array(
                'name' => $request->name,
                'user_add' => $userSesIdp
            );
            $insert = PostCategories::insertGetId($data);
            addToLog('Post category has been successfully added');
            DB::commit();
            return jsonResponse(true, 'Kategori postingan berhasil ditambahkan', 200);
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
        ];
        DB::beginTransaction();
        $request->validate($form);
        try {
            //array data
            $data = array(
                'name' => $request->name,
                'is_public' => isset($request->is_public) ? 'Y' : 'N',
                'user_updated' => $userSesIdp
            );
            PostCategories::whereId($request->id)->update($data);
            addToLog('Post category has been successfully updated');
            DB::commit();
            return jsonResponse(true, 'Kategori postingan berhasil diperbarui', 200);
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
            PostCategories::whereId($idp)->update($data);
            if($value=='N') {
                addToLog('Post category status has been successfully updated to Inactive');
                $textMsg = 'Status kategori postingan berhasil diubah menjadi <strong>Nonaktif</strong>';
            } else {
                addToLog('Post category status has been successfully updated to Active');
                $textMsg = 'Status kategori postingan berhasil diubah menjadi <strong>Aktif</strong>';
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
            PostCategories::whereId($idp)->delete();
            addToLog('Post category has been successfully deleted');
            $textMsg = 'Kategori postingan berhasil dihapus';

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