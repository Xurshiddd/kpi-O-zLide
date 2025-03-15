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
        return User::with(['roles', 'department', 'region'])->orderBy('id', 'asc')->paginate(15);
    }

    public function save($data)
    {
        $user = User::create($data);
        return $user;
    }
    public function getEdit($id)
    {
        $user = User::with(['roles', 'department', 'region'])->find($id);
        return $user;
    }
    public function updated($id, $data)
    {
        $user = User::find($id);
        $user->update($data);
        return $user;
    }

    public function getById($id)
    {
        $user = User::find($id);
        return $user;
    }
}
