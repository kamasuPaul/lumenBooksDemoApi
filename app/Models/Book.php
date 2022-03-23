<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model{
    use HasFactory;
    protected $with = ['authors'];
    protected $fillable = [
        'name', 'publisher', 'isbn', 'country', 'release_date', 'number_of_pages', 'url', 'media_type'
    ];
    //authors
    public function authors(){
        return $this->hasMany('App\Models\Author');
    }
    //comments
    public function comments(){
        return $this->hasMany(Comment::class);
    }
    public function characters(){
        return $this->belongsToMany(Character::class);
    }
}