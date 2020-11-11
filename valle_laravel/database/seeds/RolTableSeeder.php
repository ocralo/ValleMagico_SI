<?php

use App\Permission;
use App\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class RolTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Roles app
        $departmentPermission   = Permission::where('name','Departamentos')->first();
        $townPermission         = Permission::where('name','Municipios')->first();
        $institutionPermission  = Permission::where('name','Instituciones')->first();
        $headquarterPermission   = Permission::where('name','Sedes')->first();
        $groupPermission        = Permission::where('name','Grupos')->first();
        $studentPermission      = Permission::where('name','Estudiantes')->first();
        $createRolePermission   = Permission::where('name','Creación de roles')->first();
        $createUserPermission   = Permission::where('name','Creación de usuarios')->first();
        $simatPermission        = Permission::where('name','Simat')->first();
        
        //RoleTableSeeder.php
        
        $manager_role = new Role();
        $manager_role->name = 'admin';
        $manager_role->slug = 'admin';
        $manager_role->desc = 'Admin app';
        $manager_role->destiny_hierarchy_id = 1;
        $manager_role->save();
        $manager_role->permissions()->attach($departmentPermission);
        $manager_role->permissions()->attach($townPermission);
        $manager_role->permissions()->attach($institutionPermission);
        $manager_role->permissions()->attach($headquarterPermission);
        $manager_role->permissions()->attach($groupPermission);
        $manager_role->permissions()->attach($studentPermission);
        $manager_role->permissions()->attach($createRolePermission);
        $manager_role->permissions()->attach($createUserPermission);
        $manager_role->permissions()->attach($simatPermission);

        $department_role = new Role();
        $department_role->name = 'department';
        $department_role->slug = 'department';
        $department_role->desc = 'Department app';
        $department_role->destiny_hierarchy_id = 1;
        $department_role->save();
        $department_role->permissions()->attach($departmentPermission);
        $department_role->permissions()->attach($townPermission);
        $department_role->permissions()->attach($institutionPermission);
        $department_role->permissions()->attach($headquarterPermission);
        $department_role->permissions()->attach($groupPermission);
        $department_role->permissions()->attach($studentPermission);
        $department_role->permissions()->attach($createRolePermission);
        $department_role->permissions()->attach($createUserPermission);
        $department_role->permissions()->attach($simatPermission);

        // Super admin
        // DB::table('rol')->insert([
        //     'name' => 'superadmin',
        //     'slug' => 'superadmin',
        //     'desc' => 'Super Admin',
        // ]);

        // DB::table('role_permission')->insert([
        //     'Rol_idRoles' => '1',
        //     'Permission_id' => '1',
        // ]);
        // DB::table('role_permission')->insert([
        //     'Rol_idRoles' => '1',
        //     'Permission_id' => '2',
        // ]);
        // DB::table('role_permission')->insert([
        //     'Rol_idRoles' => '1',
        //     'Permission_id' => '3',
        // ]);
        // DB::table('role_permission')->insert([
        //     'Rol_idRoles' => '1',
        //     'Permission_id' => '4',
        // ]);
        // DB::table('role_permission')->insert([
        //     'Rol_idRoles' => '1',
        //     'Permission_id' => '5',
        // ]);
        // DB::table('role_permission')->insert([
        //     'Rol_idRoles' => '1',
        //     'Permission_id' => '6',
        // ]);
        // DB::table('role_permission')->insert([
        //     'Rol_idRoles' => '1',
        //     'Permission_id' => '7',
        // ]);
        // DB::table('role_permission')->insert([
        //     'Rol_idRoles' => '1',
        //     'Permission_id' => '8',
        // ]);
        // DB::table('role_permission')->insert([
        //     'Rol_idRoles' => '1',
        //     'Permission_id' => '9',
        // ]);
        // DB::table('role_permission')->insert([
        //     'Rol_idRoles' => '1',
        //     'Permission_id' => '10',
        // ]);
        
        // B::table('role_permission')->insert([
        //     'Rol_idRoles' => '1',
        //     'Permission_id' => '11',
        // ]);
        // DB::table('role_permission')->insert([
        //     'Rol_idRoles' => '1',
        //     'Permission_id' => '12',
        // ]);
        // DB::table('role_permission')->insert([
        //     'Rol_idRoles' => '1',
        //     'Permission_id' => '13',
        // ]);
        // DB::table('role_permission')->insert([
        //     'Rol_idRoles' => '1',
        //     'Permission_id' => '14',
        // ]);
        // DB::table('role_permission')->insert([
        //     'Rol_idRoles' => '1',
        //     'Permission_id' => '15',
        // ]);
        // DB::table('role_permission')->insert([
        //     'Rol_idRoles' => '1',
        //     'Permission_id' => '16',
        // ]);
        // DB::table('role_permission')->insert([
        //     'Rol_idRoles' => '1',
        //     'Permission_id' => '17',
        // ]);
        // DB::table('role_permission')->insert([
        //     'Rol_idRoles' => '1',
        //     'Permission_id' => '18',
        // ]);
        // //  Admin

        // DB::table('rol')->insert([
        //     'name' => 'admin',
        //     'slug' => 'admin',
        //     'desc' => 'Admin',
        // ]);

        // //  Permissions

        // DB::table('rol')->insert([
        //     'name' => 'secretaria',
        //     'slug' => 'secretaria',
        //     'desc' => 'Secretaria de educación',
        // ]);
        
        // DB::table('rol')->insert([
        //     'name' => 'coordinador',
        //     'slug' => 'coordinador',
        //     'desc' => 'Coordinador de institucion',
        // ]);
        
        // DB::table('rol')->insert([
        //     'name' => 'docentes',
        //     'slug' => 'docentes',
        //     'desc' => 'docentes de institucion',
        // ]);
    }
}
