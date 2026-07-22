<?php

namespace Tests\Unit;

use App\DTOs\ProductResponseDto;
use App\Models\Product;
use App\Repositories\Interfaces\IProductRepository;
use App\Services\Implements\ProductService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use Mockery;
use Tests\TestCase;

/**
 * Clase para probar la logica de negocio de productos.
 *
 * Valida que ProductService consulte el repositorio correcto y convierta
 * los modelos Product en ProductResponseDto.
 *
 * @author Equipo Sans Inc.
 * @version 1.0
 */
class ProductServiceTest extends TestCase
{
    /**
     * Cierra los mocks creados durante cada prueba.
     */
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /**
     * Verifica que el servicio liste productos activos como DTOs.
     */
    public function test_list_available_products_returns_mapped_dtos()
    {
        // Arrange
        $repositoryMock = Mockery::mock(IProductRepository::class);

        $product1 = new Product();
        $product1->productId = 1;
        $product1->name = 'Product A';
        $product1->description = 'Desc A';
        $product1->price = 10.50;
        $product1->tag = 'Tag A';
        $product1->categoryId = 2;
        $product1->active = true;

        $product2 = new Product();
        $product2->productId = 2;
        $product2->name = 'Product B';
        $product2->description = 'Desc B';
        $product2->price = 20.00;
        $product2->tag = 'Tag B';
        $product2->categoryId = 3;
        $product2->active = true;

        $repositoryMock->shouldReceive('getAllActive')
            ->once()
            ->andReturn(collect([$product1, $product2]));

        $service = new ProductService($repositoryMock);

        // Act
        $result = $service->listAvailableProducts();

        // Assert
        $this->assertInstanceOf(Collection::class, $result);
        $this->assertCount(2, $result);
        $this->assertInstanceOf(ProductResponseDto::class, $result->first());
        $this->assertEquals(1, $result->first()->id);
        $this->assertEquals('Product A', $result->first()->name);
        $this->assertEquals(10.50, $result->first()->price);
        $this->assertEquals(2, $result->first()->categoryId);
        $this->assertTrue($result->first()->active);
    }

    /**
     * Verifica que el servicio obtenga un producto activo como DTO.
     */
    public function test_get_product_for_review_returns_mapped_dto_when_found()
    {
        // Arrange
        $repositoryMock = Mockery::mock(IProductRepository::class);

        $product = new Product();
        $product->productId = 42;
        $product->name = 'Reviewable Product';
        $product->description = 'Reviewable Desc';
        $product->price = 99.99;
        $product->tag = 'ReviewTag';
        $product->categoryId = 5;
        $product->active = true;

        $repositoryMock->shouldReceive('findActiveById')
            ->with(42)
            ->once()
            ->andReturn($product);

        $service = new ProductService($repositoryMock);

        // Act
        $result = $service->getProductForReview(42);

        // Assert
        $this->assertInstanceOf(ProductResponseDto::class, $result);
        $this->assertEquals(42, $result->id);
        $this->assertEquals('Reviewable Product', $result->name);
        $this->assertEquals(5, $result->categoryId);
        $this->assertTrue($result->active);
    }

    /**
     * Verifica que el servicio lance excepcion cuando el producto no existe.
     */
    public function test_get_product_for_review_throws_exception_when_not_found_or_inactive()
    {
        // Arrange
        $repositoryMock = Mockery::mock(IProductRepository::class);
        $repositoryMock->shouldReceive('findActiveById')
            ->with(99)
            ->once()
            ->andReturn(null);

        $service = new ProductService($repositoryMock);

        // Assert
        $this->expectException(ModelNotFoundException::class);
        $this->expectExceptionMessage("Product not found or is inactive.");

        // Act
        $service->getProductForReview(99);
    }

    /**
     * Verifica que el servicio liste productos activos por categoria.
     */
    public function test_list_products_by_category_returns_mapped_dtos()
    {
        // Arrange
        $repositoryMock = Mockery::mock(IProductRepository::class);

        $product = new Product();
        $product->productId = 5;
        $product->name = 'Category Product';
        $product->description = 'Category Desc';
        $product->price = 15.00;
        $product->tag = 'CatTag';
        $product->categoryId = 10;
        $product->active = true;

        $repositoryMock->shouldReceive('getByCategoryId')
            ->with(10)
            ->once()
            ->andReturn(collect([$product]));

        $service = new ProductService($repositoryMock);

        // Act
        $result = $service->listProductsByCategory(10);

        // Assert
        $this->assertInstanceOf(Collection::class, $result);
        $this->assertCount(1, $result);
        $this->assertInstanceOf(ProductResponseDto::class, $result->first());
        $this->assertEquals(5, $result->first()->id);
        $this->assertEquals(10, $result->first()->categoryId);
    }
}
