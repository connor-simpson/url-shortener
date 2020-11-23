<?php

namespace App\Http\Controllers;

use App\Models\URL;
use Illuminate\Http\Request;
use App\Http\Requests\StoreRequest;
use App\Models\Dictionary;
use Illuminate\Support\Str;

class ShortenerController extends Controller
{

    protected $recentUrls = [];
    protected $dictionary = [];
    
    public function __construct(){
        $this->recentUrls = URL::limit(10)->orderBy("created_at", "desc")->get();
        $this->dictionary = Dictionary::where("used", 0)->get();
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("welcome", ["urls" => $this->recentUrls, "dictionary" => $this->dictionary]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {



        /**
         *  If the user has selected a shortcode from the dropdown use that.
         *  App\Http\Requests\StoreRequest will check to see if that shortcode has been used / exists, and the collection provided by this controller will only provide unused words on the view.
         *  
         *  If the user has entered a custom shortcode, App\Http\Requests\StoreRequest will check to see if it is unique against the current list of short URLs
         */
        if($request->custom_shortcode){
            $word = $request->custom_shortcode;
            
            /**
             *  The person is a bit of a smart ass, and uses a word in the dictionary, check for it and make it used.
             */
            if(Dictionary::where("word", $word)->exists()){
                $word = Dictionary::where("word", $word)->first();
                $word->used = 1;
                $word->save();
                $word = $word->word;
            }

        }else{
            if($request->shortcode){
                $word = Dictionary::find($request->shortcode);
                $word->used = 1;
                $word->save();
                $word = $word->word;
            }else{
                /**
                 *  If the words in the dictionary have all been used up, create a small randomly generated string.
                 */
                if(Dictionary::where("used", 0)->count() !== 0){

                    /**
                     *  Get a random word from the dictionary
                     */
                    $word = Dictionary::inRandomOrder()->first();
                    $word->used = 1;
                    $word->save();
                    $word = $word->word;

                }else{
                    /**
                     *  Create a small randomly generated string.
                     */
                    $word = Str::random(4);
                }
            }
        }
        

        $url = URL::create([
            "url" => $request->url,
            "description" => $request->description,
            "short_url" => $word
        ]);
      

        $this->dictionary = Dictionary::where("used", 0)->get();
        $this->recentUrls = URL::limit(10)->orderBy("created_at", "desc")->get();

        return view("welcome", ["urls" => $this->recentUrls,  "dictionary" => $this->dictionary, "shortUrl" => $url]);
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
