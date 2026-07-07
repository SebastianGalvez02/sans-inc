<?php

namespace Tests\Unit;

use App\DTOs\PublicationResponseDto;
use App\Models\Publication;
use App\Repositories\Interfaces\IPublicationRepository;
use App\Services\Implements\PublicationService;
use Illuminate\Support\Collection;
use Mockery;
use Tests\TestCase;

class PublicationServiceTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /**
     * Helper para construir un modelo Publication en memoria (sin tocar la BD).
     */
    private function makePublication(
        int $publicationId,
        int $productId,
        float $rating = 4.0,
        string $review = 'Buen producto',
        int $numberOfLikes = 0,
        int $userId = 1
    ): Publication {
        $publication = new Publication();
        $publication->publicationId = $publicationId;
        $publication->productId = $productId;
        $publication->rating = $rating;
        $publication->review = $review;
        $publication->numberOfLikes = $numberOfLikes;
        $publication->publicationDate = now();
        $publication->userId = $userId;
        $publication->active = true;

        return $publication;
    }

    public function test_list_publications_without_filters_returns_all_active()
    {
        // Arrange
        $repositoryMock = Mockery::mock(IPublicationRepository::class);

        $pub1 = $this->makePublication(1, 10);
        $pub2 = $this->makePublication(2, 11);

        $repositoryMock->shouldReceive('getAllActive')
            ->once()
            ->andReturn(collect([$pub1, $pub2]));

        $service = new PublicationService($repositoryMock);

        // Act
        $result = $service->listPublications();

        // Assert
        $this->assertInstanceOf(Collection::class, $result);
        $this->assertCount(2, $result);
        $this->assertInstanceOf(PublicationResponseDto::class, $result->first());
    }

    public function test_list_publications_with_product_id_calls_get_by_product_id()
    {
        // Arrange
        $repositoryMock = Mockery::mock(IPublicationRepository::class);

        $pub = $this->makePublication(3, 20);

        $repositoryMock->shouldReceive('getByProductId')
            ->with(20)
            ->once()
            ->andReturn(collect([$pub]));
        $repositoryMock->shouldNotReceive('getByCategoryId');
        $repositoryMock->shouldNotReceive('getAllActive');

        $service = new PublicationService($repositoryMock);

        // Act
        $result = $service->listPublications(productId: 20);

        // Assert
        $this->assertCount(1, $result);
        $this->assertEquals(20, $result->first()->productId);
    }

    public function test_list_publications_with_category_id_calls_get_by_category_id()
    {
        // Arrange
        $repositoryMock = Mockery::mock(IPublicationRepository::class);

        $pub1 = $this->makePublication(4, 30, review: 'Reseña categoría 1');
        $pub2 = $this->makePublication(5, 31, review: 'Reseña categoría 2');

        $repositoryMock->shouldReceive('getByCategoryId')
            ->with(7)
            ->once()
            ->andReturn(collect([$pub1, $pub2]));
        $repositoryMock->shouldNotReceive('getByProductId');
        $repositoryMock->shouldNotReceive('getAllActive');

        $service = new PublicationService($repositoryMock);

        // Act
        $result = $service->listPublications(categoryId: 7);

        // Assert
        $this->assertInstanceOf(Collection::class, $result);
        $this->assertCount(2, $result);
        $this->assertInstanceOf(PublicationResponseDto::class, $result->first());
        $this->assertEquals(30, $result->first()->productId);
        $this->assertEquals('Reseña categoría 1', $result->first()->review);
        $this->assertEquals(31, $result->last()->productId);
    }

    public function test_list_publications_with_category_id_returns_empty_collection_when_no_matches()
    {
        // Arrange
        $repositoryMock = Mockery::mock(IPublicationRepository::class);

        $repositoryMock->shouldReceive('getByCategoryId')
            ->with(99)
            ->once()
            ->andReturn(collect());

        $service = new PublicationService($repositoryMock);

        // Act
        $result = $service->listPublications(categoryId: 99);

        // Assert
        $this->assertInstanceOf(Collection::class, $result);
        $this->assertCount(0, $result);
    }
}
