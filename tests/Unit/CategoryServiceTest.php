<?php

namespace Tests\Unit;

use App\DTOs\CategoryResponseDto;
use App\Models\Category;
use App\Repositories\Interfaces\ICategoryRepository;
use App\Services\Implements\CategoryService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use Mockery;
use Tests\TestCase;

class CategoryServiceTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_list_categories_returns_mapped_dtos()
    {
        $repositoryMock = Mockery::mock(ICategoryRepository::class);

        $category = new Category();
        $category->categoryId = 1;
        $category->categoryName = 'Hardware';
        $category->categoryDescription = 'Physical products';

        $repositoryMock->shouldReceive('getAll')
            ->once()
            ->andReturn(collect([$category]));

        $service = new CategoryService($repositoryMock);

        $result = $service->listCategories();

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertCount(1, $result);
        $this->assertInstanceOf(CategoryResponseDto::class, $result->first());
        $this->assertEquals(1, $result->first()->id);
        $this->assertEquals('Hardware', $result->first()->name);
    }

    public function test_get_category_returns_mapped_dto_when_found()
    {
        $repositoryMock = Mockery::mock(ICategoryRepository::class);

        $category = new Category();
        $category->categoryId = 2;
        $category->categoryName = 'Software';
        $category->categoryDescription = 'Digital products';

        $repositoryMock->shouldReceive('findById')
            ->with(2)
            ->once()
            ->andReturn($category);

        $service = new CategoryService($repositoryMock);

        $result = $service->getCategory(2);

        $this->assertInstanceOf(CategoryResponseDto::class, $result);
        $this->assertEquals(2, $result->id);
        $this->assertEquals('Software', $result->name);
    }

    public function test_get_category_throws_exception_when_not_found()
    {
        $repositoryMock = Mockery::mock(ICategoryRepository::class);
        $repositoryMock->shouldReceive('findById')
            ->with(99)
            ->once()
            ->andReturn(null);

        $service = new CategoryService($repositoryMock);

        $this->expectException(ModelNotFoundException::class);
        $this->expectExceptionMessage('Category not found.');

        $service->getCategory(99);
    }

    public function test_create_category_returns_created_dto()
    {
        $repositoryMock = Mockery::mock(ICategoryRepository::class);

        $category = new Category();
        $category->categoryId = 3;
        $category->categoryName = 'Accessories';
        $category->categoryDescription = 'Optional add-ons';

        $repositoryMock->shouldReceive('create')
            ->with([
                'categoryName' => 'Accessories',
                'categoryDescription' => 'Optional add-ons',
            ])
            ->once()
            ->andReturn($category);

        $service = new CategoryService($repositoryMock);

        $result = $service->createCategory([
            'name' => 'Accessories',
            'description' => 'Optional add-ons',
        ]);

        $this->assertEquals(3, $result->id);
        $this->assertEquals('Accessories', $result->name);
    }

    public function test_update_category_returns_updated_dto()
    {
        $repositoryMock = Mockery::mock(ICategoryRepository::class);

        $category = new Category();
        $category->categoryId = 4;
        $category->categoryName = 'Old name';
        $category->categoryDescription = 'Old description';

        $updatedCategory = new Category();
        $updatedCategory->categoryId = 4;
        $updatedCategory->categoryName = 'New name';
        $updatedCategory->categoryDescription = 'New description';

        $repositoryMock->shouldReceive('findById')
            ->with(4)
            ->once()
            ->andReturn($category);
        $repositoryMock->shouldReceive('update')
            ->with($category, [
                'categoryName' => 'New name',
                'categoryDescription' => 'New description',
            ])
            ->once()
            ->andReturn($updatedCategory);

        $service = new CategoryService($repositoryMock);

        $result = $service->updateCategory(4, [
            'name' => 'New name',
            'description' => 'New description',
        ]);

        $this->assertEquals(4, $result->id);
        $this->assertEquals('New name', $result->name);
    }

    public function test_delete_category_delegates_to_repository()
    {
        $repositoryMock = Mockery::mock(ICategoryRepository::class);

        $category = new Category();
        $category->categoryId = 5;
        $category->categoryName = 'Retired';

        $repositoryMock->shouldReceive('findById')
            ->with(5)
            ->once()
            ->andReturn($category);
        $repositoryMock->shouldReceive('delete')
            ->with($category)
            ->once();

        $service = new CategoryService($repositoryMock);

        $service->deleteCategory(5);

        $this->assertTrue(true);
    }
}
