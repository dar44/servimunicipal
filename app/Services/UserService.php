<?php

namespace App\Services;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class UserService {

    /**
     * Function to create new user using validated data
     * 
     * @param array $data
     * @throws \Exception
     * @return User
     */
    public function createUsuario(array $data): User
    {
        DB::beginTransaction();
        try {
            if (isset($data['image'])) {
                $data['image'] = $this->uploadImage($data['image']);
            }

            $user = User::create($data);

            DB::commit();
            return $user;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception('Error al crear el usuario: ' . $e->getMessage());
        }
    }

    /**
     * Function to edit a user using validated data
     * 
     * @param \App\Models\User $user
     * @param array $data
     * @throws \Exception
     * @return User|null
     */
    public function updateUsuario(User $user, array $data): User
    {
        DB::beginTransaction();
        try {
            if (isset($data['image'])) {
                $this->deleteImage($user->image);
                $data['image'] = $this->uploadImage($data['image']);
            }

            // Evitar sobrescribir contraseña si está vacía
            if (empty($data['password'])) {
                unset($data['password']);
            }

            $user->update($data);

            DB::commit();
            return $user->fresh();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception('Error al actualizar el usuario: ' . $e->getMessage());
        }
    }

    /**
     * Function to delete image associated to user
     * 
     * @param mixed $imagePath
     * @return void
     */
    private function deleteImage(?string $imagePath): void
    {
        if (!$imagePath || $imagePath === 'profile-images/image.png') {
            return;
        }

        if (Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
        }
    }

    /**
     * Function to upload image associated to user
     * 
     * @param mixed $image
     * @return array|string
     */
    private function uploadImage($image): string
    {
        return $image->store('profile-images', 'public');
    }

    /**
     * Function to delete user
     * 
     * @param \App\Models\User $user
     * @throws \Exception
     * @return void
     */
    public function deleteUsuario(User $user): void
    {
        DB::beginTransaction();
        try {
            $this->deleteImage($user->image);
            $user->delete();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception('Error al eliminar el usuario: ' . $e->getMessage());
        }
    }
  
}