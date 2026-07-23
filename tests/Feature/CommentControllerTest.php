<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Product;
use App\Models\Publication;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class CommentControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    private Publication $publication;

    private string $token;

    protected function setUp(): void
    {
        parent::setUp();

        $role = Role::create([
            'role_name' => 'client',
            'description' => 'Client',
        ]);

        $this->user = User::create([
            'role_id' => $role->id,
            'name' => 'CommentAuthor',
            'email' => 'comments@example.com',
            'password' => bcrypt('Secret1!'),
        ]);

        $category = Category::create([
            'categoryName' => 'Comments category',
            'categoryDescription' => 'Category used in comment tests',
        ]);

        $product = Product::create([
            'categoryId' => $category->categoryId,
            'name' => 'Comments product',
            'description' => 'Product used in comment tests',
            'price' => 10,
            'tag' => 'comments',
            'active' => true,
        ]);

        $this->publication = $this->createPublication($product);
        $this->token = JWTAuth::fromUser($this->user);
    }

    public function test_authenticated_user_can_create_comment(): void
    {
        $this->withHeaders($this->authHeaders())
            ->postJson('/api/comments', [
                'publicationId' => $this->publication->publicationId,
                'content' => 'Este es un comentario de prueba.',
            ])
            ->assertCreated()
            ->assertJsonFragment([
                'content' => 'Este es un comentario de prueba.',
                'userId' => $this->user->id,
                'publicationId' => $this->publication->publicationId,
            ]);

        $this->assertDatabaseHas('comments', [
            'content' => 'Este es un comentario de prueba.',
            'userId' => $this->user->id,
            'publicationId' => $this->publication->publicationId,
            'deleted_at' => null,
        ]);
    }

    public function test_comments_can_be_listed(): void
    {
        $this->createComment('Primer comentario');
        $this->createComment('Segundo comentario');

        $this->getJson('/api/comments')
            ->assertOk()
            ->assertJsonCount(2)
            ->assertJsonFragment(['content' => 'Primer comentario'])
            ->assertJsonFragment(['content' => 'Segundo comentario']);
    }

    public function test_comments_can_be_filtered_by_publication(): void
    {
        $otherPublication = $this->createPublication($this->publication->product);

        $this->createComment('Comentario de la publicación principal');
        $this->createComment(
            'Comentario de otra publicación',
            $otherPublication
        );

        $this->getJson(
            '/api/comments?publicationId='.$this->publication->publicationId
        )
            ->assertOk()
            ->assertJsonCount(1)
            ->assertJsonFragment([
                'content' => 'Comentario de la publicación principal',
                'publicationId' => $this->publication->publicationId,
            ])
            ->assertJsonMissing([
                'content' => 'Comentario de otra publicación',
            ]);
    }

    public function test_comment_can_be_shown(): void
    {
        $comment = $this->createComment('Comentario individual');

        $this->getJson('/api/comments/'.$comment->id)
            ->assertOk()
            ->assertJsonFragment([
                'id' => $comment->id,
                'content' => 'Comentario individual',
            ]);
    }

    public function test_owner_can_edit_comment(): void
    {
        $comment = $this->createComment('Contenido original');

        $this->withHeaders($this->authHeaders())
            ->patchJson('/api/comments/'.$comment->id, [
                'content' => 'Contenido actualizado',
            ])
            ->assertOk()
            ->assertJsonFragment([
                'id' => $comment->id,
                'content' => 'Contenido actualizado',
            ]);

        $this->assertDatabaseHas('comments', [
            'id' => $comment->id,
            'content' => 'Contenido actualizado',
            'deleted_at' => null,
        ]);
    }

    public function test_owner_can_soft_delete_comment(): void
    {
        $comment = $this->createComment('Comentario que será eliminado');

        $this->withHeaders($this->authHeaders())
            ->deleteJson('/api/comments/'.$comment->id)
            ->assertOk()
            ->assertJsonFragment([
                'message' => 'Comment deleted successfully.',
            ]);

        $this->assertSoftDeleted('comments', [
            'id' => $comment->id,
        ]);

        $this->getJson('/api/comments/'.$comment->id)
            ->assertNotFound();

        $this->getJson('/api/comments')
            ->assertOk()
            ->assertJsonCount(0);
    }

    public function test_user_cannot_edit_or_delete_another_users_comment(): void
    {
        $otherUser = User::create([
            'role_id' => $this->user->role_id,
            'name' => 'OtherAuthor',
            'email' => 'other@example.com',
            'password' => bcrypt('Secret1!'),
        ]);

        $comment = $this->createComment('Comentario protegido');
        $otherToken = JWTAuth::fromUser($otherUser);

        $this->withHeaders($this->authHeaders($otherToken))
            ->patchJson('/api/comments/'.$comment->id, [
                'content' => 'Edición no autorizada',
            ])
            ->assertForbidden();

        $this->withHeaders($this->authHeaders($otherToken))
            ->deleteJson('/api/comments/'.$comment->id)
            ->assertForbidden();

        $this->assertDatabaseHas('comments', [
            'id' => $comment->id,
            'content' => 'Comentario protegido',
            'deleted_at' => null,
        ]);
    }

    private function createPublication(Product $product): Publication
    {
        return Publication::create([
            'rating' => 5,
            'publicationDate' => now(),
            'userId' => $this->user->id,
            'productId' => $product->productId,
            'numberOfLikes' => 0,
            'active' => true,
            'review' => 'Publicación utilizada para probar comentarios',
        ]);
    }

    private function createComment(
        string $content,
        ?Publication $publication = null
    ): Comment {
        return Comment::create([
            'content' => $content,
            'userId' => $this->user->id,
            'publicationId' => (
                $publication ?? $this->publication
            )->publicationId,
        ]);
    }

    private function authHeaders(?string $token = null): array
    {
        return [
            'Authorization' => 'Bearer '.($token ?? $this->token),
        ];
    }
}
