<?php

namespace App\Http\Controllers;

use App\Jobs\ManageUrls;
use App\Models\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;

class UrlController extends Controller
{
    /**
     * Function that get the shortest url possible
     * 
     * @param Request $request
     * 
     * @return Response Json response
     */
    public function short_url(Request $request){
        $url = $request->get('url'); 

        $client = new Client();
        $request = $client->head($url);

        if( $request->getStatusCode() != 200 ) {
            return response()->json(["Error" => "The url provided does not work."]);
        }

        $urlModel = Url::where('original', $url)->first();

        //Check if the url is already stored
        if(!$urlModel){
            //Get the last redirected url
            $last_url = DB::table('urls')->latest('id')->first();
            if($last_url){
                $last_letters = explode('/',$last_url->redirection);
                $last_letter = $last_letters[1];
                $last_letter++;
                $redirect = 'localhost/'.$last_letter;
            }else {
                $redirect = 'localhost/a';
            }
            
            $urlModel['original'] = $url;
            $urlModel['redirection'] = $redirect;
            $urlModel['title'] = '';
            $urlModel['visits'] = 1;

            //Dispatch the job to get the title and save the record
            ManageUrls::dispatch($urlModel);

            return response()->json(['url_redirect' => $urlModel['redirection']]);
        }

        return response()->json(['url_redirect' => $urlModel->redirection]);       
    }
    

    /**
     * Function that returns a JSON with a ranking of the most visits websites
     * 
     * @return Response JSON response with the ranking
     */
    public function ranking(){
        $ranking = Url::select(['title', 'visits', 'redirection'])->orderBy('visits','desc')->limit(100)->get();

        return response()->json(['ranking' => $ranking]);
    }
}
