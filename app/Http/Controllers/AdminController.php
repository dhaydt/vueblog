<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Category;
use App\Models\User;
use App\Models\Role;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Support\Facades\Log;
//use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        //first cek if who are loged in and admin..
        if(!Auth::check() && $request->path() != 'login'){ //akses ke halaman login jika gagal login
            return redirect('/login');
        }
        if (!Auth::check() && $request->path() == 'login') { //ika berhasil

            return view('welcome');
        }

        //if you login, check if u admin..
        $user = Auth::user();
        if($user->role->isAdmin == 0){ //bila kamu user biasa, anda akan disuruh login lagi
            return redirect('/login');
        }
        if($request->path() == 'login'){ //bila kamu admin atau editor, anda akan masuk ke homepage
            return redirect('/');
        }

        return $this->checkForPermisson($user, $request);

    }

    public function checkForPermisson($user, $request){
        $permission = json_decode($user->role->permission);

        $hasPermission = false;
        //if(!$hasPermission) return view('welcome');
        foreach($permission as $p){
            if($p->name == $request->path()){
                if($p->read){
                    $hasPermission = true;
                }
            }
        }

        if($hasPermission) return view('welcome');
        return view('notFound');
    }

    public function logout(){
        Auth::logout();
        return redirect('/login');
    }

    public function adminLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'bail|required|email',
            'password' => 'bail|required|min:2',
        ]);

        if(Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
            ])){
                $user = Auth::user();
                if($user->role->isAdmin == 0){
                    Auth::logout();
                    return response()->json([
                        'msg' => 'Gagal masuk controller'
                    ], 401);
                }
                return response()->json([
                    'msg' => 'berhasil login',
                    'user' => $user
                ]);
            } else {
                return response()->json([
                    'msg' => 'Password/Email salah controller'
                ], 402);
            };
    }

    public function addTag(Request $request)
    {
    	//menambah data tag
    $this->validate($request, [
        'tagName' => 'required'
    ]);
    return Tag::create([
        'tagName' => $request->tagName
    ]);
    }


    public function editTag(Request $request)
    {
    $this->validate($request, [
        'tagName' => 'required',
        'id' => 'required',
    ]);
    return Tag::where('id', $request->id)->update([
        'tagName' => $request->tagName,
    ]);
    }

    public function deleteTag(Request $request)
    {
        //validasi permintaan
        $this->validate($request, [
            'id' => 'required',
        ]);
        return Tag::where('id', $request->id)->delete();
    }

    public function getTag()
    {
    return Tag::orderBy('id', 'desc')->get();
    }

    public function upload(Request $request)
    {
        //validasi
        $this->validate($request, [
            'file' => 'required|mimes:jpeg,jpg,png',
        ]);
        $picName = time().'.'.$request->file->extension();
        $request->file->move(public_path('uploads'), $picName);
        return $picName;
    }

    public function deleteImage(Request $request)
    {
        $fileName = $request->imageName;
        $this->deleteFileFromServer($fileName);
        return 'done';
    }

    public function deleteFileFromServer($fileName)
    {
        $filePath = public_path().'/uploads/'.$fileName;
        if(file_exists($filePath)){
            @unlink($filePath);
        }
        return;
    }

    public function addCategory(Request $request)
    {
        $this->validate($request, [
        'categoryName'  => 'required',
        'iconImage'     => 'required',
        ]);
        return Category::create([
            'categoryName' => $request->categoryName,
            'iconImage' => $request->iconImage
        ]);

    }

    public function getCategory()
    {
        return Category::orderBy('id', 'desc')->get();
    }

    public function editCategory(Request $request)
    {
        $this->validate($request, [
        'categoryName' => 'required',
        'iconImage'     => 'required',
    ]);

    return Category::where('id', $request->id)->update([
        'categoryName' => $request->categoryName,
        'iconImage'     => $request->iconImage,
    ]);
    }

    public function deleteCategory(Request $request)
    {
            $this->validate($request, [
            'id' => 'required',
        ]);
        return Category::where('id', $request->id)->delete();
    }

    public function getUser()
    {
    return User::where('role_id', '!=', 'User')->get();
    }

    public function createUser(Request $request){
        {
            $this->validate($request, [
            'FullName'  => 'required',
            'email'     => 'bail|required|email',
            'password'     => 'bail|required|min:2',
            'role_id'     => 'required',
            ]);
            $password = bcrypt($request->password);
            $user = User::create([
                'FullName' => $request->FullName,
                'email' => $request->email,
                'password' => $password,
                'role_id' => $request->role_id,
            ]);
            return $user;

        }
    }

    public function editUser(Request $request)
    {
    $this->validate($request, [
        'FullName' => 'required',
        'id' => 'required',
        'email'     => 'bail|required|email',
        'password'     => 'min:2',
        'role_id' => 'required',
    ]);
    $password = bcrypt($request->password);
    return User::where('id', $request->id)->update([
        'FullName' => $request->FullName,
        'email' => $request->email,
        'password' => $password,
        'role_id' => $request->role_id,
    ]);
    }

    public function deleteUser(Request $request)
    {
            $this->validate($request, [
            'id' => 'required',
        ]);
        return User::where('id', $request->id)->delete();
    }

    public function getRoles()
    {
        return Role::all();
    }

    public function addRole(Request $request)
    {
        // validate request
        $this->validate($request, [
            'roleName' => 'required',
            'isAdmin' => 'required'
        ]);
        return Role::create([
            'roleName' => $request->roleName,
            'isAdmin' => $request->isAdmin,
        ]);
    }

    public function editRole(Request $request)
    {
        // validate request
        $this->validate($request, [
            'roleName' => 'required',
            'id'       => 'required',
        ]);
        return Role::where('id', $request->id)->update([
            'roleName' => $request->roleName,
            'id' => $request->id,
        ]);
    }

    public function deleteRole(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);
        return Role::where('id', $request->id)->delete();
    }

    public function assignRole(Request $request)
    {
        $this->validate($request, [
            'permission' => 'required',
            'id'    => 'required'
        ]);
        return Role::where('id', $request->id)->update([
            'permission' => $request->permission,
        ]);
    }
}
