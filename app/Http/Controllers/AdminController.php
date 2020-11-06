<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;

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

    public function getTag()
    {
    	return Tag::orderBy('id', 'desc')->get();
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
}
