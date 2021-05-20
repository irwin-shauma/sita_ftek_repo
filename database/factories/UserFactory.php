<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            // 'name' => $this->faker->name,
            // 'email' => $this->faker->unique()->safeEmail,
            // 'email_verified_at' => now(),
            // 'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'password' => Hash::make('123123123'), // password
            // 'remember_token' => Str::random(10),
        ];
    }
    public function configure()
    {
        //Aftermaking itu setelah buat model, aftercreating setelah model disimpan di database.
        return $this->afterMaking(function (User $user) {
            //
        })->afterCreating(function (User $user) { // Kode ini dijalnkan setelah user terbuat
            $admin = User::where('id', 1)->get();
            $admin[0]->assignRole('adminTU');
        });
    }
}
