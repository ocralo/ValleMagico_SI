<?php

use App\Permission;  
use App\Role;  
use App\User;  
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //  Create Roles For Users
        $admin_role             = Role::where('slug','admin')->first();
        $department_role        = Role::where('slug','department')->first();
        // Create Permissions Users
        $departmentPermission   = Permission::where('slug','Departamentos')->first();
        $townPermission         = Permission::where('slug','Municipios')->first();
        $institutionPermission  = Permission::where('slug','Instituciones')->first();
        $headquarterPermission   = Permission::where('slug','Sedes')->first();
        $groupPermission        = Permission::where('slug','Grupos')->first();
        $studentPermission      = Permission::where('slug','Estudiantes')->first();
        $statisticPermission    = Permission::where('slug','Estadisticas')->first();
        $informPermission       = Permission::where('slug','Informes')->first();
        
        // Create User Admin
        $manager = new User();
        $manager->name = 'admin';
        $manager->username = 'admin';
        $manager->email = 'admin@gmail.com';
        $manager->password = bcrypt('123123123');
        $manager->save();
        // Asing Role User
        $manager->roles()->attach($admin_role);
        // Asing Permission User
        // $manager->permissions()->attach($departmentPermission);
        // $manager->permissions()->attach($townPermission);
        // $manager->permissions()->attach($institutionPermission);
        // $manager->permissions()->attach($headquarterPermission);
        // $manager->permissions()->attach($groupPermission);
        // $manager->permissions()->attach($studentPermission);
        // $manager->permissions()->attach($statisticPermission);
        // $manager->permissions()->attach($informPermission);


        // create new user        //     'password' => '$2y$10$Ks3i/JQfxr0atlvSu9x/c.IxgNv0x.6YnQOZAOk8h8I0i5.HaV6c6',
        // ]);

        //  Create new relation userRol
        // DB::table('user_rol')->insert([
        //     'User_id' => '1',
        //     'Rol_idRoles' => '1',
        // ]);

        // Create User Admin
        $departments_role = new User();
        $departments_role->name = 'gobernacion cauca';
        $departments_role->username = 'gobernacioncauca';
        $departments_role->email = 'gobernacioncauca@gmail.com';
        $departments_role->password = bcrypt('123123123');
        $departments_role->save();
        // Asing Role User
        $departments_role->roles()->attach($department_role);
        // Asing Permission User
        // $departments_role->permissions()->attach($departmentPermission);
        // $departments_role->permissions()->attach($townPermission);
        // $departments_role->permissions()->attach($institutionPermission);
        // $departments_role->permissions()->attach($headquarterPermission);
        // $departments_role->permissions()->attach($groupPermission);
        // $departments_role->permissions()->attach($studentPermission);
        // $departments_role->permissions()->attach($statisticPermission);
        // $departments_role->permissions()->attach($informPermission);
    }
}
