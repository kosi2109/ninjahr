<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = new Role(["name" => "HR"]);
        $view_role = new Permission(["name" => "view_role"]);
        $view_permission = new Permission(["name" => "view_permission"]);
        $create_role  = new Permission(["name" => "create_role"]);
        $create_permission  = new Permission(["name" => "create_permission"]);
        $edit_role  = new Permission(["name" => "edit_role"]);
        $edit_permission  = new Permission(["name" => "edit_permission"]);
        $delete_role  = new Permission(["name" => "delete_role"]);
        $delete_permission  = new Permission(["name" => "edit_permission"]);

        $role->givePermissionTo([
            $view_role->id, 
            $view_permission->id, 
            $create_role->id, 
            $create_permission->id, 
            $edit_role->id, 
            $edit_permission->id, 
            $delete_role->id,
            $delete_permission->id,
        ]);
        // $user = new User([
        //     'name' => "Si Thu Htet",
        //     'email' => "sithuhtet.kosi21@gmail.com",
        //     'password' => bcrypt('asdqwefr'), // password
        //     'phone' => "09781903836",
        //     'nrc_number' => "0/abc(N)09888",
        //     'birthday' => "2000-09-21",
        //     'gender' => "male",
        //     'address' => "address",
        //     'employee_id' => "e_0001",
        //     'pin' => "111111",
        // ]);
        // $user->syncRoles($role->id);
    }
}
