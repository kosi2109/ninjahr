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
        $view_role = new Role(["name" => "view_role"]);
        $view_permission = new Role(["name" => "view_permission"]);
        $create_role  = new Role(["name" => "create_role"]);
        $create_permission  = new Role(["name" => "create_permission"]);
        $edit_role  = new Role(["name" => "edit_role"]);
        $edit_permission  = new Role(["name" => "edit_permission"]);
        $delete_role  = new Role(["name" => "delete_role"]);
        $delete_permission  = new Role(["name" => "edit_permission"]);

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
        $user = User::factory()->create();
        $user->syncRoles($role->id);
    }
}
