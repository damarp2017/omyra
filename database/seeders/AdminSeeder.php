<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleAdmin = Role::create(['name' => 'admin']);
        $roleWarehouse = Role::create(['name' => 'warehouse']);
        $roleStaff = Role::create(['name' => 'staff']);

        $admin1 = new User();
        $admin1->name = "Damar Permadany";
        $admin1->email = "damarp2017@gmail.com";
        $admin1->password = Hash::make("12345678");
        $admin1->save();

        $admin1->assignRole('admin');
    }
}
