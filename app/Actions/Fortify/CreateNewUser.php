<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'nama_lengkap' => ['required', 'string', 'max:50'],
            'username'     => ['required', 'string', 'max:50', Rule::unique(User::class)],
            'password'     => ['required', 'string', 'min:8', 'confirmed'],
        ])->validate();

        return User::create([
            'nama_lengkap' => $input['nama_lengkap'],
            'username'     => $input['username'],
            'password'     => Hash::make($input['password']),
            'role'         => 'petugas',
            'status_aktif' => true,
        ]);
    }
}
