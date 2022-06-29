<?php

namespace App\Http\Controllers;

use App\Models\Url;
use Illuminate\Http\Request;

class RouteController extends Controller
{

    /**
     * Function that redirect to the correct url.
     * 
     * @param String local url
     * 
     * @return Redirector redirect to the original url
     */
    public function index($url){
        $urlModel = Url::where('redirection', 'localhost/'.$url)->first();

        if(!$urlModel){
            abort(404);
        }

        //Update the number of visits
        $urlModel->visits = $urlModel->visits +1;

        $urlModel->save();

        return redirect()->away('https://'.$urlModel->original);
    }
}
