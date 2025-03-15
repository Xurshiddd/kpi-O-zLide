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
            // Rasmni yuklash
            $filename = null;
            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                $filename = 'uploads/users/' . $file->hashName();
                $file->move(public_path('uploads/users/'), $file->hashName());
            }
            // Ma'lumotlarni tayyorlash
            $data = $request->except(['photo', 'roles']);
            $data['photo'] = $filename;
            // Telefon raqamini formatlash
            $phone = preg_replace('/\D/', '', $request->phone); // Faqat raqamlarni olish
            if (!str_starts_with($phone, '998')) {
                $phone = '998' . ltrim($phone, '998');
            }
            $data['phone'] = '+' . $phone;
            // Foydalanuvchini yaratish
            $user = $this->userRepository->save($data);
            // Role'larni biriktirish
            if (!empty($request->roles)) {
                $user->syncRoles($request->roles);
            }
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            \Log::error('User create error: ' . $exception->getMessage());
            return false;
        }
        return true;
    }
    public function update($request, $id)
    {
        try {
            DB::beginTransaction();
            $filename = null;
            $user = $this->userRepository->getById($id);
            if ($request->hasFile('photo')) {
                if (!empty($user->photo)) {
                    unlink(public_path($user->photo));
                }
                $file = $request->file('photo');
                $filename = 'uploads/users/' . $file->hashName();
                $file->move(public_path('uploads/users/'), $file->hashName());
            }else{
                $filename = $user->photo;
            }
            $phone = preg_replace('/\D/', '', $request->phone);

            if (strlen($phone) == 9) {
                $phone = '998' . $phone;
            }
            if (!str_starts_with($phone, '998')) {
                $phone = '998' . $phone;
            }
            $phone = '+'.$phone;
            $data = $request->except(['photo', 'roles']);
            $data['photo'] = $filename;
            $data['phone'] = $phone;
            if ($request->password) {
                $data['password'] = bcrypt($request->password);
            }else{
                $data['password'] = $user->password;
            }
            $this->userRepository->updated($id, $data);
            if (!empty($request->roles)) {
                $user->syncRoles($request->roles);
            }
            DB::commit();
        }catch (\Exception $exception){
            DB::rollBack();
            \Log::error('User update error: ' . $exception->getMessage());
            return false;
        }
        return true;
    }
    public function delete($id)
    {
        try {
            $user = $this->userRepository->getById($id);

            if (!empty($user->photo)) {
                $filePath = public_path('uploads/users/' . basename($user->photo));

                if (file_exists($filePath)) {
                    unlink($filePath);
                } else {
                    \Log::warning('Fayl topilmadi: ' . $filePath);
                }
            }

            $user->syncRoles([]);
            $user->delete();
        } catch (\Exception $exception) {
            \Log::error('User delete error: ' . $exception->getMessage());
            return false;
        }
        return true;
    }

}
