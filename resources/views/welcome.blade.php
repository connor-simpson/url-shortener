<!DOCTYPE html>
<html>
    <head>
        <title>URL Shortener</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        <link rel="stylesheet" href="{{ mix('/css/app.css') }}" />
    </head>

    <body>
        <div class="white-wrapper">
            <div class="container">
                <div class="row mb-2">
                    <div class="col-12 text-center">
                        <img src="images/logo.png" class="img-fluid logo"  />
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6  offset-lg-3">
                        <div class="card">
                            <form class="card-body" method="post">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <strong>You have some errors:</strong>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </div>
                                @endif
                                @csrf
                                <input type="text" class="form-control mb-2" placeholder="Paste your URL in here..." name="url" />
                            
                                <button class="btn btn-block btn-primary" type="submit">Shorten</button>


                                
                                @isset($shortUrl)
                                    <div class="alert alert-primary mb-0 mt-2">
                                        <strong>Shortened successfully!</strong><br />
                                        Your new URL is <a href="{{$shortUrl->link}}">{{$shortUrl->link}}</a>
                                    </div>
                                @endisset

                                <a href="#" data-toggle="collapse" data-target="#url-options" class="d-block text-center"><small>Customise URL</small></a>
                                <div class="collapse mt-2" id="url-options">
                                    <div class="card card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <h5 class="text-disabled">Customise URL</h5>
                                            </div>
                                            <div class="col-12">
                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon2">{{env("APP_URL")}}/s/</span>
                                                    </div>
                                                    <input type="text" class="form-control" placeholder="Custom short code (optional)" name ="custom_shortcode" />
                                                    
                                                </div>
                                            </div>
                                            <div class="col-12">                             

                                            @if(count($dictionary) !== 0)
                                            <select class="form-control mb-2" name="shortcode">
                                                <option disabled selected>Select a short code (optional)</option>
                                                @foreach($dictionary as $word)
                                                <option value="{{$word->id}}">{{$word->word}}</option>
                                                @endforeach
                                            </select>
                                            @endif
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <textarea class="form-control mb-2" placeholder="What is this link? (optional)" name="description"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="grey-wrapper">
            <div class="container">
                <h1>Recent Links</h1>
                <ul class="list-group">
                    @if(count($urls) === 0)
                        There isn't any URLs been shortened yet.
                    @endif
                    @foreach($urls as $url)
                        <li class="list-group-item">
                            <p class="mb-0"><a href="{{$url->link}}">{{$url->link}}</a></p>
                            <p class="mb-0 small"><span class="mr-3">{{$url->hits}} hits</span> <span class="mr-3">{{$url->url}}</span> <span>Created {{$url->created_at->diffForHumans()}}</span></p>
                            @if($url->description)
                                <p class="mb-0 text-muted">{{$url->description}}</p>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </body>
</html>