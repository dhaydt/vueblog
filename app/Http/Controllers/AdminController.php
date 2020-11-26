<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Category;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        if($user->userType == 'User'){ //bila kamu user biasa, anda akan disuruh login lagi
            return redirect('/login');
        }
        if($request->path() == 'login'){ //bila kamu admin atau editor, anda akan masuk ke homepage
            return redirect('/');
        }
        return view('welcome');
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
                if($user->userType == 'User'){
                    Auth::logout();
                    return response()->json([
                        'msg' => 'Gagal masuk controller'
                    ], 402);
                }
                return response()->json([
                    'msg' => 'berhasil login',
                    'user' => $user
                ]);
            } else {
                return response()->json([
                    'msg' => 'Password/Email salah controller'
                ], 403);
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
    return User::orderBy('id', 'desc')->get();
    }
    
    public function getRoles()
    {
        return Role::all();
    }

    // public function assignRole(Request $request)
    // {
    //     $this->validate($request, [
    //         'permission' => 'required',
    //         'id' => 'required',
    //     ]);
    //     return Role::where('id', $request->id)->update([
    //         'permission' => $request->permission,
    //     ]);
    // }

    public function createUser(Request $request){
        {
            $this->validate($request, [
            'FullName'  => 'required',
            'email'     => 'bail|required|email',
            'password'     => 'bail|required|min:2',
            'userType'     => 'required',
            ]);
            $password = bcrypt($request->password);
            $user = User::create([
                'FullName' => $request->FullName,
                'email' => $request->email,
                'password' => $password,
                'userType' => $request->userType,
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
        'userType' => 'required',
    ]);
    $password = bcrypt($request->password);
    return User::where('id', $request->id)->update([
        'FullName' => $request->FullName,
        'email' => $request->email,
        'password' => $password,
        'userType' => $request->userType,
    ]);
    }

    public function deleteUser(Request $request)
    {
            $this->validate($request, [
            'id' => 'required',
        ]);
        return User::where('id', $request->id)->delete();
    }
}