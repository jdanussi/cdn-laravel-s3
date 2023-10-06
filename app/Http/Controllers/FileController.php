<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function index()
    {
        return view('file');
    }

    public function store(Request $request)
    {
        if($request->hasFile('file_upload')) {

            //validate
            $request->validate([
                //'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'file.*' => 'required|file|mimes:ppt,pptx,doc,docx,xls,xlsx|max:204800',
            ]);
 
            //get filename with extension
            $filenamewithextension = $request->file('file_upload')->getClientOriginalName();
     
            //get filename without extension
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
     
            //get file extension
            $extension = $request->file('file_upload')->getClientOriginalExtension();
     
            //filename to store
            //$white_label = 'white_label1';
            $white_label = 'white_label2';
            $filenametostore = $white_label.'/'.$filename.'_'.time().'.'.$extension;
     
            //Upload File to s3
            Storage::disk('s3')->put($filenametostore, fopen($request->file('file_upload'), 'r+'), 'public');
     
            //Store $filenametostore in the database

            $url = Storage::disk('s3')->url($filenametostore);
            //return redirect('upload')->with('success', 'File uploaded successfully.');
            return redirect('upload')->with('success', $url);
        }
    }
}
