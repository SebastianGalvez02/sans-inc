<?php

namespace App\Models;

class Publication
{
    protected $fillable = [
        'publicationId',
        'Calification',
        'publicationDate',
        'userId',
        'productId',
        'review',
    ];
    protected $casts = [
        'publicationDate' => 'datetime',
        'calification' => 'float',
        'userId' => 'integer',
        'productId' => 'integer',
    ];

    public function getReview(){
        return $this->review;
    }
    public function getCalification(){
        return $this->calification;
    }
    

}
