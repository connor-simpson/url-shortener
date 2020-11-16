<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class URL extends Model
{ 
    use HasFactory;
    
    protected $table = 'short_urls';
    protected $appends = ['link'];
    protected $fillable = ['description', 'url', 'short_url'];

    /**
     *  Appends the fully shortened link to the model
     */
    protected function getLinkAttribute()
    {
        return env("APP_URL") . "/s/{$this->short_url}";
    }
}
