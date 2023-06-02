<?php

namespace App\Http\Controllers;

use App\Models\Images;
use Illuminate\Http\Request;


class ImageController extends Controller
{
    //store images in database
    public function store( Request $request){
        $request->validate([
            'image' => 'required',
        ]);

        $image = time().'.'.$request->file('image')->getClientOriginalName();

        $request->file('image')->move(
            public_path('/images') , $image
        );
        // add name of image at database
        $image_model = new Images();
        $image_model->images = $image;
        $image_model->save();
       // return json response
        return response()->json(['Image saved successfully !']);



    }
}
