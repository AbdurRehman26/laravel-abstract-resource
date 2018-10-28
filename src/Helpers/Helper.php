<?php
namespace Kazmi\Helpers;
use Image,Storage;

/**
 * @author Usaama Effendi <usaamaeffendi@gmail.com>
 */
class Helper {
    

    public static function cropImage($file, $details) {

        $imageFile = [];

        $extensions = !empty($details['extensions']) ? $details['extensions'] : [ 'jpg' , 'jpeg', 'png', 'gif', 'bmp', 'svg'];

        $path = !empty($details['path']) ? $details['path'] : '/';


        $thumb_width = !empty($details['thumb_width']) ? $details['thumb_width'] : config('app.uploads.images.thumbnails.width');
        $thumb_height = !empty($details['thumb_height']) ? $details['thumb_height'] : config('app.uploads.images.thumbnails.height');

        if(!$thumb_width){
            $thumb_width = 360;
        }

        if(!$thumb_height){
            $thumb_height = 200;
        }

        list($name, $ext) = explode('.', $file->hashName());
        if($file->extension() == 'gif'){
            $file->storeAs($path, $name.".".$file->extension());
            $file->storeAs($path, $name."@3x.".$file->extension());
            $file->storeAs($path, $name."@2x.".$file->extension());
            $file->storeAs($path, $name."@thumb.".$file->extension());

            $imageFile['file_name'] = $name;
            $imageFile['ext'] = $ext;
        }

        if (in_array($file->guessExtension(), $extensions)) {
            $image = Image::make($file);
            $width = $image->width();
            $height = $image->height();
            $store = Storage::put($path.'/'.$name.'@3x.'.$ext, $image->stream()->__toString());
            $store = Storage::put($path.'/'.$name.'@2x.'.$ext, $image->resize($width / 1.5, $height / 1.5)->stream()->__toString());
            $store = Storage::put($path.'/'.$name.'@thumb.'.$ext, $image->fit($thumb_width, $thumb_height, function($constraint) { $constraint->aspectRatio(); })->stream()->__toString());
            $store = Storage::put($path.'/'.$name.'.'.$ext, $image->resize($width / 3, $height / 3)->stream()->__toString());
            $imageFile['file_name'] = $name;
            $imageFile['ext'] = $ext;
        }
        return $imageFile; 
    }



    public static function customPagination($data, $paginate){

        $data['pagination'] = [];
        $data['pagination']['total'] = $paginate->total();
        $data['pagination']['current'] = $paginate->currentPage();
        $data['pagination']['first'] = 1;
        $data['pagination']['last'] = $paginate->lastPage();
        // $data['pagination']['from'] = $paginate->firstItem();
        // $data['pagination']['to'] = $paginate->lastItem();
        if($paginate->hasMorePages()) {
            if ( $paginate->currentPage() == 1) {
                $data['pagination']['previous'] = -1;
            } else {
                $data['pagination']['previous'] = $paginate->currentPage()-1;
            }
            $data['pagination']['next'] = $paginate->currentPage()+1;
        } else {
            $data['pagination']['previous'] = $paginate->currentPage()-1;
            $data['pagination']['next'] =  $paginate->lastPage();
        }
        if ($paginate->lastPage() > 1) {
            $data['pagination']['pages'] = range(1,$paginate->lastPage());
        } else {
            $data['pagination']['pages'] = [1];
        }
        return $data;
    }

}


