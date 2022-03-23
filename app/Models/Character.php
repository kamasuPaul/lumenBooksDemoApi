<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'book_id','born','died','culture','gender','url'
    ];
    protected $appends = [
        'age'
    ];

    public function book()
    {
        return $this->belongsToMany(Book::class);
    }
    //create mutator for aliases
    public function setAliasesAttribute($value)
    {
        $this->attributes['aliases'] = json_encode($value);
    }
    //create accessor for aliases
    public function getAliasesAttribute($value)
    {
        return json_decode($value);
    }
    // calculate age from born date
    public function getAgeAttribute()
    {
        //return date with age in years and age in months
        return [
            'years' => date_diff(date_create($this->born), date_create('today'))->y,
            'months' => date_diff(date_create($this->born), date_create('today'))->m,
        ];
    }
}