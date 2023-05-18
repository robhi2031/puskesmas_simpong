<?php

use App\Models\Posts;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

/* start:API RESPONSE */

if (! function_exists('jsonResponse')) {      
    /**
     * jsonResponse
     *
     * @param  mixed $data
     * @param  mixed $message
     * @param  mixed $code
     * @return Illuminate\Http\JsonResponse
     */
    function jsonResponse(bool $status = true, string $message = 'Success', int $code = 200, $data = null): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'row' => $data
        ], $code);
    }
}
/* end:API RESPONSE */
/* start:get User Menus */
if (! function_exists('userMenus')) {
    /**
     * userMenus
     *
     * @return void
     */
    function userMenus()
    {
        $idp = Auth::user()->id;
        $getRows = Role::select('e.*')
            ->join('model_has_roles AS b', 'roles.id', '=', 'b.role_id', 'LEFT OUTER')
            ->join('role_has_permissions AS c', 'roles.id', '=', 'c.role_id', 'LEFT OUTER')
            ->join('permissions AS d', 'c.permission_id', '=', 'd.id', 'LEFT OUTER')
            ->join('permission_has_menus AS e', 'd.fid_menu', '=', 'e.id', 'LEFT OUTER')
            ->where('b.model_id', $idp)
            ->where('e.parent_id', '')->orWhereNull('parent_id')
            ->groupBy('d.fid_menu')
            ->orderBy('e.order_line', 'ASC')
            ->get();
        $array = [];
        if(count($getRows)>0){
            foreach ($getRows as $row) {
                $getChildren = Role::select('e.*')
                    ->join('model_has_roles AS b', 'roles.id', '=', 'b.role_id', 'LEFT OUTER')
                    ->join('role_has_permissions AS c', 'roles.id', '=', 'c.role_id', 'LEFT OUTER')
                    ->join('permissions AS d', 'c.permission_id', '=', 'd.id', 'LEFT OUTER')
                    ->join('permission_has_menus AS e', 'd.fid_menu', '=', 'e.id', 'LEFT OUTER')
                    ->where('b.model_id', $idp)
                    ->where('e.parent_id', $row->id)
                    ->groupBy('d.fid_menu')
                    ->orderBy('e.order_line', 'ASC')
                    ->get();

                $array_child = [];
                if(count($getChildren)>0){
                    foreach ($getChildren as $child) {
                        $array_child[] = [
                            'menu' => $child->name,
                            'icon' => $child->icon,
                            'route_name' => $child->route_name,
                        ];
                    }
                }

                $array[] = [
                    'menu' => $row->name,
                    'icon' => $row->icon,
                    'route_name' => $row->route_name,
                    'has_child' => $row->has_child,
                    'children' => $array_child
                ];
            }
            return $array;
        } else {
            return $array;
        }
    }
}
/* end:get User Menus */
/* start:get Public Menus */
if (! function_exists('publicMenus')) {
    /**
     * publicMenus
     *
     * @return void
     */
    function publicMenus()
    {
        $jsonMenus = '{
            "menus":[  
                {
                    "menu": "Beranda",
                    "icon": "fas fa-home",
                    "route_name": "/",
                    "has_child": "N"
                },
                {
                    "menu": "Profil",
                    "icon": "fas fa-info",
                    "route_name": "profil",
                    "has_child": "N"
                },
                {
                    "menu": "Fasilitas",
                    "icon": "fas fa-mail-bulk",
                    "route_name": "fasilitas",
                    "has_child": "N"
                },
                {
                    "menu": "Program Studi",
                    "icon": "fas fa-server",
                    "route_name": "program_studi",
                    "has_child": "N"
                },
                {
                    "menu": "Layanan",
                    "icon": "fas fa-suitcase",
                    "route_name": "layanan",
                    "has_child": "N"
                },
                {
                    "menu": "Publikasi",
                    "icon": "fas fa-newspaper",
                    "route_name": "",
                    "has_child": "Y",
                    "children":{
                        "submenu":[
                            {
                                "menu": "Publikasi",
                                "sub_menu": "Berita & Informasi",
                                "route_name": "all/news"
                            },
                            {
                                "menu": "Publikasi",
                                "sub_menu": "Video",
                                "route_name": "all/video"
                            },
                            {
                                "menu": "Publikasi",
                                "sub_menu": "Galeri",
                                "route_name": "all/gallery"
                            }
                        ]
                    }
                }
            ]
        }';
        $getRows = json_decode($jsonMenus, true);
        return $getRows;
    }
}
/* end:get Public Menus */
/**
 * assignPermissionToUser
 *
 * @param  mixed $idpRole
 * @param  mixed $permission
 * @return void
 */
if(!function_exists('assignPermissionToUser'))
{    
    function assignPermissionToUser($idpRole, $permission)
    {
        $users = User::leftJoin('model_has_roles', 'model_has_roles.model_id', 'users_system.id')
        ->select('users_system.*')
        ->where('model_has_roles.role_id', '=', $idpRole)
        ->get();

        if($users) {
            foreach ($users as $user) {
                $user->givePermissionTo($permission->name);
            }
        }
    }
}
/**
 * revokePermissionToUser
 *
 * @param  mixed $idpRole
 * @param  mixed $permission
 * @return void
 */
if(!function_exists('revokePermissionToUser'))
{
    function revokePermissionToUser($idpRole, $permission)
    {
        $users = User::leftJoin('model_has_roles', 'model_has_roles.model_id', 'users_system.id')
        ->select('users_system.*')
        ->where('model_has_roles.role_id', '=', $idpRole)
        ->get();

        if($users) {
            foreach ($users as $user) {
                $user->revokePermissionTo($permission->name);
            }
        }
    }
}
/* start:Time a Go */
if(!function_exists('time_ago'))
{
    function time_ago($datetime, $full = false)
    {
        $time_ago     = strtotime($datetime);
        $current_time = strtotime(date("Y-m-d H:i:s"));
        $time_difference = $current_time - $time_ago;
        $seconds      = $time_difference;
        $minutes      = round($seconds / 60 );           // value 60 is seconds
        $hours        = round($seconds / 3600);           //value 3600 is 60 minutes * 60 sec
        $days         = round($seconds / 86400);          //86400 = 24 * 60 * 60;
        $weeks        = round($seconds / 604800);          // 7*24*60*60;
        $months       = round($seconds / 2629440);     //((365+365+365+365+366)/5/12)*24*60*60
        $years        = round($seconds / 31553280);     //(365+365+365+365+366)/5 * 24 * 60 * 60
        if($seconds <= 60){
            return "Baru Saja";
        }else if($minutes <=60){
            if($minutes==1){
                return "1 Menit yang lalu";
            }else{
                return $minutes." Menit yang lalu";
            }
        }else if($hours <=24){
            if($hours==1){
                return "1 Jam yang lalu";
            }else{
                return $hours." Jam yang lalu";
            }
        }else if($days <= 7){
            if($days==1){
                return "Kemarin";
            }else{
                return $days." Hari yang lalu";
            }
        }else if($weeks <= 4.3){ //4.3 == 52/12
            if($weeks==1){
                return "1 Minggu yang lalu";
            }else{
                return $weeks." Minggu yang lalu.";
            }
        }else if($months <=12){
            if($months==1){
                return "1 Bulan yang lalu";
            }else{
                return $months." Bulan yang lalu";
            }
        }else{
            if($years==1){
                return "1 Tahun yang lalu";
            }else{
                return $years." Tahun yang lalu";
            }
        }
    }
}
/* end:Time a Go */
/* start:Date Indo */
if ( ! function_exists('tgl_indo')){
    function date_indo($tgl){
        $ubah = gmdate($tgl, time()+60*60*8);
        $pecah = explode("-",$ubah);
        $tanggal = $pecah[2];
        $bulan = bulan($pecah[1]);
        $tahun = $pecah[0];
        return $tanggal.' '.$bulan.' '.$tahun;
    }
}
if ( ! function_exists('bulan')){
    function bulan($bln){
        switch ($bln){
            case 1:
            return "Januari";
            break;
            case 2:
            return "Februari";
            break;
            case 3:
            return "Maret";
            break;
            case 4:
            return "April";
            break;
            case 5:
            return "Mei";
            break;
            case 6:
            return "Juni";
            break;
            case 7:
            return "Juli";
            break;
            case 8:
            return "Agustus";
            break;
            case 9:
            return "September";
            break;
            case 10:
            return "Oktober";
            break;
            case 11:
            return "November";
            break;
            case 12:
            return "Desember";
            break;
        }
    }
}
//Format Shortdate
if ( ! function_exists('shortdate_indo')){
    function shortdate_indo($tgl){
        $ubah = gmdate($tgl, time()+60*60*8);
        $pecah = explode("-",$ubah);
        $tanggal = $pecah[2];
        $bulan = short_bulan($pecah[1]);
        $tahun = $pecah[0];
        return $tanggal.'/'.$bulan.'/'.$tahun;
    }
}
if ( ! function_exists('short_bulan')){
    function short_bulan($bln){
        switch ($bln){
            case 1:
            return "01";
            break;
            case 2:
            return "02";
            break;
            case 3:
            return "03";
            break;
            case 4:
            return "04";
            break;
            case 5:
            return "05";
            break;
            case 6:
            return "06";
            break;
            case 7:
            return "07";
            break;
            case 8:
            return "08";
            break;
            case 9:
            return "09";
            break;
            case 10:
            return "10";
            break;
            case 11:
            return "11";
            break;
            case 12:
            return "12";
            break;
        }
    }
}
//Format Medium date
if ( ! function_exists('mediumdate_indo')){
    function mediumdate_indo($tgl){
        $ubah = gmdate($tgl, time()+60*60*8);
        $pecah = explode("-",$ubah);
        $tanggal = $pecah[2];
        $bulan = medium_bulan($pecah[1]);
        $tahun = $pecah[0];
        return $tanggal.' '.$bulan.' '.$tahun;
    }
}
if ( ! function_exists('medium_bulan')){
    function medium_bulan($bln){
        switch ($bln){
            case 1:
            return "Jan";
            break;
            case 2:
            return "Feb";
            break;
            case 3:
            return "Mar";
            break;
            case 4:
            return "Apr";
            break;
            case 5:
            return "Mei";
            break;
            case 6:
            return "Jun";
            break;
            case 7:
            return "Jul";
            break;
            case 8:
            return "Ags";
            break;
            case 9:
            return "Sep";
            break;
            case 10:
            return "Okt";
            break;
            case 11:
            return "Nov";
            break;
            case 12:
            return "Des";
            break;
        }
    }
}
//Long date indo Format
if ( ! function_exists('longdate_indo')){
    function longdate_indo($tanggal){
        $ubah = gmdate($tanggal, time()+60*60*8);
        $pecah = explode("-",$ubah);
        $tgl = $pecah[2];
        $bln = $pecah[1];
        $thn = $pecah[0];
        $bulan = bulan($pecah[1]);

        $nama = date("l", mktime(0,0,0,$bln,$tgl,$thn));
        $nama_hari = "";
        if($nama=="Sunday") {$nama_hari="Minggu";}
        else if($nama=="Monday") {$nama_hari="Senin";}
        else if($nama=="Tuesday") {$nama_hari="Selasa";}
        else if($nama=="Wednesday") {$nama_hari="Rabu";}
        else if($nama=="Thursday") {$nama_hari="Kamis";}
        else if($nama=="Friday") {$nama_hari="Jumat";}
        else if($nama=="Saturday") {$nama_hari="Sabtu";}
        return $nama_hari.', '.$tgl.' '.$bulan.' '.$thn;
    }
}
/* end:Date Indo */
/* start:Convert Youtube Link to Embed Link */
if ( ! function_exists('convertYoutubeEmbedLink')){
    function convertYoutubeEmbedLink($youtubeLink) {
        $shortUrlRegex = '/youtu.be\/([a-zA-Z0-9_-]+)\??/i';
        $longUrlRegex = '/youtube.com\/((?:embed)|(?:watch))((?:\?v\=)|(?:\/))([a-zA-Z0-9_-]+)/i';
        if (preg_match($longUrlRegex, $youtubeLink, $matches)) {
            $youtube_id = $matches[count($matches) - 1];
        } if (preg_match($shortUrlRegex, $youtubeLink, $matches)) {
            $youtube_id = $matches[count($matches) - 1];
        }
        return 'https://www.youtube.com/embed/' . $youtube_id ;
    }
}
/* end:Convert Youtube Link to Embed Link */
/* start:Update Views Post */
if ( ! function_exists('updateViewsPost')){
    function updateViewsPost($idp) {
        DB::beginTransaction();
        try {
            $getViewsPost = Posts::select('views')->whereId($idp)->first();
            $views = $getViewsPost->views;
            $dataViews = array(
                'views' => $views+1
            );
            Posts::whereId($idp)->update($dataViews);
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
        }
    }
}
/* end:Update Views Post */