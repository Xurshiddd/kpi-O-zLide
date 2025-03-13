<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\DB;

class UserService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public UserRepository $userRepository,
    )
    {}
    public function index()
    {
        return $this->userRepository->getAll();
    }

    public function store($request)
    {
        try {
            DB::beginTransaction();
            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->move('uploads/users/', $filename);
            }
            $data = [];
            $data = $request->except(['photo', 'roles']);
            $data['photo'] = 'uploads/users/' . $filename;
            $user = $this->userRepository->save($data);
            $user->roles()->attach($request->roles);
            DB::commit();
        }catch (\Exception $exception){
            DB::rollBack();
            \Log::error($exception->getMessage());
            return false;
        }
        return true;
    }
}
