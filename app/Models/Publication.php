<?php

namespace App\Models;

class Publication
{
    protected $fillable = [
        'publicationId',
        'rating',
        'publicationDate',
        'userId',
        'productId',
        'numberOfLikes',
        'active'
    ];
    protected $casts = [
        'publicationDate' => 'datetime',
        'publicationId' => 'integer',
        'rating' => 'float',
        'userId' => 'integer',
        'productId' => 'integer',
        'numberOfLikes' => 'integer',
        'active' => 'boolean'
    ];

    public function getReview(){
        return $this->review;
    }
    public function getRating(){
        return $this->rating;
    }

//    lo que creo que como luciria la funcion review por ahora puede que no este correcto
//    public function review(string $text) {}


}
