<?php

use App\Http\Controllers\Backend\BannerSlidesController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\Backend\UserProfileController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\InstitutionFacilitiesController;
use App\Http\Controllers\Backend\InstitutionProfileController;
use App\Http\Controllers\Backend\InstitutionServicesController;
use App\Http\Controllers\Backend\InstitutionStudyProgramsController;
use App\Http\Controllers\Backend\PermissionsController;
use App\Http\Controllers\Backend\RelatedLinksController;
use App\Http\Controllers\Backend\PostCategoriesController;
use App\Http\Controllers\Backend\PostsController;
use App\Http\Controllers\Backend\RolesController;
use App\Http\Controllers\Backend\SiteInfoController;
use App\Http\Controllers\Backend\UsersActivityController;
use App\Http\Controllers\Backend\UsersController;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\Login\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Frontend
Route::get('/', [FrontendController::class, 'index'])->name('home');
Route::get('/all/{type}', [FrontendController::class, 'posts'])->name('posts');
Route::get('/read/{slug}', [FrontendController::class, 'read_post'])->name('read_post');
Route::get('/profil', [FrontendController::class, 'profile'])->name('profile');
Route::get('/fasilitas', [FrontendController::class, 'facilities'])->name('facilities');
Route::get('/program_studi', [FrontendController::class, 'study_programs'])->name('study_programs');
Route::get('/layanan', [FrontendController::class, 'services'])->name('services');
// Auth Login
Route::group(['prefix' => 'auth'], function () {
    Route::get('/', [AuthController::class, 'index'])->name('login')->middleware('guest');
    Route::get('/logout', [AuthController::class, 'logout_sessions'])->name('logout_sessions');
});

//Api Ajax Common Public
Route::group(['prefix' => 'api'], function () {
    Route::get('/site_info', [CommonController::class, 'site_info'])->name('site_info');
    Route::get('/head_slidebanner', [FrontendController::class, 'headSlideBanner'])->name('headSlideBanner');
    Route::get('/head_welcome', [FrontendController::class, 'contentHeadWelcome'])->name('contentHeadWelcome');
    Route::get('/show_mainpost', [FrontendController::class, 'mainPost'])->name('mainPost');
    Route::get('/widget_sidebar', [FrontendController::class, 'widgetSidebar'])->name('widgetSidebar');
    Route::get('/main_posts', [FrontendController::class, 'mainPosts'])->name('mainPosts');
    Route::get('/search_posts', [FrontendController::class, 'searchPosts'])->name('searchPosts');
    Route::get('/main_facilities', [FrontendController::class, 'mainFacilities'])->name('mainFacilities');
    Route::get('/main_studyprograms', [FrontendController::class, 'mainStudyPrograms'])->name('mainStudyPrograms');
    Route::get('/main_services', [FrontendController::class, 'mainServices'])->name('mainServices');
    Route::get('/related_link', [FrontendController::class, 'relatedLink'])->name('relatedLink');
    Route::group(['prefix' => 'auth'], function () {
        Route::post('/first_login', [AuthController::class, 'first_login'])->name('first_login');
        Route::post('/second_login', [AuthController::class, 'second_login'])->name('second_login');
    });
});

// Dashboard Backend
Route::group(['middleware' => ['auth:sanctum']], function () {
    // Auth Logout
    Route::group(['prefix' => 'auth'], function () {
        Route::get('/logout', [AuthController::class, 'logout_sessions'])->name('logout_sessions');
    });
    // App Admin
    Route::group(['prefix' => 'app_admin'], function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/manage_institutionprofile', [InstitutionProfileController::class, 'index'])->name('manage_institutionprofile');
        Route::get('/manage_institutionfacilities', [InstitutionFacilitiesController::class, 'index'])->name('manage_institutionfacilities');
        Route::get('/manage_institutionservices', [InstitutionServicesController::class, 'index'])->name('manage_institutionservices');
        Route::get('/manage_institutionstudyprograms', [InstitutionStudyProgramsController::class, 'index'])->name('manage_institutionstudyprograms');
        Route::get('/manage_bannerslides', [BannerSlidesController::class, 'index'])->name('manage_bannerslides');
        Route::get('/manage_relatedlinks', [RelatedLinksController::class, 'index'])->name('manage_relatedlinks');
        Route::get('/manage_postcategories', [PostCategoriesController::class, 'index'])->name('manage_postcategories');
        Route::get('/manage_posts', [PostsController::class, 'index'])->name('manage_posts');
        Route::get('/manage_siteinfo', [SiteInfoController::class, 'index'])->name('manage_siteinfo');
        Route::get('/manage_roles', [RolesController::class, 'index'])->name('manage_roles');
        Route::get('/manage_permissions', [PermissionsController::class, 'index'])->name('manage_permissions');
        Route::get('/manage_users', [UsersController::class, 'index'])->name('manage_users');
        Route::get('/users_activity', [UsersActivityController::class, 'index'])->name('users_activity');
        Route::get('/{username}', [UserProfileController::class,'index'])->name('user_profile');
    });
    //Api Ajax App Auth
    Route::group(['prefix' => 'api'], function () {
        //Manage Site Info
        Route::post('/manage_siteinfo/update', [SiteInfoController::class, 'update'])->name('update_siteinfo');
        //Manage Profil Institusi
        Route::get('/manage_institutionprofile/show', [InstitutionProfileController::class, 'show'])->name('show_institutionprofile');
        Route::get('/manage_institutionprofile/selectpicker_employmentstatus', [InstitutionProfileController::class, 'selectpicker_employmentstatus'])->name('selectpicker_employmentstatus');
        Route::get('/manage_institutionprofile/select2_rankgrade', [InstitutionProfileController::class, 'select2_rankgrade'])->name('select2_rankgrade');
        Route::get('/manage_institutionprofile/select2_position', [InstitutionProfileController::class, 'select2_position'])->name('select2_position');
        Route::post('/manage_institutionprofile/update', [InstitutionProfileController::class, 'update'])->name('update_institutionprofile');
        Route::post('/manage_institutionprofile/update_itemoptionselect2', [InstitutionProfileController::class, 'update_itemoptionselect2'])->name('update_itemoptionselect2');
        //Manage Fasilitas Institusi
        Route::get('/manage_institutionfacilities/show', [InstitutionFacilitiesController::class, 'show'])->name('show_institutionfacilities');
        Route::post('/manage_institutionfacilities/store', [InstitutionFacilitiesController::class, 'store'])->name('store_institutionfacilities');
        Route::post('/manage_institutionfacilities/update', [InstitutionFacilitiesController::class, 'update'])->name('update_institutionfacilities');
        Route::post('/manage_institutionfacilities/update_status', [InstitutionFacilitiesController::class, 'update_status'])->name('update_statusinstitutionfacilities');
        Route::post('/manage_institutionfacilities/delete', [InstitutionFacilitiesController::class, 'delete'])->name('delete_institutionfacilities');
        //Manage Layanan Institusi
        Route::get('/manage_institutionservices/show', [InstitutionServicesController::class, 'show'])->name('show_institutionservices');
        Route::post('/manage_institutionservices/store', [InstitutionServicesController::class, 'store'])->name('store_institutionservices');
        Route::post('/manage_institutionservices/update', [InstitutionServicesController::class, 'update'])->name('update_institutionservices');
        Route::post('/manage_institutionservices/update_status', [InstitutionServicesController::class, 'update_status'])->name('update_statusinstitutionservices');
        Route::post('/manage_institutionservices/delete', [InstitutionServicesController::class, 'delete'])->name('delete_institutionservices');
        //Manage Program Studi Institusi
        Route::get('/manage_institutionstudyprograms/show', [InstitutionStudyProgramsController::class, 'show'])->name('show_institutionstudyprograms');
        Route::post('/manage_institutionstudyprograms/store', [InstitutionStudyProgramsController::class, 'store'])->name('store_institutionstudyprograms');
        Route::post('/manage_institutionstudyprograms/update', [InstitutionStudyProgramsController::class, 'update'])->name('update_institutionstudyprograms');
        Route::post('/manage_institutionstudyprograms/update_status', [InstitutionStudyProgramsController::class, 'update_status'])->name('update_statusinstitutionstudyprograms');
        Route::post('/manage_institutionstudyprograms/delete', [InstitutionStudyProgramsController::class, 'delete'])->name('delete_institutionstudyprograms');
        //Manage Banner Slides
        Route::get('/manage_bannerslides/show', [BannerSlidesController::class, 'show'])->name('show_bannerslides');
        Route::post('/manage_bannerslides/store', [BannerSlidesController::class, 'store'])->name('store_bannerslides');
        Route::post('/manage_bannerslides/update', [BannerSlidesController::class, 'update'])->name('update_bannerslides');
        Route::post('/manage_bannerslides/update_status', [BannerSlidesController::class, 'update_status'])->name('update_statusbannerslides');
        Route::post('/manage_bannerslides/delete', [BannerSlidesController::class, 'delete'])->name('delete_bannerslides');
        //Manage Link Terkait
        Route::get('/manage_relatedlinks/show', [RelatedLinksController::class, 'show'])->name('show_relatedlinks');
        Route::post('/manage_relatedlinks/store', [RelatedLinksController::class, 'store'])->name('store_relatedlinks');
        Route::post('/manage_relatedlinks/update', [RelatedLinksController::class, 'update'])->name('update_relatedlinks');
        Route::post('/manage_relatedlinks/update_status', [RelatedLinksController::class, 'update_status'])->name('update_statusrelatedlinks');
        Route::post('/manage_relatedlinks/delete', [RelatedLinksController::class, 'delete'])->name('delete_relatedlinks');
        //Manage Post Categories
        Route::get('/manage_postcategories/show', [PostCategoriesController::class, 'show'])->name('show_postcategories');
        Route::post('/manage_postcategories/store', [PostCategoriesController::class, 'store'])->name('store_postcategories');
        Route::post('/manage_postcategories/update', [PostCategoriesController::class, 'update'])->name('update_postcategories');
        Route::post('/manage_postcategories/update_status', [PostCategoriesController::class, 'update_status'])->name('update_statuspostcategories');
        //Manage Posts
        Route::get('/manage_posts/show', [PostsController::class, 'show'])->name('show_posts');
        Route::get('/manage_posts/show_gallery', [PostsController::class, 'show_gallery'])->name('show_gallery');
        Route::get('/manage_posts/get_slugpost', [PostsController::class, 'get_slugpost'])->name('get_slugpost');
        Route::get('/manage_posts/select2_category', [PostsController::class, 'select2_category'])->name('select2_category');
        Route::post('/manage_posts/store', [PostsController::class, 'store'])->name('store_posts');
        Route::post('/manage_posts/store_filegallery', [PostsController::class, 'store_filegallery'])->name('store_filegallery');
        Route::post('/manage_posts/update', [PostsController::class, 'update'])->name('update_posts');
        Route::post('/manage_posts/delete_filegallery', [PostsController::class, 'delete_filegallery'])->name('delete_filegallery');
        Route::post('/manage_posts/update_itemoptionselect2', [PostsController::class, 'update_itemoptionselect2'])->name('update_itemoptionselect2');
        Route::post('/manage_posts/update_status', [PostsController::class, 'update_status'])->name('update_statusposts');
        Route::post('/manage_posts/delete', [PostsController::class, 'delete'])->name('delete_posts');
        //Manage Roles
        Route::get('/manage_roles/show', [RolesController::class, 'show'])->name('show_roles');
        Route::post('/manage_roles/store', [RolesController::class, 'store'])->name('store_roles');
        Route::post('/manage_roles/update', [RolesController::class, 'update'])->name('update_roles');
        Route::get('/manage_roles/show_permissions', [RolesController::class, 'show_permissions'])->name('show_permissions_role');
        Route::get('/manage_roles/select2_permissions', [RolesController::class, 'select2_permissions'])->name('select2_permissions');
        Route::post('/manage_roles/store_permissionrole', [RolesController::class, 'store_permissionrole'])->name('store_permissionrole');
        Route::post('/manage_roles/update_permissionbyrole', [RolesController::class, 'update_permissionbyrole'])->name('update_permissionbyrole');
        //Manage Permissions
        Route::get('/manage_permissions/show', [PermissionsController::class, 'show'])->name('show_permissions');
        Route::post('/manage_permissions/store', [PermissionsController::class, 'store'])->name('store_permissions');
        Route::post('/manage_permissions/update', [PermissionsController::class, 'update'])->name('update_permissions');
        Route::get('/manage_permissions/select2_parentpermissions', [PermissionsController::class, 'select2_parentpermissions'])->name('select2_parentpermissions');
        //Manage Users
        Route::get('/manage_users/show', [UsersController::class, 'show'])->name('show_users');
        Route::get('/manage_users/selectpicker_role', [UsersController::class, 'selectpicker_role'])->name('selectpicker_role');
        Route::post('/manage_users/store', [UsersController::class, 'store'])->name('store_users');
        Route::post('/manage_users/update', [UsersController::class, 'update'])->name('update_users');
        Route::post('/manage_users/update_statususers', [UsersController::class, 'update_statususers'])->name('update_statususers');
        Route::post('/manage_users/reset_userpass', [UsersController::class, 'reset_userpass'])->name('reset_userpass');
        //Users Activity
        Route::get('/users_activity/show', [UsersActivityController::class, 'show'])->name('show_logs');
        Route::post('/users_activity/delete', [UsersActivityController::class, 'delete'])->name('delete_logs');
        //User Profil
        Route::get('/user_info', [CommonController::class, 'user_info'])->name('user_info');
        Route::post('/update_userprofile', [CommonController::class, 'update_userprofile'])->name('update_userprofile');
        Route::post('/update_userpassprofil', [CommonController::class, 'update_userpassprofil'])->name('update_userpassprofil');
        //Image Upload with Summernote Editor
        Route::post('/ajax_upload_imgeditor', [CommonController::class, 'upload_imgeditor'])->name('upload_imgeditor');
    });


    // Route::get('/site_info', [DashboardController::class, 'index'])->name('dashboard');
    // Route::get('/roles', [DashboardController::class, 'index'])->name('dashboard');
    // Route::get('/permissions', [DashboardController::class, 'index'])->name('dashboard');
});