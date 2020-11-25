<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;
use App\Models\Category;
use App\Models\User;
use App\Models\Role;

class AdminController extends Controller
{
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
            'email'     => 'required',//'bail|required|email',
            'sandi'     => 'required',//'bail|required|min:2',
            'userType'     => 'required',
            ]);
            //$password = bcrypt($request->password);
            $user = User::create([
                'FullName' => $request->FullName,
                'email' => $request->email,
                'sandi' => $request->sandi,
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
        'email' => 'required',
        'sandi' => 'required',
        'userType' => 'required',
    ]);
    return User::where('id', $request->id)->update([
        'FullName' => $request->FullName,
        'email' => $request->email,
        'sandi' => $request->sandi,
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