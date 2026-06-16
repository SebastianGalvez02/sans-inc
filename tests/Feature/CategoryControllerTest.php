<?php

namespace Tests\Feature;

use App\DTOs\CategoryResponseDto;
use App\Services\Interfaces\ICategoryService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Mockery;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_get_categories_index_endpoint_returns_json_response()
    {
        $dto = new CategoryResponseDto(
            id: 1,
            name: 'Hardware',
            description: 'Physical products'
        );

        $serviceMock = $this->mock(ICategoryService::class);
        $serviceMock->shouldReceive('listCategories')
            ->once()
            ->andReturn(collect([$dto]));

        $response = $this->getJson('/api/categories');

        $response->assertStatus(200)
            ->assertJsonCount(1)
            ->assertJson([
                [
                    'id' => 1,
                    'name' => 'Hardware',
                    'description' => 'Physical products',
                ],
            ]);
    }

    public function test_get_category_show_endpoint_returns_json_response()
    {
        $dto = new CategoryResponseDto(
            id: 2,
            name: 'Software',
            description: 'Digital products'
        );

        $serviceMock = $this->mock(ICategoryService::class);
        $serviceMock->shouldReceive('getCategory')
            ->with(2)
            ->once()
            ->andReturn($dto);

        $response = $this->getJson('/api/categories/2');

        $response->assertStatus(200)
            ->assertJson([
                'id' => 2,
                'name' => 'Software',
                'description' => 'Digital products',
            ]);
    }

    public function test_get_category_show_returns_404_when_not_found()
    {
        $serviceMock = $this->mock(ICategoryService::class);
        $serviceMock->shouldReceive('getCategory')
            ->with(999)
            ->once()
            ->andThrow(new ModelNotFoundException('Category not found.'));

        $response = $this->getJson('/api/categories/999');

        $response->assertStatus(404)
            ->assertJson([
                'error' => 'Category not found.',
            ]);
    }

    public function test_store_category_endpoint_returns_created_category()
    {
        $dto = new CategoryResponseDto(
            id: 3,
            name: 'Accessories',
            description: 'Optional add-ons'
        );

        $serviceMock = $this->mock(ICategoryService::class);
        $serviceMock->shouldReceive('createCategory')
            ->once()
            ->andReturn($dto);

        $response = $this->postJson('/api/categories', [
            'name' => 'Accessories',
            'description' => 'Optional add-ons',
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'id' => 3,
                'name' => 'Accessories',
                'description' => 'Optional add-ons',
            ]);
    }

    public function test_store_category_validates_required_name()
    {
        $serviceMock = $this->mock(ICategoryService::class);
        $serviceMock->shouldNotReceive('createCategory');

        $response = $this->postJson('/api/categories', [
            'description' => 'Missing name',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name']);
    }

    public function test_update_category_endpoint_returns_updated_category()
    {
        $dto = new CategoryResponseDto(
            id: 4,
            name: 'Updated',
            description: 'Updated description'
        );

        $serviceMock = $this->mock(ICategoryService::class);
        $serviceMock->shouldReceive('updateCategory')
            ->with(4, [
                'name' => 'Updated',
                'description' => 'Updated description',
            ])
            ->once()
            ->andReturn($dto);

        $response = $this->putJson('/api/categories/4', [
            'name' => 'Updated',
            'description' => 'Updated description',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'id' => 4,
                'name' => 'Updated',
            ]);
    }

    public function test_delete_category_endpoint_returns_no_content()
    {
        $serviceMock = $this->mock(ICategoryService::class);
        $serviceMock->shouldReceive('deleteCategory')
            ->with(5)
            ->once();

        $response = $this->deleteJson('/api/categories/5');

        $response->assertStatus(204);
    }
}
