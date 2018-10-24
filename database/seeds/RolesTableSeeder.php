<?php

use App\Utils\Keys\user\UserKeys;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        $roles = [
            ['id' => UserKeys::ROLE_USER_ROOT, 'name' => 'root', 'display_name' => 'Root', 'description' => 'Role for the user with all permissions', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime()],
            ['id' => UserKeys::ROLE_USER_ADMIN, 'name' => 'admin', 'display_name' => 'Administrator', 'description' => 'Role for the user Administrator', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime()],
            ['id' => UserKeys::ROLE_USER_CAJERO, 'name' => 'cajero', 'display_name' => 'Cajero', 'description' => 'Role for the user Cajero', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime()],
        ];

        DB::table('roles')->insert($roles);

        $role_users = [
            ['user_id' => UserKeys::USER_ROOT_ID, 'role_id' => UserKeys::ROLE_USER_ROOT],
            ['user_id' => UserKeys::USER_ROOT_ID, 'role_id' => UserKeys::ROLE_USER_ADMIN],
            ['user_id' => UserKeys::USER_ROOT_ID, 'role_id' => UserKeys::ROLE_USER_CAJERO],
        ];

        DB::table('role_user')->insert($role_users);

        $role_user_bussinness = [
            ['user_id' => UserKeys::USER_ADMIN_BUSSINESS_ID, 'role_id' => UserKeys::ROLE_USER_ADMIN],
            ['user_id' => UserKeys::USER_ADMIN_BUSSINESS_ID, 'role_id' => UserKeys::ROLE_USER_CAJERO],
        ];

        DB::table('role_user')->insert($role_user_bussinness);

        $permissions = [
            ['id' => UserKeys::PERMISSION_SYSTEM_CONFIGURATION, 'name' => 'system_configuration', 'display_name' => 'System Configuration', 'description' => 'This permission is for process of configuration about system', 'created_at' => new \DateTime(), 'updated_at' => new \DateTime()],
        ];

        DB::table('permissions')->insert($permissions);

        $permission_roles = [
            ['permission_id' => UserKeys::PERMISSION_SYSTEM_CONFIGURATION, 'role_id' => UserKeys::ROLE_USER_ROOT],
        ];

        DB::table('permission_role')->insert($permission_roles);
    }
}
