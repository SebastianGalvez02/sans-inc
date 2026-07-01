<?php

namespace App\Services\Implements;

use App\DTOs\PublicationRequestDto;
use App\DTOs\PublicationResponseDto;
use App\Repositories\Interfaces\IPublicationRepository;
use App\Services\Interfaces\IPublicationService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use InvalidArgumentException;

class PublicationService implements IPublicationService
{
    /**
     * Propiedad privada para guardar el repositorio de publicaciones
     */
    protected IPublicationRepository $publicationRepository;

    /**
     * Constructor de la clase que inyecta el repositorio de publicaciones
     */
    public function __construct(IPublicationRepository $publicationRepository)
    {
        $this->publicationRepository = $publicationRepository;
    }

    /**
     * Funcion que permiitra visualizar las publicaciones tanto de un producto especifico como de
     * el listado general de las publicaciones activas
     * Esta funcion servira para la rf10
     */
    public function listPublications(?int $productId = null, ?int $categoryId = null): Collection
    {
        if ($productId !== null) {
            $publications = $this->publicationRepository->getByProductId($productId);
        } elseif ($categoryId !== null) {
            $publications = $this->publicationRepository->getByCategoryId($categoryId);
        } else {
            $publications = $this->publicationRepository->getAllActive();
        }

        return $publications->map(fn($pub) => PublicationResponseDto::fromModel($pub));
    }

    /**
     * Funcion que permite ver detalle completo de la publicación (esto servira para la rf11)
     */
    public function getPublicationById(int $id): PublicationResponseDto
    {
        // El repository buscará una publicación activa por su id  
        $publication = $this->publicationRepository->findActiveById($id);
        // Si es null, se lanza una excepción 
        if (!$publication) {
            throw new ModelNotFoundException("Publicación no encontrada o inactiva.");
        }
        // Se transforma el modelo a DTO de salida y se retorna
        return PublicationResponseDto::fromModel($publication);
    }

    /**
     * Función que permite tener un panel personal de las publicaciones de un usuario
     * Esta función sirve para la rf12
     */
    public function getPublicationsByOwner(int $userId): Collection
    {
        // Llama al método específico del repositorio que filtra por la columna userId
        $publications = $this->publicationRepository->getByUserId($userId);
        // Transforma los modelos en colecciones DTO listas para enviar al frontend (no usar aún)
        return $publications->map(fn($pub) => PublicationResponseDto::fromModel($pub));
    }

    /**
     * Función que permite crear una publicación asociada a un producto
     * Necesaria para la rf7
     */
    public function createPublication(PublicationRequestDto $dto, int $userId): PublicationResponseDto
    {
        // Límite de texto
        $length = mb_strlen($dto->review);
        if ($length < 3 || $length > 255) {
            throw new InvalidArgumentException("La reseña debe tener entre 3 y 255 caracteres.");
        }
        // Se crea un array con los datos de la publicación y se llama al repositorio para crearlo
        $publication = $this->publicationRepository->create([
            'userId' => $userId,
            'productId' => $dto->productId,
            'rating' => $dto->rating,
            'review' => $dto->review,
            'publicationDate' => now(),
            'numberOfLikes' => 0,
            'active' => true,
        ]);

        return PublicationResponseDto::fromModel($publication);
    }

    /**
     * Función que permite editar una publicación 
     */
    public function updatePublication(int $id, PublicationRequestDto $dto, int $userId): PublicationResponseDto
    {
        // Se verifica que la publicación exista y esté activa
        $publication = $this->publicationRepository->findActiveById($id);

        if (!$publication) {
            throw new ModelNotFoundException("Publicación no encontrada.");
        }

        // Método de seguridad para asegurar que solo el autor pueda editar la publicación
        if ($publication->userId !== $userId) {
            throw new AccessDeniedHttpException("No tienes permisos para editar esta publicación.");
        }

        // Se vuelve a verificar el límite de caracteres antes de actualizar
        $length = mb_strlen($dto->review);
        if ($length < 3 || $length > 255) {
            throw new InvalidArgumentException("La reseña debe tener entre 3 y 255 caracteres.");
        }

        // Se envia los datos al repository para actualizar la publicacion y se retorna el DTO de salida
        $updatedPublication = $this->publicationRepository->update($id, [
            'productId' => $dto->productId,
            'rating' => $dto->rating,
            'review' => $dto->review,
        ]);

        return PublicationResponseDto::fromModel($updatedPublication);
    }

    /**
     * Función para eliminar publicación donde solo el autor puede hacerlo (rf9)
     */
    public function deletePublication(int $id, int $userId): bool
    {
        // Se verifica que la publicación exista y esté activa
        $publication = $this->publicationRepository->findActiveById($id);

        if (!$publication) {
            throw new ModelNotFoundException("Publicación no encontrada.");
        }

        // Asegurar que solo el autor pueda dar de baja la publicación
        if ($publication->userId !== $userId) {
            throw new AccessDeniedHttpException("No tienes permisos para eliminar esta publicación.");
        }

        // Se pasa de active a false en vez de borrar el registro físico
        $this->publicationRepository->update($id, [
            'active' => false
        ]);

        return true;
    }
}