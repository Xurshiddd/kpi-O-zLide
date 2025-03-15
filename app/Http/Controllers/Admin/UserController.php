<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(
        public UserService $userService,
        public UserRepository $userRepository,
    )
    {}

    public function index()
    {
        return view('users.index', ['users' => $this->userService->index()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request)
    {
        $saved = $this->userService->store($request);

        if ($saved === false) {
            return redirect()->back()->with('error', 'User creation failed! Please try again.');
        }

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $roles = Role::all();
        return view('users.edit', ['user' => $this->userRepository->getEdit($id),'roles' => $roles]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, $id)
    {
        $saved = $this->userService->update($request, $id);
        if ($saved === false) {
            return redirect()->back()->with('error', 'User update failed! Please try again.');
        }
        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $destroyed = $this->userService->delete($id);
        if ($destroyed === false) {
            return redirect()->back()->with('error', 'User delete failed! Please try again.');
        }
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
