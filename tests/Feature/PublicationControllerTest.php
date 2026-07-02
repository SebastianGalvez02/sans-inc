<?php

namespace Tests\Feature;

use App\DTOs\PublicationResponseDto;
use App\Models\Category;
use App\Models\Product;
use App\Services\Interfaces\IPublicationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class PublicationControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /**
     * Helper para instanciar un PublicationResponseDto de prueba.
     */
    private function makePublicationDto(
        int $publicationId,
        int $productId,
        float $rating = 4.5,
        string $review = 'Muy buen producto',
        int $numberOfLikes = 0,
        int $userId = 1
    ): PublicationResponseDto {
        return new PublicationResponseDto(
            publicationId: $publicationId,
            productId: $productId,
            rating: $rating,
            review: $review,
            numberOfLikes: $numberOfLikes,
            publicationDate: now()->toIso8601String(),
            userId: $userId,
        );
    }

    public function test_get_publications_index_endpoint_returns_json_response()
    {
        // Arrange
        $dto = $this->makePublicationDto(1, 10);

        $serviceMock = $this->mock(IPublicationService::class);
        $serviceMock->shouldReceive('listPublications')
            ->with(null, null)
            ->once()
            ->andReturn(collect([$dto]));

        // Act
        $response = $this->getJson('/api/publications');

        // Assert
        $response->assertStatus(200)
            ->assertJsonCount(1)
            ->assertJson([
                [
                    'publicationId' => 1,
                    'productId' => 10,
                ]
            ]);
    }

    public function test_get_publications_index_with_category_id_filters_publications()
    {
        // Arrange: categoryId debe existir en BD porque el controller valida
        // con la regla 'exists:categories,categoryId'.
        $category = Category::create([
            'categoryName' => 'Limpieza',
            'categoryDescription' => 'Productos de limpieza',
        ]);

        $dto = $this->makePublicationDto(5, 20, review: 'Publicación filtrada por categoría');

        $serviceMock = $this->mock(IPublicationService::class);
        $serviceMock->shouldReceive('listPublications')
            ->with(null, $category->categoryId)
            ->once()
            ->andReturn(collect([$dto]));

        // Act
        $response = $this->getJson('/api/publications?categoryId=' . $category->categoryId);

        // Assert
        $response->assertStatus(200)
            ->assertJsonCount(1)
            ->assertJson([
                [
                    'publicationId' => 5,
                    'productId' => 20,
                    'review' => 'Publicación filtrada por categoría',
                ]
            ]);
    }

    public function test_get_publications_index_with_nonexistent_category_id_returns_422()
    {
        // Arrange: no se crea ninguna categoría, por lo que el id 999 no existe.
        $serviceMock = $this->mock(IPublicationService::class);
        $serviceMock->shouldReceive('listPublications')->never();

        // Act
        $response = $this->getJson('/api/publications?categoryId=999');

        // Assert
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['categoryId']);
    }

    public function test_get_publications_index_with_product_id_and_category_id_returns_422()
    {
        // Arrange
        $category = Category::create([
            'categoryName' => 'Uso_Personal',
            'categoryDescription' => 'Higiene personal',
        ]);

        $product = Product::create([
            'categoryId' => $category->categoryId,
            'name' => 'Producto de prueba',
            'description' => 'Desc',
            'price' => 9.99,
            'tag' => 'Tag',
            'active' => true,
        ]);

        $serviceMock = $this->mock(IPublicationService::class);
        $serviceMock->shouldReceive('listPublications')->never();

        // Act
        $response = $this->getJson(
            '/api/publications?productId=' . $product->productId . '&categoryId=' . $category->categoryId
        );

        // Assert
        $response->assertStatus(422)
            ->assertJson([
                'error' => 'No puedes filtrar por productId y categoryId al mismo tiempo.',
            ]);
    }

    public function test_get_publications_index_with_product_id_filters_publications()
    {
        // Arrange
        $category = Category::create([
            'categoryName' => 'Aroma',
            'categoryDescription' => 'Productos con fragancia',
        ]);

        $product = Product::create([
            'categoryId' => $category->categoryId,
            'name' => 'Producto A',
            'description' => 'Desc',
            'price' => 5.0,
            'tag' => 'Tag',
            'active' => true,
        ]);

        $dto = $this->makePublicationDto(3, $product->productId, review: 'Filtrada por producto');

        $serviceMock = $this->mock(IPublicationService::class);
        $serviceMock->shouldReceive('listPublications')
            ->with($product->productId, null)
            ->once()
            ->andReturn(collect([$dto]));

        // Act
        $response = $this->getJson('/api/publications?productId=' . $product->productId);

        // Assert
        $response->assertStatus(200)
            ->assertJsonCount(1)
            ->assertJson([
                [
                    'publicationId' => 3,
                    'productId' => $product->productId,
                ]
            ]);
    }
}
