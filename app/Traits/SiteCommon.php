<?php

namespace App\Traits;

use App\Models\SiteInfo;
use Illuminate\Support\Facades\DB;

trait SiteCommon {
    /**
     * get_systeminfo
     *
     * @return void
     */
    protected function get_siteinfo()
    {
        $getRow = SiteInfo::where('id', 1)->first();
        if($getRow==true){
            $getOrganizationInfo = DB::table('organization_information')->where('id', 1)->first();
            $getRow->organization_info = $getOrganizationInfo;
            //Logo Instansi/ Organisasi
            $organizationLogo = $getOrganizationInfo->logo;
            if($organizationLogo==''){
                $getRow->organization_info->url_logo = NULL;
            } else {
                if (!file_exists(public_path(). '/dist/img/organization-img/'.$organizationLogo)){
                    $getRow->organization_info->url_logo = NULL;
                    $getRow->organization_info->logo = NULL;
                }else{
                    $getRow->organization_info->url_logo = url('dist/img/organization-img/'.$organizationLogo);
                }
            }
            //Struktur Organisasi Instansi/ Organisasi
            $organizationStructure = $getOrganizationInfo->organization_structure;
            if($organizationStructure==''){
                $getRow->organization_info->url_organizationStructure = NULL;
            } else {
                if (!file_exists(public_path(). '/dist/img/organization-img/'.$organizationStructure)){
                    $getRow->organization_info->url_organizationStructure = NULL;
                    $getRow->organization_info->organization_structure = NULL;
                }else{
                    $getRow->organization_info->url_organizationStructure = url('dist/img/organization-img/'.$organizationStructure);
                }
            }
            //Frontend Logo Site
            $frontend_logo = $getRow->frontend_logo;
            if($frontend_logo==''){
                $getRow->url_frontendLogo = NULL;
            } else {
                if (!file_exists(public_path(). '/dist/img/site-img/'.$frontend_logo)){
                    $getRow->url_frontendLogo = NULL;
                    $getRow->frontend_logo = NULL;
                }else{
                    $getRow->url_frontendLogo = url('dist/img/site-img/'.$frontend_logo);
                }
            }
            //Login Background
            $login_bg = $getRow->login_bg;
            if($login_bg==''){
                $getRow->url_loginBg = NULL;
            } else {
                if (!file_exists(public_path(). '/dist/img/site-img/'.$login_bg)){
                    $getRow->url_loginBg = NULL;
                    $getRow->login_bg = NULL;
                }else{
                    $getRow->url_loginBg = url('dist/img/site-img/'.$login_bg);
                }
            }
            //Login Logo
            $login_logo = $getRow->login_logo;
            if($login_logo==''){
                $getRow->url_loginLogo = NULL;
            } else {
                if (!file_exists(public_path(). '/dist/img/site-img/'.$login_logo)){
                    $getRow->url_loginLogo = NULL;
                    $getRow->login_logo = NULL;
                }else{
                    $getRow->url_loginLogo = url('dist/img/site-img/'.$login_logo);
                }
            }
            //Backend Logo
            $backend_logo = $getRow->backend_logo;
            if($backend_logo==''){
                $getRow->url_backendLogo = NULL;
            } else {
                if (!file_exists(public_path(). '/dist/img/site-img/'.$backend_logo)){
                    $getRow->url_backendLogo = NULL;
                    $getRow->backend_logo = NULL;
                }else{
                    $getRow->url_backendLogo = url('dist/img/site-img/'.$backend_logo);
                }
            }
            //Backend Logo Icon
            $backend_logo_icon = $getRow->backend_logo_icon;
            if($backend_logo_icon==''){
                $getRow->url_backendLogoIcon = NULL;
            } else {
                if (!file_exists(public_path(). '/dist/img/site-img/'.$backend_logo_icon)){
                    $getRow->url_backendLogoIcon = NULL;
                    $getRow->backend_logo_icon = NULL;
                }else{
                    $getRow->url_backendLogoIcon = url('dist/img/site-img/'.$backend_logo_icon);
                }
            }
            //Keyword to Explode
            $getRow->keyword_explode = explode(',', $getRow->keyword);
            return $getRow;
        } else {
            return null;
        }
    }

}