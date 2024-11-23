<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Article;
use App\Models\Phrase;
use App\Models\Comment;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::create(['name' => 'writer']);
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'user']);


        $user = new User();
        $user->name = "LUCIA";
        $user->surname = "DIAZ";
        $user->username = "LU";
        $user->email = env('USER_DEFAULT_EMAIL');
        $user->password = Hash::make(env('USER_DEFAULT_PASSWORD'));

        $user->assignRole("admin");
        $user->save();


        $user2 = new User();
        $user2->name = "VICTOR";
        $user2->surname = "VERA CORONEL";
        $user2->username = "VITTORIO";
        $user2->email = "VICTOR@CORREO.ES";
        $user->password = Hash::make(env('USER_DEFAULT_PASSWORD_2'));
        $user2->assignRole("admin");
        $user2->save();

        /*User::factory(10)->create();
        Article::factory(20)->create();
        Phrase::factory(1)->create();*/
    }
}
