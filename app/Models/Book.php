<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model{
    protected $fillable = [
        'name', 'publisher', 'isbn', 'country', 'release_date', 'number_of_pages', 'url', 'media_type'
    ];
}