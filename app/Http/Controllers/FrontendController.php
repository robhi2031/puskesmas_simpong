<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Facilities;
use App\Models\Posts;
use App\Models\PublicPages;
use App\Models\Services;
use App\Models\StudyPrograms;
use App\Traits\SiteCommon;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FrontendController extends Controller
{
    use SiteCommon;
    /**
     * index
     *
     * @return void
     */
    public function index() {
        $getSiteInfo = $this->get_siteinfo();
        //Data WebInfo
        $data = array(
            'title' => $getSiteInfo->name,
            'desc' => $getSiteInfo->description,
            'keywords' => $getSiteInfo->keyword,
            'url' => url()->current(),
            'thumb' => $getSiteInfo->url_thumb,
            'app_version' => config('app.version'),
            'app_name' => $getSiteInfo->name
        );
        //Data Source CSS
        $data['css'] = array(
            'dist/plugins/bootstrap-5.3.0-alpha3/css/bootstrap.min.css',
            'dist/assets/css/vendor/slick.css',
            'dist/assets/css/vendor/slick-theme.css',
            'dist/assets/css/plugins/sal.css',
            'dist/assets/css/plugins/feather.css',
            'dist/assets/css/plugins/fontawesome.min.css',
            'dist/assets/css/plugins/euclid-circulara.css',
            'dist/assets/css/plugins/swiper.css',
            'dist/assets/css/plugins/magnify.css',
            'dist/assets/css/plugins/odometer.css',
            'dist/assets/css/plugins/animation.css',
            'dist/assets/css/plugins/bootstrap-select.min.css',
            'dist/assets/css/plugins/jquery-ui.css',
            'dist/assets/css/plugins/magnigy-popup.min.css',
            'dist/assets/css/style.css',
        );
        //Data Source JS
        $data['js'] = array(
            'dist/assets/js/vendor/modernizr.min.js',
            'dist/assets/js/vendor/jquery.js',
            'dist/plugins/bootstrap-5.3.0-alpha3/js/bootstrap.bundle.min.js',
            'dist/assets/js/vendor/sal.js',
            'dist/assets/js/vendor/swiper.js',
            'dist/assets/js/vendor/magnify.min.js',
            'dist/assets/js/vendor/jquery-appear.js',
            'dist/assets/js/vendor/odometer.js',
            'dist/assets/js/vendor/backtotop.js',
            'dist/assets/js/vendor/isotop.js',
            'dist/assets/js/vendor/imageloaded.js',
            'dist/assets/js/vendor/wow.js',
            'dist/assets/js/vendor/waypoint.min.js',
            'dist/assets/js/vendor/easypie.js',
            'dist/assets/js/vendor/text-type.js',
            'dist/assets/js/vendor/jquery-one-page-nav.js',
            'dist/assets/js/vendor/bootstrap-select.min.js',
            'dist/assets/js/vendor/jquery-ui.js',
            'dist/assets/js/vendor/magnify-popup.min.js',
            'dist/assets/js/vendor/paralax-scroll.js',
            'dist/assets/js/vendor/paralax.min.js',
            'dist/assets/js/vendor/countdown.js',
            'dist/assets/js/scripts.bundle.js',
            'scripts/frontend/main.init.js'
        );

        addToLog('Mengakses halaman beranda - Public');
        return view('frontend.index', compact('data'));
    }
    /**
     * headSlideBanner
     *
     * @return void
     */
    public function headSlideBanner() {
        try {
            $output = '';
            $getRow = DB::table('public_bannerslide')->where('is_public', 'Y')->get();
            $output .= '';
            foreach($getRow as $key=>$row){
                //($key+1);
                $file_name = $row->file_name;
                if($file_name==''){
                    $url_file = asset('dist/img/default-img.png');
                    $file_name = 'default-img.jpg';
                } else if (!file_exists(public_path(). '/dist/img/slides-img/'.$file_name)) {
                    $url_file = asset('dist/img/default-img.png');
                }else {
                    $url_file = asset('dist/img/slides-img/'.$file_name);
                }
                $linkUrl = 'javascript:void(0);';
                $titleLinkUrl = $row->file_name;
                $targetLinkUrl = '';
                if($row->is_link=='Y'){
                    $linkUrl = $row->link_url;
                    $titleLinkUrl = $row->file_name;
                    $targetLinkUrl = 'target="'.$row->link_target.'"';
                } if($row->is_caption=='Y') {
                    $titleLinkUrl = $row->caption;
                }
                $output .='<div class="swiper-slide">
                    <div class="thumbnail">
                        <a href="'.$linkUrl.'" title="'.$titleLinkUrl.'" '.$targetLinkUrl.'>
                            <img class="rbt-radius w-100" src="'.$url_file.'" alt="'.$row->file_name.'">
                        </a>
                    </div>
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
     * contentHeadWelcome
     *
     * @return void
     */
    public function contentHeadWelcome() {
        try {
            $getSiteInfo = $this->get_siteinfo();
            $getKapuskesmas = DB::table('organization_team')->where('position', 'KEPALA PUSKESMAS')->first();
            if($getKapuskesmas != null){
                //Thumb Kepala Puskesmas
                $thumbKapuskesmas = $getKapuskesmas->thumb;
                if($thumbKapuskesmas==''){
                    $getKapuskesmas->url_thumb = asset('dist/img/default-user-img.jpg');
                } else {
                    if (!file_exists(public_path(). '/dist/img/organization-img/'.$thumbKapuskesmas)){
                        $getKapuskesmas->url_thumb = asset('dist/img/default-user-img.jpg');
                        $getKapuskesmas->thumb = NULL;
                    }else{
                        $getKapuskesmas->url_thumb = url('dist/img/organization-img/'.$thumbKapuskesmas);
                    }
                }
            }
            $organization_info = $getSiteInfo->organization_info;
            $output = [
                'text_header_welcome' => $organization_info->text_header_welcome,
                'text_welcome' => $organization_info->text_welcome,
                'name_kapuskesmas' => $getKapuskesmas->name,
                'position_kapuskesmas' => $getKapuskesmas->position,
                'thumb' => $getKapuskesmas->thumb,
                'url_thumb' => $getKapuskesmas->url_thumb
            ];
            return jsonResponse(true, 'Success', 200, $output);
        } catch (Exception $exception) {
            return jsonResponse(false, $exception->getMessage(), 401, [
                "Trace" => $exception->getTrace()
            ]);
        }
    }
    /**
     * relatedLink
     *
     * @return void
     */
    public function relatedLink(Request $request) {
        $position = $request->position;
        try {
            $output = '';
            $getRow = DB::table('public_relatedlinks')
                ->where('section_position', $position)
                ->where('is_public', 'Y')
                ->get();
            $output .= '';
            foreach($getRow as $key=>$row){
                //($key+1);
                if($position == 'relatedLinkWithImage') {
                    $img_file = $row->img_file;
                    if($img_file==''){
                        $url_file = asset('dist/img/default-img.png');
                        $img_file = 'default-img.jpg';
                    } else if (!file_exists(public_path(). '/dist/img/links-img/'.$img_file)) {
                        $url_file = asset('dist/img/default-img.png');
                    }else {
                        $url_file = asset('dist/img/links-img/'.$img_file);
                    }
                    
                    $targetLinkUrl = 'target="'.$row->link_target.'"';
                    if($row->link_target == '' || null) {
                        $targetLinkUrl = '';
                    }

                    $output .='<div class="swiper-slide">
                        <div class="single-slide mx-3">
                            <a href="'.$row->link_url.'" title="'.$row->name.'" '.$targetLinkUrl.' class="rbt-cat-box rbt-cat-box-1 image-overlaping-content image-overlaping-custom on-hover-content-visible">
                                <div class="inner">
                                    <div class="thumbnail">
                                        <img src="'.$url_file.'" alt="'.$row->img_file.'" style="object-fit: scale-down;" />
                                    </div>
                                    <!-- <div class="content">
                                        <h5 class="title mt-0">'.$row->name.'</h5>
                                    </div> -->
                                </div>
                            </a>
                        </div>
                    </div>';
                } else {
                    $targetLinkUrl = 'target="'.$row->link_target.'"';
                    if($row->link_target == '' || null) {
                        $targetLinkUrl = '';
                    }
                    $output .='<li>
                        <a href="'.$row->link_url.'" title="'.$row->name.'" '.$targetLinkUrl.'>'.$row->name.'</a>
                    </li>';
                }
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
     * mainPost
     *
     * @param  mixed $request
     * @return void
     */
    public function mainPost(Request $request) {
        $format_post = $request->format_post;
        $start_post = 0;
        $limit_post = $request->limit_post;
        try {
            $getRows = Posts::selectRaw('posts.*, DATE_FORMAT(posts.created_at, "%m%Y") AS mY_post, b.name AS category,
                c.name AS user, DATE_FORMAT(posts.created_at, "%d.%m.%Y") AS tgl_postdot, DATE_FORMAT(posts.created_at, "%Y-%m-%d") AS tgl_post,
                DATE_FORMAT(posts.created_at, "%H:%i") AS waktu_post')
                ->leftJoin('post_categories AS b', 'b.id', '=', 'posts.fid_category')
                ->leftJoin('users_system AS c', 'c.id', '=', 'posts.user_add')
                ->where('posts.post_format', $format_post)
                ->where('posts.is_public', 'Y')->where('posts.is_trash', 'N')
                ->offset($start_post)->limit($limit_post)
                ->orderByDesc('posts.id')
                ->get();

            $result = array();
            if(count($getRows)>0){
                foreach ($getRows as $row) {
                    //File Image
                    $thumb = $row->thumb;
                    if($thumb==''){
                        $url_thumb = url('dist/img/default-placeholder.png');
                        $thumb = 'default-placeholder.png';
                    } else {
                        if (!file_exists(public_path(). '/dist/img/posts-img/'.$row->mY_post.'/'.$thumb)){
                            $url_thumb = url('dist/img/default-placeholder.png');
                            $thumb = 'default-placeholder.png';
                        }else{
                            $url_thumb = url('dist/img/posts-img/'.$row->mY_post.'/'.$thumb);
                        }
                    }
                    //Keyword to Explode
                    $keyword_explode = explode(',', $row->keyword);
                    //Link URL
                    $link_url = url('read/'.$row->slug);
                    //Link Embed
                    $link_embed = $row->link_embed;
                    if($row->is_embed == 'Y') {
                        $str_embed = $row->link_embed;
                        preg_match('/src="([^"]+)"/', $str_embed, $match);
                        $link_embed = $match[1];
                    }
                    //Data Array
                    $result[] = [
                        'id' => $row->id,
                        'title' => $row->title,
                        'thumb' => $thumb,
                        'url_thumb' => $url_thumb,
                        // 'content' => $row->content,
                        'keyword' => $row->keyword,
                        'keyword' => $keyword_explode,
                        'category' => $row->category,
                        'slug' => $row->slug,
                        'link_url' => $link_url,
                        'type' => $row->post_format,
                        'views' => $row->views,
                        'date' => $row->tgl_postdot,
                        'time' => $row->waktu_post,
                        'user' => $row->user,
                        'is_embed' => $row->is_embed,
                        'link_embed' => $link_embed
                    ];
                }
            } else {
                $result = null;
            }
            return jsonResponse(true, 'Success', 200, $result);
        } catch (Exception $exception) {
            return jsonResponse(false, $exception->getMessage(), 401, [
                "Trace" => $exception->getTrace()
            ]);
        }
    }    
    /**
     * widgetSidebar
     *
     * @param  mixed $request
     * @return void
     */
    public function widgetSidebar(Request $request) {
        $format_post = 'DEFAULT';
        if(isset($request->slug)){
            $slug = $request->slug;
            $formatBySlug = Posts::select('post_format')->where('slug', $slug)->first();
            if($formatBySlug == true) {
                $format_post = $formatBySlug->post_format;
            }
        }
        $start_post = 0;
        $limit_post = $request->limit_post;
        $sort_by = $request->sort_by;
        try {
            $query = Posts::selectRaw('posts.*, DATE_FORMAT(posts.created_at, "%m%Y") AS mY_post, b.name AS category,
                c.name AS user, DATE_FORMAT(posts.created_at, "%d.%m.%Y") AS tgl_postdot, DATE_FORMAT(posts.created_at, "%Y-%m-%d") AS tgl_post,
                DATE_FORMAT(posts.created_at, "%H:%i") AS waktu_post')
                ->leftJoin('post_categories AS b', 'b.id', '=', 'posts.fid_category')
                ->leftJoin('users_system AS c', 'c.id', '=', 'posts.user_add')
                ->where('posts.post_format', $format_post)
                ->where('posts.is_public', 'Y')->where('posts.is_trash', 'N')
                ->offset($start_post)->limit($limit_post);
            if($sort_by == 'last') {
                $query = $query->orderByDesc('posts.id');
            } else {
                $query = $query->orderByDesc('posts.views');
            }
            $getRows = $query->get();

            $result = array();
            if(count($getRows)>0){
                foreach ($getRows as $row) {
                    //File Image
                    $thumb = $row->thumb;
                    if($thumb==''){
                        $url_thumb = url('dist/img/default-placeholder.png');
                        $thumb = 'default-placeholder.png';
                    } else {
                        if (!file_exists(public_path(). '/dist/img/posts-img/'.$row->mY_post.'/'.$thumb)){
                            $url_thumb = url('dist/img/default-placeholder.png');
                            $thumb = 'default-placeholder.png';
                        }else{
                            $url_thumb = url('dist/img/posts-img/'.$row->mY_post.'/'.$thumb);
                        }
                    }
                    //Link URL
                    $link_url = url('read/'.$row->slug);
                    //Data Array
                    $result[] = [
                        'id' => $row->id,
                        'title' => $row->title,
                        'thumb' => $thumb,
                        'url_thumb' => $url_thumb,
                        'category' => $row->category,
                        'slug' => $row->slug,
                        'link_url' => $link_url,
                        'type' => $row->post_format,
                        'views' => $row->views,
                        'date' => $row->tgl_postdot,
                        'time' => $row->waktu_post,
                        'user' => $row->user
                    ];
                }
            } else {
                $result = null;
            }
            return jsonResponse(true, 'Success', 200, $result);
        } catch (Exception $exception) {
            return jsonResponse(false, $exception->getMessage(), 401, [
                "Trace" => $exception->getTrace()
            ]);
        }
    }
    /**
     * read_post
     *
     * @param  mixed $slug
     * @return void
     */
    public function read_post($slug) {
        $getSiteInfo = $this->get_siteinfo();
        $getPostDtl = $this->_get_dtlpost($slug);
        if($getPostDtl == NULL){
            return abort(404);
        }
        //Data WebInfo
        $data = array(
            'title' => $getPostDtl->title. ' - ' .$getSiteInfo->name,
            'desc' => Str::limit(strip_tags($getPostDtl->content), 160),
            'keywords' => $getSiteInfo->keyword. ', ' .$getPostDtl->keyword,
            'url' => url()->current(),
            'thumb' => $getPostDtl->url_thumb,
            'app_version' => config('app.version'),
            'app_name' => $getSiteInfo->name,
            'postDetail' => $getPostDtl,
        );
        //Data Source CSS
        $data['css'] = array(
            'dist/plugins/bootstrap-5.3.0-alpha3/css/bootstrap.min.css',
            'dist/assets/css/vendor/slick.css',
            'dist/assets/css/vendor/slick-theme.css',
            'dist/assets/css/plugins/sal.css',
            'dist/assets/css/plugins/feather.css',
            'dist/assets/css/plugins/fontawesome.min.css',
            'dist/assets/css/plugins/euclid-circulara.css',
            'dist/assets/css/plugins/swiper.css',
            'dist/assets/css/plugins/magnify.css',
            'dist/assets/css/plugins/odometer.css',
            'dist/assets/css/plugins/animation.css',
            'dist/assets/css/plugins/bootstrap-select.min.css',
            'dist/assets/css/plugins/jquery-ui.css',
            'dist/assets/css/plugins/magnigy-popup.min.css',
            'dist/assets/css/style.css',
        );
        //Data Source JS
        $data['js'] = array(
            'dist/assets/js/vendor/modernizr.min.js',
            'dist/assets/js/vendor/jquery.js',
            'dist/plugins/bootstrap-5.3.0-alpha3/js/bootstrap.bundle.min.js',
            'dist/assets/js/vendor/sal.js',
            'dist/assets/js/vendor/swiper.js',
            'dist/assets/js/vendor/magnify.min.js',
            'dist/assets/js/vendor/jquery-appear.js',
            'dist/assets/js/vendor/odometer.js',
            'dist/assets/js/vendor/backtotop.js',
            'dist/assets/js/vendor/isotop.js',
            'dist/assets/js/vendor/imageloaded.js',
            'dist/assets/js/vendor/wow.js',
            'dist/assets/js/vendor/waypoint.min.js',
            'dist/assets/js/vendor/easypie.js',
            'dist/assets/js/vendor/text-type.js',
            'dist/assets/js/vendor/jquery-one-page-nav.js',
            'dist/assets/js/vendor/bootstrap-select.min.js',
            'dist/assets/js/vendor/jquery-ui.js',
            'dist/assets/js/vendor/magnify-popup.min.js',
            'dist/assets/js/vendor/paralax-scroll.js',
            'dist/assets/js/vendor/paralax.min.js',
            'dist/assets/js/vendor/countdown.js',
            'dist/assets/js/scripts.bundle.js',
            'scripts/frontend/read_post.init.js'
        );

        updateViewsPost($getPostDtl->id);

        addToLog('Detail postingan: ' .$getPostDtl->title. ' - Public');
        return view('frontend.read_post', compact('data'));
    }  
    /**
     * _get_dtlpost
     *
     * @param  mixed $slug
     * @return void
     */
    private function _get_dtlpost($slug) {
        try {
            $getRow = Posts::selectRaw('posts.*, DATE_FORMAT(posts.created_at, "%m%Y") AS mY_post, b.name AS category,
                c.name AS user, c.thumb AS user_thumb, DATE_FORMAT(posts.created_at, "%d.%m.%Y") AS tgl_postdot,
                DATE_FORMAT(posts.created_at, "%Y-%m-%d") AS tgl_post, DATE_FORMAT(posts.created_at, "%H:%i") AS waktu_post')
                ->leftJoin('post_categories AS b', 'b.id', '=', 'posts.fid_category')
                ->leftJoin('users_system AS c', 'c.id', '=', 'posts.user_add')
                ->where('posts.slug', $slug)
                ->where('posts.is_public', 'Y')->where('posts.is_trash', 'N')
                ->first();
            if($getRow==true){
                //File Image
                $thumb = $getRow->thumb;
                if($thumb==''){
                    $getRow->url_thumb = url('dist/img/default-placeholder.png');
                    $getRow->thumb = 'default-placeholder.png';
                } else {
                    if (!file_exists(public_path(). '/dist/img/posts-img/'.$getRow->mY_post.'/'.$thumb)){
                        $getRow->url_thumb = url('dist/img/default-placeholder.png');
                        $getRow->thumb = 'default-placeholder.png';
                    }else{
                        $getRow->url_thumb = url('dist/img/posts-img/'.$getRow->mY_post.'/'.$thumb);
                    }
                }
                //User Thumb
                $user_thumb = $getRow->user_thumb;
                if($user_thumb==''){
                    $getRow->url_userThumb = url('dist/img/default-user-img');
                    $getRow->user_thumb = 'default-user-img';
                } else {
                    if (!file_exists(public_path(). '/dist/img/users-img/'.$user_thumb)){
                        $getRow->url_userThumb = url('dist/img/default-user-img');
                        $getRow->user_thumb = 'default-user-img';
                    }else{
                        $getRow->url_userThumb = url('dist/img/users-img/'.$user_thumb);
                    }
                }
                //Keyword to Explode
                $getRow->keyword_explode = explode(',', $getRow->keyword);
                //Link URL
                $getRow->link_url = url('read/'.$getRow->slug);
                //Link Embed
                $getRow->link_embed = $getRow->link_embed;
                if($getRow->is_embed == 'Y') {
                    $str_embed = $getRow->link_embed;
                    preg_match('/src="([^"]+)"/', $str_embed, $match);
                    $getRow->link_embed = $match[1];
                }
                //Gallery File
                if($getRow->post_format == 'GALLERY') {
                    $galleries = DB::table('post_has_gallery')->where('fid_post', $getRow->id)->orderByDesc('id')->get();
                    if(count($galleries)>0){
                        $arr_galleries = [];
                        foreach ($galleries as $gallery) {
                            //File Image
                            $file_name = $gallery->file_name;
                            if($file_name==''){
                                $url_file = url('dist/img/default-placeholder.png');
                                $gallery->file_name = 'default-placeholder.png';
                            } else {
                                if (!file_exists(public_path(). '/dist/img/gallery-img/'.$file_name)){
                                    $url_file = url('dist/img/default-placeholder.png');
                                    $gallery->file_name = 'default-placeholder.png';
                                }else{
                                    $url_file = url('dist/img/gallery-img/'.$file_name);
                                }
                            }
                            $arr_galleries[] = [
                                'id' => $gallery->id,
                                'file_name' => $gallery->file_name,
                                'url_file' => $url_file,
                                'caption' => $gallery->caption
                            ];
                        }
                    } else {
                        $arr_galleries = null;
                    }
                    $getRow->gallery_src = $arr_galleries;
                }
                return $getRow;
            } else {
                return null;
            }
        } catch (Exception $exception) {
            return $exception;
        }
    }    
    /**
     * post
     *
     * @param  mixed $type
     * @return void
     */
    public function posts($type) {
        $getSiteInfo = $this->get_siteinfo();
        if($type=='news') {
            $type = 'Berita & Informasi';
            $desc = 'Semua berita dan informasi terkait ' .$getSiteInfo->name. ' ada disini.';
            $keywords = 'berita bp2td mempawah, informasi terbaru bp2td mempawah, berita dan informasi mempawah';
            $thumb = $getSiteInfo->url_thumb;
        } if($type=='video') {
            $type = 'Video';
            $desc = 'Semua informasi berupa media Video terkait ' .$getSiteInfo->name. ' ada disini.';
            $keywords = 'video bp2td mempawah, video terbaru bp2td mempawah, video mempawah';
            $thumb = $getSiteInfo->url_thumb;
        } if($type=='gallery') {
            $type = 'Galeri';
            $desc = 'Semua informasi berupa media Foto Galeri Kegiatan terkait ' .$getSiteInfo->name. ' ada disini.';
            $keywords = 'album galeri bp2td mempawah, galeri terbaru bp2td mempawah, galeri foto mempawah, galeri kegiatan bp2td mempawah';
            $thumb = $getSiteInfo->url_thumb;
        }
        $postType = array('Berita & Informasi','Video','Galeri');
        if(!in_array($type, $postType)) {
            return abort(404);
        }
        //Data WebInfo
        $data = array(
            'title' => $type. ' - ' .$getSiteInfo->name,
            'desc' => $desc,
            'keywords' => $getSiteInfo->keyword. ', ' .$keywords,
            'url' => url()->current(),
            'thumb' => $thumb,
            'loader-logo' => asset('dist/img/loader-logo.png'),
            'app_version' => config('app.version'),
            'app_name' => $getSiteInfo->name,
            'post_type' => $type,
        );
        //Data Source CSS
        $data['css'] = array(
            'dist/plugins/bootstrap-5.3.0-alpha3/css/bootstrap.min.css',
            'dist/assets/css/vendor/slick.css',
            'dist/assets/css/vendor/slick-theme.css',
            'dist/assets/css/plugins/sal.css',
            'dist/assets/css/plugins/feather.css',
            'dist/assets/css/plugins/fontawesome.min.css',
            'dist/assets/css/plugins/euclid-circulara.css',
            'dist/assets/css/plugins/swiper.css',
            'dist/assets/css/plugins/magnify.css',
            'dist/assets/css/plugins/odometer.css',
            'dist/assets/css/plugins/animation.css',
            'dist/assets/css/plugins/bootstrap-select.min.css',
            'dist/assets/css/plugins/jquery-ui.css',
            'dist/assets/css/plugins/magnigy-popup.min.css',
            'dist/assets/css/style.css',
        );
        //Data Source JS
        $data['js'] = array(
            'dist/assets/js/vendor/modernizr.min.js',
            'dist/assets/js/vendor/jquery.js',
            'dist/plugins/bootstrap-5.3.0-alpha3/js/bootstrap.bundle.min.js',
            'dist/assets/js/vendor/sal.js',
            'dist/assets/js/vendor/swiper.js',
            'dist/assets/js/vendor/magnify.min.js',
            'dist/assets/js/vendor/jquery-appear.js',
            'dist/assets/js/vendor/odometer.js',
            'dist/assets/js/vendor/backtotop.js',
            'dist/assets/js/vendor/isotop.js',
            'dist/assets/js/vendor/imageloaded.js',
            'dist/assets/js/vendor/wow.js',
            'dist/assets/js/vendor/waypoint.min.js',
            'dist/assets/js/vendor/easypie.js',
            'dist/assets/js/vendor/text-type.js',
            'dist/assets/js/vendor/jquery-one-page-nav.js',
            'dist/assets/js/vendor/bootstrap-select.min.js',
            'dist/assets/js/vendor/jquery-ui.js',
            'dist/assets/js/vendor/magnify-popup.min.js',
            'dist/assets/js/vendor/paralax-scroll.js',
            'dist/assets/js/vendor/paralax.min.js',
            'dist/assets/js/vendor/countdown.js',
            'dist/assets/js/scripts.bundle.js',
            'scripts/frontend/posts.init.js'
        );

        addToLog('Semua konten ' .$type. ' - Public');
        return view('frontend.posts', compact('data'));
    }    
    /**
     * mainPosts
     *
     * @param  mixed $request
     * @return void
     */
    public function mainPosts(Request $request) {
        $type = $request->type;
        if($type=='news') {
            $type = 'DEFAULT';
        } if($type=='video') {
            $type = 'VIDEO';
        } if($type=='gallery') {
            $type = 'GALLERY';
        }
        $start_post = $request->start_post;
        $limit_post = $request->limit_post;
        try {
            $query = Posts::selectRaw('posts.*, DATE_FORMAT(posts.created_at, "%m%Y") AS mY_post, b.name AS category,
                c.name AS user, DATE_FORMAT(posts.created_at, "%d.%m.%Y") AS tgl_postdot, DATE_FORMAT(posts.created_at, "%Y-%m-%d") AS tgl_post,
                DATE_FORMAT(posts.created_at, "%H:%i") AS waktu_post')
                ->leftJoin('post_categories AS b', 'b.id', '=', 'posts.fid_category')
                ->leftJoin('users_system AS c', 'c.id', '=', 'posts.user_add')
                ->where('posts.post_format', $type)
                ->where('posts.is_public', 'Y')->where('posts.is_trash', 'N')
                ->orderByDesc('posts.id');
            $getRows = $query->offset($start_post)->limit($limit_post)->get();
            $countAll = Posts::where('post_format', $type)->where('posts.is_public', 'Y')->where('posts.is_trash', 'N')->count();

            $result = array();
            if(count($getRows)>0){
                foreach ($getRows as $row) {
                    //File Image
                    $thumb = $row->thumb;
                    if($thumb==''){
                        $url_thumb = url('dist/img/default-placeholder.png');
                        $thumb = 'default-placeholder.png';
                    } else {
                        if (!file_exists(public_path(). '/dist/img/posts-img/'.$row->mY_post.'/'.$thumb)){
                            $url_thumb = url('dist/img/default-placeholder.png');
                            $thumb = 'default-placeholder.png';
                        }else{
                            $url_thumb = url('dist/img/posts-img/'.$row->mY_post.'/'.$thumb);
                        }
                    }
                    //Link URL
                    $link_url = url('read/'.$row->slug);
                    //Link Embed
                    $link_embed = $row->link_embed;
                    if($row->is_embed == 'Y') {
                        $str_embed = $row->link_embed;
                        preg_match('/src="([^"]+)"/', $str_embed, $match);
                        $link_embed = $match[1];
                    }
                    //Data Array
                    $result[] = [
                        'id' => $row->id,
                        'title' => $row->title,
                        'short_desc' => Str::limit(strip_tags($row->content), 160),
                        'thumb' => $thumb,
                        'url_thumb' => $url_thumb,
                        'category' => $row->category,
                        'slug' => $row->slug,
                        'link_url' => $link_url,
                        'type' => $row->post_format,
                        'views' => $row->views,
                        'date' => $row->tgl_postdot,
                        'time' => $row->waktu_post,
                        'user' => $row->user,
                        'is_embed' => $row->is_embed,
                        'link_embed' => $link_embed
                    ];
                }
            } else {
                $result = null;
            }
            return jsonResponse(true, 'Success', 200, ['list' => $result, 'count_all' => $countAll]);
        } catch (Exception $exception) {
            return jsonResponse(false, $exception->getMessage(), 401, [
                "Trace" => $exception->getTrace()
            ]);
        }
    }    
    /**
     * profile
     *
     * @return void
     */
    public function profile() {
        $getSiteInfo = $this->get_siteinfo();
        $getKapuskesmas = DB::table('organization_team')->where('position', 'KEPALA PUSKESMAS')->first();
        if($getKapuskesmas != null){
            //Thumb Kepala Puskesmas
            $thumbKapuskesmas = $getKapuskesmas->thumb;
            if($thumbKapuskesmas==''){
                $getKapuskesmas->url_thumb = asset('dist/img/default-user-img.jpg');
            } else {
                if (!file_exists(public_path(). '/dist/img/organization-img/'.$thumbKapuskesmas)){
                    $getKapuskesmas->url_thumb = asset('dist/img/default-user-img.jpg');
                    $getKapuskesmas->thumb = NULL;
                }else{
                    $getKapuskesmas->url_thumb = url('dist/img/organization-img/'.$thumbKapuskesmas);
                }
            }
        }
        //Data WebInfo
        $data = array(
            'title' => 'Profil - ' .$getSiteInfo->name,
            'desc' => $getSiteInfo->organization_info->short_description,
            'keywords' => 'profil, profil kapuskesmas, ' .$getSiteInfo->keyword,
            'url' => url()->current(),
            'thumb' => $getSiteInfo->url_thumb,
            'app_version' => config('app.version'),
            'app_name' => $getSiteInfo->name,
            'organization_name' => $getSiteInfo->organization_info->name,
            'organization' => $getSiteInfo->organization_info,
            'kapuskesmas' => $getKapuskesmas,
        );
        //Data Source CSS
        $data['css'] = array(
            'dist/plugins/bootstrap-5.3.0-alpha3/css/bootstrap.min.css',
            'dist/assets/css/vendor/slick.css',
            'dist/assets/css/vendor/slick-theme.css',
            'dist/assets/css/plugins/sal.css',
            'dist/assets/css/plugins/feather.css',
            'dist/assets/css/plugins/fontawesome.min.css',
            'dist/assets/css/plugins/euclid-circulara.css',
            'dist/assets/css/plugins/swiper.css',
            'dist/assets/css/plugins/magnify.css',
            'dist/assets/css/plugins/odometer.css',
            'dist/assets/css/plugins/animation.css',
            'dist/assets/css/plugins/bootstrap-select.min.css',
            'dist/assets/css/plugins/jquery-ui.css',
            'dist/assets/css/plugins/magnigy-popup.min.css',
            'dist/assets/css/style.css',
        );
        //Data Source JS
        $data['js'] = array(
            'dist/assets/js/vendor/modernizr.min.js',
            'dist/assets/js/vendor/jquery.js',
            'dist/plugins/bootstrap-5.3.0-alpha3/js/bootstrap.bundle.min.js',
            'dist/assets/js/vendor/sal.js',
            'dist/assets/js/vendor/swiper.js',
            'dist/assets/js/vendor/magnify.min.js',
            'dist/assets/js/vendor/jquery-appear.js',
            'dist/assets/js/vendor/odometer.js',
            'dist/assets/js/vendor/backtotop.js',
            'dist/assets/js/vendor/isotop.js',
            'dist/assets/js/vendor/imageloaded.js',
            'dist/assets/js/vendor/wow.js',
            'dist/assets/js/vendor/waypoint.min.js',
            'dist/assets/js/vendor/easypie.js',
            'dist/assets/js/vendor/text-type.js',
            'dist/assets/js/vendor/jquery-one-page-nav.js',
            'dist/assets/js/vendor/bootstrap-select.min.js',
            'dist/assets/js/vendor/jquery-ui.js',
            'dist/assets/js/vendor/magnify-popup.min.js',
            'dist/assets/js/vendor/paralax-scroll.js',
            'dist/assets/js/vendor/paralax.min.js',
            'dist/assets/js/vendor/countdown.js',
            'dist/assets/js/scripts.bundle.js',
            'scripts/frontend/profile.init.js'
        );

        addToLog('Mengakses halaman profil - Public');
        return view('frontend.profile', compact('data'));
    }     
    /**
     * pages
     *
     * @return void
     */
    public function pages() {
        $getSiteInfo = $this->get_siteinfo();
        $urlPage = url()->current();
        $slug = substr(strrchr(rtrim($urlPage, '/'), '/'), 1);
        $getPage = PublicPages::where('slug', $slug)->first();
        if($getPage == null){
            return abort(404);
        }
        //Data WebInfo
        $data = array(
            'title' => $getPage->title.' - ' .$getSiteInfo->name,
            'desc' => $getSiteInfo->organization_info->short_description,
            'keywords' => $getSiteInfo->keyword,
            'url' => url()->current(),
            'thumb' => $getSiteInfo->url_thumb,
            'app_version' => config('app.version'),
            'app_name' => $getSiteInfo->name,
            'dtl_page' => $getPage
        );
        //Data Source CSS
        $data['css'] = array(
            'dist/plugins/bootstrap-5.3.0-alpha3/css/bootstrap.min.css',
            'dist/assets/css/vendor/slick.css',
            'dist/assets/css/vendor/slick-theme.css',
            'dist/assets/css/plugins/sal.css',
            'dist/assets/css/plugins/feather.css',
            'dist/assets/css/plugins/fontawesome.min.css',
            'dist/assets/css/plugins/euclid-circulara.css',
            'dist/assets/css/plugins/swiper.css',
            'dist/assets/css/plugins/magnify.css',
            'dist/assets/css/plugins/odometer.css',
            'dist/assets/css/plugins/animation.css',
            'dist/assets/css/plugins/bootstrap-select.min.css',
            'dist/assets/css/plugins/jquery-ui.css',
            'dist/assets/css/plugins/magnigy-popup.min.css',
            'dist/assets/css/style.css',
        );
        //Data Source JS
        $data['js'] = array(
            'dist/assets/js/vendor/modernizr.min.js',
            'dist/assets/js/vendor/jquery.js',
            'dist/plugins/bootstrap-5.3.0-alpha3/js/bootstrap.bundle.min.js',
            'dist/assets/js/vendor/sal.js',
            'dist/assets/js/vendor/swiper.js',
            'dist/assets/js/vendor/magnify.min.js',
            'dist/assets/js/vendor/jquery-appear.js',
            'dist/assets/js/vendor/odometer.js',
            'dist/assets/js/vendor/backtotop.js',
            'dist/assets/js/vendor/isotop.js',
            'dist/assets/js/vendor/imageloaded.js',
            'dist/assets/js/vendor/wow.js',
            'dist/assets/js/vendor/waypoint.min.js',
            'dist/assets/js/vendor/easypie.js',
            'dist/assets/js/vendor/text-type.js',
            'dist/assets/js/vendor/jquery-one-page-nav.js',
            'dist/assets/js/vendor/bootstrap-select.min.js',
            'dist/assets/js/vendor/jquery-ui.js',
            'dist/assets/js/vendor/magnify-popup.min.js',
            'dist/assets/js/vendor/paralax-scroll.js',
            'dist/assets/js/vendor/paralax.min.js',
            'dist/assets/js/vendor/countdown.js',
            'dist/assets/js/scripts.bundle.js',
            'scripts/frontend/profile.init.js'
        );

        addToLog('Mengakses halaman ' .$getPage->title. ' - Public');
        return view('frontend.public_page', compact('data'));
    } 
    /**
     * searchPosts
     *
     * @param  mixed $request
     * @return void
     */
    public function searchPosts(Request $request) {
        $search = $request->search;
        $start_post = $request->start_post;
        $limit_post = $request->limit_post;
        try {
            if($search != '' || $search != null) {
                $query = Posts::selectRaw('posts.*, DATE_FORMAT(posts.created_at, "%m%Y") AS mY_post, b.name AS category,
                    c.name AS user, DATE_FORMAT(posts.created_at, "%d.%m.%Y") AS tgl_postdot, DATE_FORMAT(posts.created_at, "%Y-%m-%d") AS tgl_post,
                    DATE_FORMAT(posts.created_at, "%H:%i") AS waktu_post')
                    ->leftJoin('post_categories AS b', 'b.id', '=', 'posts.fid_category')
                    ->leftJoin('users_system AS c', 'c.id', '=', 'posts.user_add')
                    ->where('posts.title', 'like', '%'. $search .'%')
                    ->orWhere('posts.keyword', 'like', '%'. $search .'%')
                    // ->orWhere('posts.slug', 'like', '%'. $search .'%')
                    ->orWhere('b.name', 'like', '%'. $search .'%')
                    ->where('posts.is_public', 'Y')->where('posts.is_trash', 'N')
                    ->orderByDesc('posts.id');
                $getRows = $query->offset($start_post)->limit($limit_post)->get();

                $result = array();
                if(count($getRows)>0){
                    foreach ($getRows as $row) {
                        //File Image
                        $thumb = $row->thumb;
                        if($thumb==''){
                            $url_thumb = url('dist/img/default-placeholder.png');
                            $thumb = 'default-placeholder.png';
                        } else {
                            if (!file_exists(public_path(). '/dist/img/posts-img/'.$row->mY_post.'/'.$thumb)){
                                $url_thumb = url('dist/img/default-placeholder.png');
                                $thumb = 'default-placeholder.png';
                            }else{
                                $url_thumb = url('dist/img/posts-img/'.$row->mY_post.'/'.$thumb);
                            }
                        }
                        //Link URL
                        $link_url = url('read/'.$row->slug);
                        //Link Embed
                        $link_embed = $row->link_embed;
                        if($row->is_embed == 'Y') {
                            $str_embed = $row->link_embed;
                            preg_match('/src="([^"]+)"/', $str_embed, $match);
                            $link_embed = $match[1];
                        }
                        //Data Array
                        $result[] = [
                            'id' => $row->id,
                            'title' => $row->title,
                            // 'short_desc' => Str::limit(strip_tags($row->content), 160),
                            'thumb' => $thumb,
                            'url_thumb' => $url_thumb,
                            'category' => $row->category,
                            'slug' => $row->slug,
                            'link_url' => $link_url,
                            'type' => $row->post_format,
                            'views' => $row->views,
                            'date' => $row->tgl_postdot,
                            'time' => $row->waktu_post,
                            'user' => $row->user,
                            'is_embed' => $row->is_embed,
                            'link_embed' => $link_embed
                        ];
                    }
                } else {
                    $result = null;
                }
            } else {
                $result = null;
            }
            return jsonResponse(true, 'Success', 200, $result);
        } catch (Exception $exception) {
            return jsonResponse(false, $exception->getMessage(), 401, [
                "Trace" => $exception->getTrace()
            ]);
        }
    }
}