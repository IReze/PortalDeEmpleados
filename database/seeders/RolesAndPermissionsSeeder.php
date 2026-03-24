<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Limpiar caché de permisos (Muy importante)
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 2. Crear los permisos base
        Permission::create(['name' => 'ver todo']);
        Permission::create(['name' => 'lanzar avisos']); // Crear/Editar Avisos
        Permission::create(['name' => 'gestionar agenda']); // Crear/Editar Directorio
        Permission::create(['name' => 'consultar bitacora']); // Ver asistencia propia

        // 3. Crear los Roles y asignar los permisos según tu lista:

        // ADMIN: Puede hacer todo
        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo(Permission::all());

        // ADMIN_HUMANOS: Avisos + Bitácora (Ver todo, pero no toca agenda)
        $humanos = Role::create(['name' => 'admin_humanos']);
        $humanos->givePermissionTo(['ver todo', 'lanzar avisos', 'consultar bitacora']);

        // ADMIN_INFO: Agenda + Bitácora (Ver todo, pero no lanza avisos)
        $info = Role::create(['name' => 'admin_info']);
        $info->givePermissionTo(['ver todo', 'gestionar agenda', 'consultar bitacora']);

        // USUARIO NORMAL: Solo consulta
        $normal = Role::create(['name' => 'usuario_normal']);
        $normal->givePermissionTo(['ver todo', 'consultar bitacora']);
    }
}