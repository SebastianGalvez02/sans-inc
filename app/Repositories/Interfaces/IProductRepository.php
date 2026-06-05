<?php
namespace App\Repositories\Interfaces;
interface IProductRepository
{
    public function getAllActive();
    public function findActiveById(int $id);
    public function getByCategoryId(int $categoryId);
}
