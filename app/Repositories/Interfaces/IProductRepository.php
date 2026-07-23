<?php
namespace App\Repositories\Interfaces;

/**
 * Interfaz para definir consultas de productos.
 *
 * Establece el contrato que deben cumplir los repositorios encargados
 * de obtener productos activos desde la fuente de datos.
 *
 * @author Equipo Sans Inc.
 * @version 1.0
 */
interface IProductRepository
{
    /**
     * Consulta todos los productos activos.
     *
     * @return mixed
     */
    public function getAllActive();

    /**
     * Consulta un producto activo por su identificador.
     *
     * @param int $id
     * @return mixed
     */
    public function findActiveById(int $id);

    /**
     * Consulta productos activos por categoria.
     *
     * @param int $categoryId
     * @return mixed
     */
    public function getByCategoryId(int $categoryId);
}
