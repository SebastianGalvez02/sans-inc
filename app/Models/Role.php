<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // Needed for Soft Delete

/**
 * Role model
 * This model represents the 'roles' table in the database.
 * It manages the system's profile types
 * @method static \App\Models\Role create(array $attributes = [])
 * /
 */
class Role extends Model
{
    // Enables soft deletes (deleted records are only hidden by filling the 'deleted_at' column)
    use SoftDeletes;

    // Explicitly binds this model to the 'roles' table in the database
    protected $table = 'roles';

    // Defines the only fields that can be filled via mass assignment (security measure)
    protected $fillable = [
        'role_name',
        'description'
    ];
}
