<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Snack1Controller;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\SnackController;
use App\Http\Controllers\LikeController;
use App\Http\Middleware\LoginMemberCheck;
use App\Http\Middleware\AdministratorCheck;
use App\Http\Middleware\SnackSuggest;
use App\Http\Middleware\LikeProcess;
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

Route::get('/', function () {
    return view('welcome');
});

//2023.3.6 mypage にアクセスするものには、ミドルウェアでお菓子のsugestをするか？？
Route::get('mypage/login',[Snack1Controller::class,'login_index']);
Route::post('mypage/home',[Snack1Controller::class,'login'])->middleware(SnackSuggest::class);
Route::get('mypage/home',[Snack1Controller::class,'mypage_index'])->middleware(LoginMemberCheck::class)->middleware(SnackSuggest::class);

Route::get('member/add',[MemberController::class,'add']);
Route::post('member/add',[MemberController::class,'create']);

Route::get('mypage/member_delete',[MemberController::class,'delete_index'])->middleware(LoginMemberCheck::class);
Route::post('mypage/member_delete',[MemberCOntroller::class,'delete']);

Route::get('mypage/member_edit',[MemberController::class,'edit_index'])->middleware(LoginMemberCheck::class);
Route::post('mypage/member_edit',[MemberController::class,'edit']);

Route::get('mypage/member_pass_change',[MemberController::class,'pass_change_index'])->middleware(LoginMemberCheck::class);
Route::post('mypage/member_pass_change',[MemberController::class,'pass_change']);

Route::get('mypage/search',[SnackController::class,'get_search'])->middleware(LoginMemberCheck::class)->middleware(SnackSuggest::class);
Route::post('mypage/search',[SnackController::class,'search'])->middleware(SnackSuggest::class);

Route::get('mypage/like_search',[SnackController::class,'like_search'])->middleware(LoginMemberCheck::class)->middleware(SnackSuggest::class);
Route::post('mypage/like_search',[SnackController::class,'like_search'])->middleware(SnackSuggest::class);

Route::get('mypage/recomend_search',[SnackController::class,'search'])->middleware(LoginMemberCheck::class)->middleware(SnackSuggest::class);
Route::post('mypage/recomend_search',[SnackController::class,'recomend_search'])->middleware(SnackSuggest::class);

Route::get('mypage/recomender_search',[SnackController::class,'recomend_search'])->middleware(LoginMemberCheck::class)->middleware(SnackSuggest::class);

Route::get('mypage/recomend_add',[SnackController::class,'add'])->middleware(LoginMemberCheck::class);
Route::post('mypage/recomend_add',[SnackController::class,'create']);

//2023.3.6 ここ改良の余地あり
Route::get('mypage/delete',[SnackController::class,'delete_index'])->middleware(LoginMemberCheck::class)->middleware(SnackSuggest::class);
Route::post('mypage/delete',[SnackController::class,'delete'])->middleware(SnackSuggest::class);

Route::get('mypage/snack_edit',[SnackController::class,'edit_index'])->middleware(LoginMemberCheck::class);
Route::post('mypage/snack_edit',[SnackController::class,'edit']);

//2023.3.6 連続クリックを避ける方法を考える。
Route::get('mypage/like',[LikeController::class,'like_add_delete'])->middleware(LoginMemberCheck::class)->middleware(LikeProcess::class)->middleware(SnackSuggest::class);

Route::get('administrator/index',[Snack1Controller::class,'administrator_index'])->middleware(AdministratorCheck::class);

Route::post('administrator/home1',[Snack1Controller::class,'administrator_1']);
Route::get('administrator/home1',[Snack1Controller::class,'administrator_1_1'])->middleware(AdministratorCheck::class);
Route::get('administrator/home2',[Snack1Controller::class,'administrator_2'])->middleware(AdministratorCheck::class);

Route::get('administrator/snack',[Snack1Controller::class,'get_administrator_snack'])->middleware(AdministratorCheck::class);
Route::post('administrator/snack',[Snack1Controller::class,'administrator_snack']);

Route::get('administrator/member',[Snack1Controller::class,'get_administrator_member'])->middleware(AdministratorCheck::class);
Route::post('administrator/member',[Snack1Controller::class,'administrator_member']);

Route::post('administrator/snack_limit',[Snack1Controller::class,'snack_limit']);
Route::post('administrator/snack_unlimit',[Snack1Controller::class,'snack_unlimit']);


Route::post('administrator/member_limit',[Snack1Controller::class,'member_limit']);
Route::post('administrator/member_unlimit',[Snack1Controller::class,'member_unlimit']);
Route::get('administrator/member_limit',[Snack1Controller::class,'get_administrator_member']);
Route::get('administrator/member_unlimit',[Snack1Controller::class,'get_administrator_member']);

