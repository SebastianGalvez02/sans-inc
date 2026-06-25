<?php

namespace App\Repositories\Interfaces;

interface IPublicationRepository
{
    public function getAllActive();
    
    public function findActiveById(int $id);
    
    public function getByProductId(int $productId);

    public function getByCategoryId(int $categoryId);

    public function getByUserId(int $userId);
    
    public function create(array $data);
    
    public function update(int $id, array $data);
}
