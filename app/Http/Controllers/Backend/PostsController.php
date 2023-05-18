<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\PostCategories;
use App\Models\Posts;
use App\Traits\SiteCommon;
use App\Traits\Select2Common;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use PhpParser\Node\Stmt\TryCatch;
use Yajra\DataTables\DataTables;

class PostsController extends Controller
{
    use SiteCommon;
    use Select2Common;
    /**
     * __construct
     *
     * @return void
     */
    public function __construct() {
        $this->middleware(['direct_permission:postingan-read'])->only(['index', 'show', 'select2_category', 'show_gallery', 'get_slugpost']);
        $this->middleware(['direct_permission:postingan-create'])->only('store');
        $this->middleware(['direct_permission:postingan-update'])->only(['update', 'update_status', 'update_itemoptionselect2', 'delete_filegallery']);
        $this->middleware(['direct_permission:postingan-delete'])->only(['delete']);
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
            'title' => 'Kelola Konten Postingan',
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
            '/dist/plugins/bootstrap-file-input/css/fileinput.min.css',
            '/dist/plugins/bootstrap-file-input/themes/explorer-fa5/theme.min.css',
        );
        //Data Source JS
        $data['js'] = array(
            '/dist/plugins/custom/datatables/datatables.bundle.v817.js',
            '/dist/plugins/summernote/summernote-lite.min.js',
            '/dist/plugins/summernote/lang/summernote-id-ID.min.js',
            '/dist/plugins/bootstrap-select/js/bootstrap-select.min.js',
            '/dist/plugins/Magnific-Popup/jquery.magnific-popup.min.js',
            '/dist/plugins/dropify-master/js/dropify.min.js',
            '/dist/plugins/bootstrap-file-input/js/plugins/piexif.min.js',
            '/dist/plugins/bootstrap-file-input/js/plugins/sortable.min.js',
            '/dist/plugins/bootstrap-file-input/js/fileinput.min.js',
            '/dist/plugins/bootstrap-file-input/themes/bs5/theme.min.js',
            '/dist/plugins/bootstrap-file-input/themes/explorer-fa5/theme.min.js',
            '/dist/js/backend_app.init.js',
            '/scripts/backend/manage_posts.init.js'
        );

        addToLog('Mengakses halaman Kelola Konten Postingan - Backend');
        return view('backend.manage_posts', compact('data'));
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
                $getRow = Posts::selectRaw('posts.*, DATE_FORMAT(posts.created_at, "%m%Y") AS mY_post, b.name AS category,
                    c.name AS user, DATE_FORMAT(posts.created_at, "%Y-%m-%d") AS tgl_post, DATE_FORMAT(posts.created_at, "%H:%i") AS waktu_post')
                    ->leftJoin('post_categories AS b', 'b.id', '=', 'posts.fid_category')
                    ->leftJoin('users_system AS c', 'c.id', '=', 'posts.user_add')
                    ->where('posts.id', $request->idp)
                    ->first();
                if($getRow != null){
                    //File Image
                    $thumb = $getRow->thumb;
                    if($thumb==''){
                        $getRow->url_thumb = NULL;
                    } else {
                        if (!file_exists(public_path(). '/dist/img/posts-img/'.$getRow->mY_post.'/'.$thumb)){
                            $getRow->url_thumb = NULL;
                            $getRow->thumb = NULL;
                        }else{
                            $getRow->url_thumb = url('dist/img/posts-img/'.$getRow->mY_post.'/'.$thumb);
                        }
                    }
                    //Keyword to Explode
                    $getRow->keyword_explode = explode(',', $getRow->keyword);
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
            $query = Posts::selectRaw('posts.*, DATE_FORMAT(posts.created_at, "%m%Y") AS mY_post, b.name AS category,
                c.name AS user, DATE_FORMAT(posts.created_at, "%Y-%m-%d") AS tgl_post, DATE_FORMAT(posts.created_at, "%H:%i") AS waktu_post')
                ->leftJoin('post_categories AS b', 'b.id', '=', 'posts.fid_category')
                ->leftJoin('users_system AS c', 'c.id', '=', 'posts.user_add');
            if($request->select_filter=='public') {
                $query = $query->where('posts.is_public', 'Y');
                $query = $query->where('posts.is_trash', 'N');
            } if($request->select_filter=='draft') {
                $query = $query->where('posts.is_public', 'N');
                $query = $query->where('posts.is_trash', 'N');
            } if($request->select_filter=='trash') {
                $query = $query->where('posts.is_trash', 'Y');
            }
            $data = $query->orderByDesc('posts.id')->get();
            $output = Datatables::of($data)->addIndexColumn()
                ->addColumn('post', function ($row) {
                    $thumb = $row->thumb;
                    if($thumb==''){
                        $url_thumb = asset('dist/img/default-placeholder.png');
                    } else {
                        if (!file_exists(public_path(). '/dist/img/posts-img/'.$row->mY_post.'/'.$thumb)){
                            $url_thumb = asset('dist/img/default-placeholder.png');
                            $thumb = NULL;
                        }else{
                            $url_thumb = url('dist/img/posts-img/'.$row->mY_post.'/'.$thumb);
                        }
                    }
                    $titleText = '<a href="javascript:void(0);" class="text-dark fw-bold fs-6">'.$row->title.'</a>';
                    if($row->is_public == 'Y') {
                        $linkSlug = url('read/'.$row->slug);
                        $titleText = '<a href="'.$linkSlug.'" class="text-dark fw-bold text-hover-primary fs-6" data-bs-toggle="tooltip" title="Lihat postingan pada halaman publik!" target="_blank">'.$row->title.'</a>';
                    }
                    $postCustom = '<div class="d-flex align-items-top">
                        <a class="d-block overlay image-popup symbol symbol-60px symbol-2by3" href="'.$url_thumb.'" title="'.$thumb.'">
                            <img src="'.$url_thumb.'" class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover rounded symbol-label" alt="'.$thumb.'" />
                            <div class="overlay-layer card-rounded bg-dark bg-opacity-25">
                                <span class="badge badge-dark"><i class="las la-search fs-3 text-light"></i></span>
                            </div>    
                        </a>   
                        <div class="m-0 ms-3">
                            '.$titleText.'
                        </div>           
                    </div>';
                    return $postCustom;
                })
                ->editColumn('category', function ($row) {
                    $iconFormat = '<i class="las la-newspaper fs-1"></i>';
                    if($row->post_format=='VIDEO') {
                        $iconFormat = '<i class="lab la-youtube fs-1"></i>';
                    } if($row->post_format=='GALLERY') {
                        $iconFormat = '<i class="las la-images fs-1"></i>';
                    }
                    $categoryCustom = '<span class="text-dark fw-bold fs-6">'.$row->category.'</span><br/><span class="text-muted fw-bold d-flex align-items-center fs-6">'.$iconFormat.' '.$row->post_format.'</span>';
                    return $categoryCustom;
                })
                ->editColumn('is_public', function ($row) {
                    if($row->is_public == 'Y'){
                        $activeCustom = '<button type="button" class="btn btn-sm btn-info mb-1" data-bs-toggle="tooltip" title="Status Aktif, Nonaktifkan ?" onclick="_updateStatus('."'".$row->id."'".', '."'N'".');"><i class="fas fa-toggle-on fs-2"></i></button>';
                    } else {
                        $activeCustom = '<button type="button" class="btn btn-sm btn-light mb-1" data-bs-toggle="tooltip" title="Status Tidak Aktif, Aktifkan ?" onclick="_updateStatus('."'".$row->id."'".', '."'Y'".');"><i class="fas fa-toggle-off fs-2"></i></button>';
                    }
                    return $activeCustom;
                })
                ->editColumn('created_at', function ($row) {
                    $createdCustom = $row->user.' <br/><div class="fw-bold text-muted"><i class="bi bi-calendar-event me-1"></i>'.date_indo($row->tgl_post).' '.$row->waktu_post.'</div>';
                    return $createdCustom;
                })
                ->addColumn('action', function($row){
                    $btnEdit = '<button type="button" class="btn btn-icon btn-circle btn-sm btn-dark mb-1 ms-1" data-bs-toggle="tooltip" title="Edit data!" onclick="_editPost('."'".$row->id."'".');"><i class="la la-edit fs-3"></i></button>';
                    $btnSampah = '<button type="button" class="btn btn-icon btn-circle btn-sm btn-danger mb-1 ms-1" data-bs-toggle="tooltip" title="Hapus data!" onclick="_resdelPost('."'".$row->id."'".', '."'Y'".');"><i class="las la-trash-alt fs-3"></i></button>';
                    $btnRestore = '<button type="button" class="btn btn-icon btn-circle btn-sm btn-light-info mb-1 ms-1" data-bs-toggle="tooltip" title="Restore data!" onclick="_resdelPost('."'".$row->id."'".', '."'N'".');"><i class="las la-undo-alt fs-3"></i></button>';
                    $btnDelete = '<button type="button" class="btn btn-icon btn-circle btn-sm btn-light-danger mb-1 ms-1" data-bs-toggle="tooltip" title="Hapus data secara permanen!" onclick="_deletePermanentlyPost('."'".$row->id."'".');"><i class="bi bi-trash fs-3"></i></button>';
                    
                    $btnAction = $btnEdit.$btnSampah;
                    if($row->is_trash == 'Y') {
                        $btnAction = $btnRestore.$btnDelete;
                    }
                    return $btnAction;
                })
                ->rawColumns(['post', 'category', 'is_public', 'created_at', 'action'])
                ->make(true);

            return $output;
        }
    }
    /**
     * show_gallery
     *
     * @param  mixed $request
     * @return void
     */
    public function show_gallery(Request $request) {
        $idp = $request->idp;
        try {
            $output = '';
            $getRows = DB::table('post_has_gallery')->where('fid_post', $idp)->orderByDesc('id')->get();
            $output .= '';
            if(count($getRows)>0){
                foreach ($getRows as $row) {
                    //File Image
                    $file_name = $row->file_name;
                    if($file_name==''){
                        $url_file = NULL;
                    } else {
                        if (!file_exists(public_path(). '/dist/img/gallery-img/'.$file_name)){
                            $url_file = NULL;
                            $file_name = NULL;
                        }else{
                            $url_file = url('dist/img/gallery-img/'.$file_name);
                        }
                    }
                    $caption = $row->caption;
                    if($caption=='' || $caption==null) {
                        $caption = $file_name;
                    }               
                    $output .= '<div class="col-sm-12 col-lg-3 text-center">
                        <a class="d-block overlay w-100 image-popup" href="'.$url_file.'" title="'.$caption.'">
                            <img src="'.$url_file.'" class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover rounded w-100 h-60px" alt="'.$file_name.'" />
                            <div class="overlay-layer card-rounded bg-dark bg-opacity-25">
                                <span class="badge badge-dark"><i class="las la-search fs-3 text-light"></i></span>
                            </div>   
                        </a>
                        <a href="javascript:void(0);" class="text-hover-danger" data-bs-toggle="tooltip" title="Hapus file ini?" onclick="deleteFileGallery('.$row->id.');">Hapus</a>        
                    </div>';
                }
            } else {
                $output .= '<div class="col-md-12 text-center">
                    <span>Tidak ditemukan gallery, Silahkan klik <strong>Tambah</strong> untuk menambahkan file gallery.</span>
                </div>';
            }
            $output .= '';
            return jsonResponse(true, 'Success', 200, $output);
        } catch (Exception $exception) {
            return jsonResponse(false, $exception->getMessage(), 401, [
                "Trace" => $exception->getTrace()
            ]);
        }
    }    
    /**
     * get_slugpost
     *
     * @param  mixed $request
     * @return void
     */
    public function get_slugpost(Request $request)
    {
        $title = $request->title;
        $datePost = date('Ymd'); //Date Now
        $CreatedSlug = Str::slug($title).'-'.$datePost.Str::lower(Str::random(16));
        $output = array('slug_post' => $CreatedSlug);
        return jsonResponse(true, 'Success', 200, $output);
    }
    /**
     * store_filegallery
     *
     * @param  mixed $request
     * @return void
     */
    public function store_filegallery(Request $request) {
        $userSesIdp = Auth::user()->id;
        $form = [
            'file_gallery' => 'mimes:png,jpg,jpeg|max:2048',
        ];
        DB::beginTransaction();
        $request->validate($form);
        try {
            if($request->id=='' || $request->id==null) {
                if($request->idGallery=='' || $request->idGallery==null) {
                    $generatedTemporaryId = random_int(1000, 9999);
                    $idpPost = $generatedTemporaryId;
                } else {
                    $idpPost = $request->idGallery;
                }
            } else {
                $idpPost = $request->id;
            }
            //array data
            $data = array(
                'fid_post' => $idpPost,
                'caption' => $request->caption_gallery !='' ? $request->caption_gallery : NULL,
                'user_add' => $userSesIdp
            );
            //Upload File
            if(!empty($_FILES['file_gallery']['name'])) {
                $destinationPath = public_path('/dist/img/gallery-img');
                $file = $request->file('file_gallery');
                $extension = $file->getClientOriginalExtension();
                //Cek and Create Destination Path
                if(!is_dir($destinationPath)){ mkdir($destinationPath, 0755, TRUE); }

                $originName = $file->getClientOriginalName();
                $newName = strtolower(Str::slug($request->caption_gallery.bcrypt(pathinfo($originName, PATHINFO_FILENAME)))) . time();
                $newNameExt = $newName . '.' . $extension;
                $file->move($destinationPath, $newNameExt);

                $data['file_name'] = $newNameExt;
            }
            $insert = DB::table('post_has_gallery')->insertGetId($data);
            addToLog('New file gallery has been successfully added');
            DB::commit();
            return jsonResponse(true, 'File galeri berhasil ditambahkan', 200, ['idp' => $idpPost]);
        } catch (Exception $exception) {
            DB::rollBack();
            return jsonResponse(false, $exception->getMessage(), 401, [
                "Trace" => $exception->getTrace()
            ]);
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
            'title' => 'required|max:200',
            'permalink_post' => 'required',
            'content' => 'required',
            'format' => 'required',
            'cbo_category' => 'required',
            'keyword' => 'required',
            'thumb' => 'mimes:png,jpg,jpeg|max:2048',
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
                'post_format' => $request->format,
                'title' => $request->title,
                'content' => $request->content,
                'keyword' => $keyword,
                'slug' => $request->permalink_post,
                'fid_category' => $request->cbo_category,
                'user_add' => $userSesIdp
            );
            //Upload File
            if(!empty($_FILES['thumb']['name'])) {
                $nowMY = date('mY');
                $destinationPath = public_path('/dist/img/posts-img/'.$nowMY);
                $file = $request->file('thumb');
                $extension = $file->getClientOriginalExtension();
                //Cek and Create Destination Path
                if(!is_dir($destinationPath)){ mkdir($destinationPath, 0755, TRUE); }

                $originName = $file->getClientOriginalName();
                $newName = strtolower(Str::slug($request->format.bcrypt(pathinfo($originName, PATHINFO_FILENAME)))) . time();
                $newNameExt = $newName . '.' . $extension;
                $file->move($destinationPath, $newNameExt);

                $data['thumb'] = $newNameExt;
            }
            //Custom Format Video
            if($request->format=='VIDEO') {
                if(isset($request->is_embed)) {
                    $data['is_embed'] = 'Y';
                    $data['link_embed'] = $request->embed;
                } else {
                    $data['link_embed'] = $request->link_media;
                }
            }

            $insert = Posts::insertGetId($data);
            addToLog('New post: '.$request->title.' has been successfully added');

            //Custom Format Gallery
            if($request->format=='GALLERY') {
                $temporaryId = $request->idGallery;
                $this->_updateGalleryFormat($insert, $temporaryId);
            }
            DB::commit();
            return jsonResponse(true, 'Postingan berhasil ditambahkan', 200);
        } catch (Exception $exception) {
            DB::rollBack();
            return jsonResponse(false, $exception->getMessage(), 401, [
                "Trace" => $exception->getTrace()
            ]);
        }
    }    
    /**
     * _updateGalleryFormat
     *
     * @param  mixed $idp
     * @param  mixed $temporaryId
     * @return void
     */
    private function _updateGalleryFormat($idp, $temporaryId) {
        DB::beginTransaction();
        try {
            $getRows = DB::table('post_has_gallery')->where('fid_post', $temporaryId)->orderByDesc('id')->get();
            if(count($getRows)>0){
                foreach ($getRows as $row) {
                    $data = array(
                        'fid_post' => $idp
                    );
                    DB::table('post_has_gallery')->whereId($row->id)->update($data);
                }
            }
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
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
            'permalink_post' => 'required',
            'content' => 'required',
            'format' => 'required',
            'cbo_category' => 'required',
            'keyword' => 'required',
            'thumb' => 'mimes:png,jpg,jpeg|max:2048',
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
                'post_format' => $request->format,
                'title' => $request->title,
                'content' => $request->content,
                'keyword' => $keyword,
                'slug' => $request->permalink_post,
                'fid_category' => $request->cbo_category,
                'is_public' => isset($request->is_public) ? 'Y' : 'N',
                'user_updated' => $userSesIdp
            );
            //Upload File
            if(!empty($_FILES['thumb']['name'])) {
                $nowMY = date('mY');
                $destinationPath = public_path('/dist/img/posts-img/'.$nowMY);
                $getFile = Posts::whereId($request->id)->first();
                $getFileImage = $destinationPath.'/'.$getFile->thumb;

                if(file_exists($getFileImage) && $getFile->thumb)
                    unlink($getFileImage);

                $file = $request->file('thumb');
                $extension = $file->getClientOriginalExtension();
                //Cek and Create Destination Path
                if(!is_dir($destinationPath)){ mkdir($destinationPath, 0755, TRUE); }

                $originName = $file->getClientOriginalName();
                $newName = strtolower(Str::slug($request->format.bcrypt(pathinfo($originName, PATHINFO_FILENAME)))) . time();
                $newNameExt = $newName . '.' . $extension;
                $file->move($destinationPath, $newNameExt);

                $data['thumb'] = $newNameExt;
            }
            //Custom Format Update
            if($request->format != $request->formatOld) {
                if($request->formatOld == 'GALLERY') {
                    $this->_deleteGallerySrc($request->id);
                }
            }
            //Custom Format Video
            if($request->format=='VIDEO') {
                if(isset($request->is_embed)) {
                    $data['is_embed'] = 'Y';
                    $data['link_embed'] = $request->embed;
                } else {
                    $data['link_embed'] = $request->link_media;
                }
            }

            Posts::whereId($request->id)->update($data);
            addToLog('Post '.$request->title.' has been successfully updated');
            DB::commit();
            return jsonResponse(true, 'Postingan berhasil diperbarui', 200);
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
            if(isset($request->is_trash)) {
                if($request->is_trash == 'Y') {
                    $data['is_public'] = 'N';
                } else {
                    $data['is_public'] = 'Y';
                }
                $data['is_trash'] = $request->is_trash;
            }

            Posts::whereId($idp)->update($data);

            if(isset($request->is_trash)) {
                if($request->is_trash == 'Y') {
                    addToLog('Post moved to the trash bin');
                    $textMsg = 'Postingan berhasil dihapus dan dipindahkan ke data sampah';
                } else {
                    addToLog('Post restore from the trash bin');
                    $textMsg = 'Postingan berhasil dikembalikan dari data sampah';
                }
            } else {
                if($value=='N') {
                    addToLog('Status post has been successfully updated to Inactive');
                    $textMsg = 'Status postingan berhasil diubah menjadi <strong>Nonaktif</strong>';
                } else {
                    addToLog('Status post has been successfully updated to Active');
                    $textMsg = 'Status postingan berhasil diubah menjadi <strong>Aktif</strong>';
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
            //array data
            $data = array(
                'name' => $request->nameOption,
                'user_add' => $userSesIdp
            );
            if($request->item_method=='cbo_category') {
                $cekData = PostCategories::where('name', $request->nameOption)->first();
                if($cekData==true) {
                    addToLog('Data cannot be saved, the same item name already exists in the system');
                    return jsonResponse(false, 'Gagal menambahkan data, nama item yang sama sudah ada pada sistem. Coba gunakan nama item yang lain', 200, array('error_code' => 'data_available'));
                } else {
                    $insert = PostCategories::insertGetId($data);
                    addToLog('Post category has been successfully added');
                    $textMsg = 'Item option Kategori Postingan berhasil ditambahkan';
                }
            }
            DB::commit();
            return jsonResponse(true, $textMsg, 200, ['idp' => $insert]);
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
            $getPost = Posts::selectRaw('posts.*, DATE_FORMAT(posts.created_at, "%m%Y") AS mY_post')->whereId($idp)->first();
            if($getPost->post_format == 'GALLERY') {
                $this->_deleteGallerySrc($idp);
            }

            $destinationPath = public_path('/dist/img/posts-img/'.$getPost->mY_post);
            $getFileThumb = $destinationPath.'/'.$getPost->thumb;
            if(file_exists($getFileThumb) && $getPost->thumb)
            unlink($getFileThumb);
            
            Posts::whereId($idp)->delete();
            addToLog('Post has been successfully deleted');
            $textMsg = 'Postingan berhasil dihapus secara permanen';
            
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
     * delete_filegallery
     *
     * @param  mixed $request
     * @return void
     */
    public function delete_filegallery(Request $request) {
        $userSesIdp = Auth::user()->id;
        $idp = $request->idp;
        DB::beginTransaction();
        try {
            $destinationPath = public_path('/dist/img/gallery-img');
            $getFile = DB::table('post_has_gallery')->select()->whereId($idp)->first();
            $idpGallery = $getFile->fid_post;
            $getFileImg = $destinationPath.'/'.$getFile->file_name;
            if(file_exists($getFileImg) && $getFile->file_name)
            unlink($getFileImg);
            
            DB::table('post_has_gallery')->whereId($idp)->delete();
            addToLog('File gallery has been successfully deleted');
            $textMsg = 'File galeri berhasil dihapus';
            
            DB::commit();
            return jsonResponse(true, $textMsg, 200, ['idp' => $idpGallery]);
        } catch (Exception $exception) {
            DB::rollBack();
            return jsonResponse(false, $exception->getMessage(), 401, [
                "Trace" => $exception->getTrace()
            ]);
        }
    }
    /**
     * _deleteGallerySrc
     *
     * @param  mixed $idpPost
     * @return void
     */
    private function _deleteGallerySrc($idpPost) {
        $userSesIdp = Auth::user()->id;
        DB::beginTransaction();
        try {
            $getGalleries = DB::table('post_has_gallery')->where('fid_post', $idpPost)->get();
            if(count($getGalleries)>0){
                $destinationPath = public_path('/dist/img/gallery-img');
                foreach ($getGalleries as $getGallery) {
                    $idFile = $getGallery->id;
                    $getFileGallery = $destinationPath.'/'.$getGallery->file_name;
                    if(file_exists($getFileGallery) && $getGallery->file_name)
                        unlink($getFileGallery);
                    DB::table('post_has_gallery')->whereId($idFile)->delete();
                }
            }
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
        }
    }
    /**
     * select2_category
     *
     * @param  mixed $request
     * @return void
     */
    public function select2_category(Request $request)
    {
        try {
            $output = $this->select2_categories($request->search, $request->page);
            return jsonResponse(true, 'Success', 200, $output);
        } catch (Exception $exception) {
            return jsonResponse(false, $exception->getMessage(), 401, [
                "Trace" => $exception->getTrace()
            ]);
        }
    }
}