<?php

namespace App\Http\Controllers;

use App\Models\URL;
use Illuminate\Http\Request;
use App\Http\Requests\StoreRequest;
use App\Models\Dictionary;

class ShortenerController extends Controller
{

    protected $recentUrls = [];
    
    public function __construct(){
        $this->recentUrls = URL::limit(10)->orderBy("created_at", "desc")->get();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("welcome", ["urls" => $this->recentUrls]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        
        if(URL::where("url", $request->url)->exists()){
            
            $url = URL::where("url", $request->url)->first();
            $count =  URL::where("url", $request->url)->count();
            $word = $url->short_url . "-{$count}";

            $url = URL::create([
                "url" => $request->url,
                "description" => $request->description,
                "short_url" => $word
            ]);

        }else{
            $url = URL::create([
                "url" => $request->url,
                "description" => $request->description,
                "short_url" => Dictionary::inRandomOrder()->first()->word
            ]);
        }

        return view("welcome", ["urls" => $this->recentUrls, "shortUrl" => $url]);
    }

    /**
     *  Routes a short url to the url provided
     */
    public function router(URL $url)
    {
        $url->increment("hits");
        header("Location: {$url->url}");
        die;
    }
}
