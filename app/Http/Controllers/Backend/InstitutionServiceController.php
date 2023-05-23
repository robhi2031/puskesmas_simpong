<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\PublicPages;
use App\Traits\SiteCommon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class InstitutionServiceController extends Controller
{
    use SiteCommon;
    /**
     * __construct
     *
     * @return void
     */
    public function __construct() {
        $this->middleware(['direct_permission:jenis-dan-jadwal-pelayanan-read'])->only(['index', 'show']);
        // $this->middleware(['direct_permission:jenis-dan-jadwal-pelayanan-create'])->only('store');
        $this->middleware(['direct_permission:jenis-dan-jadwal-pelayanan-update'])->only(['update']);
        // $this->middleware(['direct_permission:jenis-dan-jadwal-pelayanan-delete'])->only('delete');
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
            'title' => 'Kelola Halaman Jenis dan Jadwal Pelayanan',
            'url' => url()->current(),
            'app_version' => config('app.version'),
            'app_name' => $getSiteInfo->name,
            'user_session' => $getUserSession
        );
        //Data Source CSS
        $data['css'] = array(
            '/dist/plugins/summernote/summernote-lite.min.css',
        );
        //Data Source JS
        $data['js'] = array(
            '/dist/plugins/summernote/summernote-lite.min.js',
            '/dist/plugins/summernote/lang/summernote-id-ID.min.js',
            '/dist/js/backend_app.init.js',
            '/scripts/backend/manage_institutionservice.init.js'
        );

        addToLog('Mengakses halaman Kelola Jenis dan Jadwal Pelayanan - Backend');
        return view('backend.manage_institutionservice', compact('data'));
    }
    /**
     * show
     *
     * @param  mixed $request
     * @return void
     */
    public function show(Request $request)
    {
        if(isset($request->slugPage)){
            try {
                $getRow = PublicPages::where('slug', $request->slugPage)
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
            'title' => 'required|max:200',
            'content' => 'required',
        ];
        DB::beginTransaction();
        $request->validate($form);
        try {
            //array data
            $data = array(
                'title' => $request->title,
                'content' => $request->content,
                'user_updated' => $userSesIdp
            );
            PublicPages::whereId($request->id)->update($data);
            addToLog('Service page has been successfully updated');
            DB::commit();
            return jsonResponse(true, 'Halaman jenis dan jadwal pelayanan berhasil diperbarui', 200);
        } catch (Exception $exception) {
            DB::rollBack();
            return jsonResponse(false, $exception->getMessage(), 401, [
                "Trace" => $exception->getTrace()
            ]);
        }
    }
}