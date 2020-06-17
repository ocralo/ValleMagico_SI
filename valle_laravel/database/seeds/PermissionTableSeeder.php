<?php

use App\Permission;
use App\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $manager_role = Role::where('slug', 'admin')->first();

        $departmentPermission = new Permission();
        $departmentPermission->slug = 'departments';
        $departmentPermission->name = 'Departamentos';
        $departmentPermission->desc = 'Mostrar página de departamentos.';
        $departmentPermission->save();
        $departmentPermission->roles()->attach($manager_role);

        $townPermission= new Permission();
        $townPermission->slug = 'towns';
        $townPermission->name = 'Municipios';
        $townPermission->desc = 'Mostrar página de municipios.';
        $townPermission->save();
        $townPermission->roles()->attach($manager_role);

        $institutionPermission = new Permission();
        $institutionPermission->slug = 'institutions';
        $institutionPermission->name = 'Instituciones';
        $institutionPermission->desc = 'Mostrar página de instituciones.';
        $institutionPermission->save();
        $institutionPermission->roles()->attach($manager_role);

        $headquarterPermission = new Permission();
        $headquarterPermission->slug = 'headquarters';
        $headquarterPermission->name = 'Sedes';
        $headquarterPermission->desc = 'Mostrar página de sedes.';
        $headquarterPermission->save();
        $headquarterPermission->roles()->attach($manager_role);

        $groupPermission = new Permission();
        $groupPermission->slug = 'hq_grades';
        $groupPermission->name = 'Grupos';
        $groupPermission->desc = 'Mostrar página de grupos.';
        $groupPermission->save();
        $groupPermission->roles()->attach($manager_role);

        $studentPermission = new Permission();
        $studentPermission->slug = 'game_users';
        $studentPermission->name = 'Estudiantes';
        $studentPermission->desc = 'Mostrar página de estudiantes.';
        $studentPermission->save();
        $studentPermission->roles()->attach($manager_role);

        $createRolePermission = new Permission();
        $createRolePermission->slug = '';
        $createRolePermission->name = 'Creación de roles';
        $createRolePermission->desc = 'Mostrar página para crear roles.';
        $createRolePermission->save();
        $createRolePermission->roles()->attach($manager_role);

        $createUserPermission = new Permission();
        $createUserPermission->slug = '';
        $createUserPermission->name = 'Creación de usuarios';
        $createUserPermission->desc = 'Mostrar página para crear usuarios.';
        $createUserPermission->save();
        $createUserPermission->roles()->attach($manager_role);

        $simatPermission = new Permission();
        $simatPermission->slug = '';
        $simatPermission->name = 'Simat';
        $simatPermission->desc = 'Mostrar página para subir archivos excel.';
        $simatPermission->save();
        $simatPermission->roles()->attach($manager_role);
    }
}

 // Users
        // DB::table('permission')->insert([
        //     'name' => 'Navegar en usuarios',
        //     'slug' => 'users.index',
        //     'desc' => 've todos los usuarios',
        // ]);

        // DB::table('permission')->insert(
        //     [
        //         'name' => 'Detalles usuarios',
        //         'slug' => 'users.info',
        //         'desc' => 've la informacion del usuario',
        //     ]
        // );
        // DB::table('permission')->insert([
        //     'name' => 'Crea de usuarios',
        //     'slug' => 'users.index',
        //     'desc' => 'crea un usuario en el sistema',
        // ]);

        // DB::table('permission')->insert(
        //     [
        //         'name' => 'Editar usuarios',
        //         'slug' => 'users.edit',
        //         'desc' => 'edita la info de los usuarios',
        //     ]
        // );
    
        // DB::table('permission')->insert(
        //     [
        //         'name' => 'Elimina usuarios',
        //         'slug' => 'users.delete',
        //         'desc' => 'elimina los usuarios',
        //     ]
        // );

        // // Roles
        // DB::table('permission')->insert([
        //     'name' => 'Navegar en roles',
        //     'slug' => 'rol.index',
        //     'desc' => 've todos los roles',
        // ]);

        // DB::table('permission')->insert(
        //     [
        //         'name' => 'Detalles rol',
        //         'slug' => 'rol.info',
        //         'desc' => 've la informacion del rol',
        //     ]
        // );
        // DB::table('permission')->insert([
        //     'name' => 'Crea de rol',
        //     'slug' => 'rol.index',
        //     'desc' => 'crea un usuario un rol',
        // ]);

        // DB::table('permission')->insert(
        //     [
        //         'name' => 'Editar roles',
        //         'slug' => 'rol.edit',
        //         'desc' => 'edita permisos de roles',
        //     ]
        // );
    
        // DB::table('permission')->insert(
        //     [
        //         'name' => 'Elimina roles',
        //         'slug' => 'rol.delete',
        //         'desc' => 'elimina los roles',
        //     ]
        // );

        // //  Vistas permitidas

        // DB::table('permission')->insert([
        //     'name' => 'ver pais',
        //     'slug' => 'views.county',
        //     'desc' => 'vista de país',
        // ]);

        // DB::table('permission')->insert(
        //     [
        //         'name' => 'ver region',
        //         'slug' => 'views.regions',
        //         'desc' => 'vista de region',
        //     ]
        // );
        // DB::table('permission')->insert([
        //     'name' => 'ver departamentos',
        //     'slug' => 'views.deparment',
        //     'desc' => 'vista de departamentos',
        // ]);

        // DB::table('permission')->insert(
        //     [
        //         'name' => 'ver municipios',
        //         'slug' => 'views.towns',
        //         'desc' => 'vista de municipios',
        //     ]
        // );
    
        // DB::table('permission')->insert(
        //     [
        //         'name' => 'ver instituciones',
        //         'slug' => 'views.institution',
        //         'desc' => 'vista de instituciones',
        //     ]
        // );

        // DB::table('permission')->insert(
        //     [
        //         'name' => 'ver sedes',
        //         'slug' => 'views.headquarter',
        //         'desc' => 'vista de sedes',
        //     ]
        // );

        // DB::table('permission')->insert(
        //     [
        //         'name' => 'ver grupos',
        //         'slug' => 'views.groups',
        //         'desc' => 'vista de grupos',
        //     ]
        // );

        // DB::table('permission')->insert(
        //     [
        //         'name' => 'ver estudiantes',
        //         'slug' => 'views.students',
        //         'desc' => 'vista de estudiantes',
        //     ]
        // );

