<?php

namespace Tests\Feature;

use App\DTOs\ProductResponseDto;
use App\Services\Interfaces\IProductService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Mockery;
use Tests\TestCase;

/**
 * Clase para probar los endpoints HTTP de productos.
 *
 * Valida las respuestas JSON del listado, filtro por categoria,
 * consulta individual y manejo de productos inexistentes o inactivos.
 *
 * @author Equipo Sans Inc.
 * @version 1.0
 */
class ProductControllerTest extends TestCase
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
     * Verifica que el endpoint de listado retorne productos en JSON.
     */
    public function test_get_products_index_endpoint_returns_json_response()
    {
        // Arrange
        $dto1 = new ProductResponseDto(
            id: 1,
            name: 'Controller Product 1',
            description: 'Desc 1',
            price: 10.0,
            tag: 'Tag1',
            categoryId: 2,
            active: true
        );
        $dto2 = new ProductResponseDto(
            id: 2,
            name: 'Controller Product 2',
            description: 'Desc 2',
            price: 20.0,
            tag: 'Tag2',
            categoryId: 3,
            active: true
        );

        $serviceMock = $this->mock(IProductService::class);
        $serviceMock->shouldReceive('listAvailableProducts')
            ->once()
            ->andReturn(collect([$dto1, $dto2]));

        // Act
        $response = $this->getJson('/api/products');

        // Assert
        $response->assertStatus(200)
            ->assertJsonCount(2)
            ->assertJson([
                [
                    'id' => 1,
                    'name' => 'Controller Product 1',
                    'categoryId' => 2,
                    'active' => true,
                ],
                [
                    'id' => 2,
                    'name' => 'Controller Product 2',
                    'categoryId' => 3,
                    'active' => true,
                ]
            ]);
    }

    /**
     * Verifica que el endpoint de listado filtre productos por categoria.
     */
    public function test_get_products_index_with_category_id_filters_products()
    {
        // Arrange
        $dto = new ProductResponseDto(
            id: 5,
            name: 'Category Product',
            description: 'Desc',
            price: 15.0,
            tag: 'Tag',
            categoryId: 10,
            active: true
        );

        $serviceMock = $this->mock(IProductService::class);
        $serviceMock->shouldReceive('listProductsByCategory')
            ->with(10)
            ->once()
            ->andReturn(collect([$dto]));

        // Act
        $response = $this->getJson('/api/products?categoryId=10');

        // Assert
        $response->assertStatus(200)
            ->assertJsonCount(1)
            ->assertJson([
                [
                    'id' => 5,
                    'name' => 'Category Product',
                    'categoryId' => 10,
                    'active' => true,
                ]
            ]);
    }

    /**
     * Verifica que el endpoint de detalle retorne un producto en JSON.
     */
    public function test_get_product_show_endpoint_returns_json_response()
    {
        // Arrange
        $dto = new ProductResponseDto(
            id: 7,
            name: 'Show Product',
            description: 'Show Desc',
            price: 50.0,
            tag: 'ShowTag',
            categoryId: 4,
            active: true
        );

        $serviceMock = $this->mock(IProductService::class);
        $serviceMock->shouldReceive('getProductForReview')
            ->with(7)
            ->once()
            ->andReturn($dto);

        // Act
        $response = $this->getJson('/api/products/7');

        // Assert
        $response->assertStatus(200)
            ->assertJson([
                'id' => 7,
                'name' => 'Show Product',
                'categoryId' => 4,
                'active' => true,
            ]);
    }

    /**
     * Verifica que el endpoint de detalle retorne 404 si el producto no existe.
     */
    public function test_get_product_show_returns_404_when_inactive_or_not_found()
    {
        // Arrange
        $serviceMock = $this->mock(IProductService::class);
        $serviceMock->shouldReceive('getProductForReview')
            ->with(999)
            ->once()
            ->andThrow(new ModelNotFoundException("Product not found or is inactive."));

        // Act
        $response = $this->getJson('/api/products/999');

        // Assert
        $response->assertStatus(404)
            ->assertJson([
                'error' => 'Product not found or is inactive.'
            ]);
    }
}
