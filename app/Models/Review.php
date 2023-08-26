<?php

namespace App\Models;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use Searchable;

    use HasFactory;

    protected $fillable = ['restaurantName', 'location', 'detailedReview', 'user_id', 'image'];

    public function toSearchableArray(){ //Fixed or, Pre-defined function
        return [
            'location' => $this-> location,
            'restaurantName'=> $this-> restaurantName,
            'detailedReview'=> $this-> detailedReview,
        ];
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id'); //('class it belongs to', 'column that powers the lookup')
    }
}
