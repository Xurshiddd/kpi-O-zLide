<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserRepository
{
    /**
     * Create a new class instance.
     */

    public function getAll()
    {
        return User::with('roles')->orderBy('id', 'asc')->paginate(15);
    }
}
