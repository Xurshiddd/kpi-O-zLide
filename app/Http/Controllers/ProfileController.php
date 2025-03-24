<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Region;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()->notifications()->latest()->get();
        $regions = Region::all();
        $user = User::with(['documents.criterion'])->find(Auth::id());
        return view('users.profile', compact('user', 'regions', 'notifications'));
    }
    public function update(ProfileUpdateRequest $request)
    {
        try {
            $user = Auth::user();
            $data = $request->validated();
            if (!$request->password){
                $data['password'] = $user->password;
            }
            if ($request->hasFile('photo')) {
                if (!empty($user->photo)) {
                    unlink(public_path($user->photo));
                }
                $file = $request->file('photo');
                $data['photo'] = 'uploads/users/' . $file->hashName();
                $file->move(public_path('uploads/users/'), $file->hashName());
            } else {
                $data['photo'] = $user->photo;
            }
            $user->update($data);
        }catch (\Exception $exception){
            \Log::error($exception->getMessage());
            return Redirect::back()->with('error', $exception->getMessage());
        }
        return redirect()->back()->with('success', 'Foydalanuvchi malumotlari yangilandi');
    }
}
