<?php

namespace App\Http\Controllers;

use App\Models\Api;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function newsApi(Request $request){
        if($request->method() == Request::METHOD_POST){
            $source = $request->source;
            $splitInput = explode(':', $source);
            $source = trim($splitInput[0]);
            $data['source_name'] = $splitInput[1];
        }

        if(empty($source)){
            $source = 'cnn';
            $data['source_name'] = 'CNN';
            $data['source_id'] = $source;
        }

        $api = new Api();
        $data['news'] = $api->getNews($source);
        $data['news_sources'] = $this->allSources();
        return view('welcome', $data);
    }

    public function allSources(){
        $api = new Api();
        return $api->getAllSources();
    }
}
