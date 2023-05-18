<?php

namespace App\Traits;

use App\Models\PostCategories;
use Illuminate\Support\Facades\DB;

trait Select2Common {    
    /**
     * select2_permission
     *
     * @return void
     */
    protected function select2_permission($search, $page, $child)
    {
        // Search term
        $searchTerm = $search;
        $page = $page;
        $result = array();
        $query = DB::table('permission_has_menus AS a')
            ->selectRaw("a.id, a.name AS text")
            ->leftJoin('permissions AS b', 'b.fid_menu', '=', 'a.id');
        if($child!='') {
            $query = $query->where('a.has_child', $child);
        }
        $query = $query->where('a.name','LIKE','%'.$searchTerm.'%');
        $start=0;
        $limit=20;
        if($page!=''){
            $start=20*$page-20;
            $limit=20;
            $getResult = $query->offset($start)->limit($limit)->groupBy('b.fid_menu')->orderBy('a.order_line', 'ASC');
        }else{
            $getResult = $query->groupBy('b.fid_menu')->orderBy('a.order_line', 'ASC');
        }

        $getArray = $getResult->get()->toArray();
        $countResult = $query->groupBy('b.fid_menu')->orderBy('a.order_line', 'ASC')->count();
        $result['results'] = $getArray;
        $pagination = array("more" => true);
        if($countResult < 20 ){
            $pagination = array("more" => false);
        }
        $result['pagination'] = $pagination;
        $result['count'] = $countResult;
        return $result;
    }    
    /**
     * select2_rankgrade
     *
     * @param  mixed $search
     * @param  mixed $page
     * @return void
     */
    protected function select2_rankgrades($search, $page)
    {
        // Search term
        $searchTerm = $search;
        $page = $page;
        $result = array();
        $query = DB::table('class_rank_master')
            ->selectRaw("id, name AS text")
            ->where('is_public', 'Y')
            ->where('name','LIKE','%'.$searchTerm.'%');

        $start=0;
        $limit=20;
        if($page!=''){
            $start=20*$page-20;
            $limit=20;
            $getResult = $query->offset($start)->limit($limit)->orderBy('name', 'ASC');
        }else{
            $getResult = $query->orderBy('name', 'ASC');
        }

        $getArray = $getResult->get()->toArray();
        $countResult = $query->orderBy('name', 'ASC')->count();
        $result['results'] = $getArray;
        $pagination = array("more" => true);
        if($countResult < 20 ){
            $pagination = array("more" => false);
        }
        $result['pagination'] = $pagination;
        $result['count'] = $countResult;
        return $result;
    }  
    /**
     * select2_position
     *
     * @param  mixed $search
     * @param  mixed $page
     * @return void
     */
    protected function select2_positions($search, $page)
    {
        // Search term
        $searchTerm = $search;
        $page = $page;
        $result = array();
        $query = DB::table('position_master')
            ->selectRaw("id, name AS text")
            ->where('is_public', 'Y')
            ->where('name','LIKE','%'.$searchTerm.'%');

        $start=0;
        $limit=20;
        if($page!=''){
            $start=20*$page-20;
            $limit=20;
            $getResult = $query->offset($start)->limit($limit)->orderBy('name', 'ASC');
        }else{
            $getResult = $query->orderBy('name', 'ASC');
        }

        $getArray = $getResult->get()->toArray();
        $countResult = $query->orderBy('name', 'ASC')->count();
        $result['results'] = $getArray;
        $pagination = array("more" => true);
        if($countResult < 20 ){
            $pagination = array("more" => false);
        }
        $result['pagination'] = $pagination;
        $result['count'] = $countResult;
        return $result;
    }    
    /**
     * select2_categories
     *
     * @param  mixed $search
     * @param  mixed $page
     * @return void
     */
    protected function select2_categories($search, $page)
    {
        // Search term
        $searchTerm = $search;
        $page = $page;
        $result = array();
        $query = PostCategories::selectRaw("id, name AS text")
            ->where('is_public', 'Y')
            ->where('name','LIKE','%'.$searchTerm.'%');

        $start=0;
        $limit=20;
        if($page!=''){
            $start=20*$page-20;
            $limit=20;
            $getResult = $query->offset($start)->limit($limit)->orderBy('name', 'ASC');
        }else{
            $getResult = $query->orderBy('name', 'ASC');
        }

        $getArray = $getResult->get()->toArray();
        $countResult = $query->orderBy('name', 'ASC')->count();
        $result['results'] = $getArray;
        $pagination = array("more" => true);
        if($countResult < 20 ){
            $pagination = array("more" => false);
        }
        $result['pagination'] = $pagination;
        $result['count'] = $countResult;
        return $result;
    }
}