<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /** Access Users */
        DB::table('permissions')->insert([
            'name'          => 'Criação de usuários',
            'slug'          => 'users_store',
            'description'   => 'Criação de usuários',
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now()
        ]);
        DB::table('permissions')->insert([
            'name'          => 'Edição de usuários',
            'slug'          => 'users_update',
            'description'   => 'Edição de usuários',
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now()
        ]);
        DB::table('permissions')->insert([
            'name'          => 'Exclusão permanente de usuários.',
            'slug'          => 'users_delete',
            'description'   => 'Exclusão permanente de usuários.',
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now()
        ]);
        DB::table('permissions')->insert([
            'name'          => 'Exclusão temporaria de usuários',
            'slug'          => 'users_trash',
            'description'   => 'Exclusão temporaria de usuários',
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now()
        ]);
        DB::table('permissions')->insert([
            'name'          => 'Acesso ao menu de usuários',
            'slug'          => 'users_menu',
            'description'   => 'Acesso ao menu de usuários',
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now()
        ]);
        DB::table('permissions')->insert([
            'name'          => 'Restaurar usuários',
            'slug'          => 'users_restore',
            'description'   => 'Restaurar usuários',
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now()
        ]);
        DB::table('permissions')->insert([
            'name'          => 'Visualização de usuários',
            'slug'          => 'users_view',
            'description'   => 'Visualização de usuários',
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now()
        ]);
        /** Access Groups */
        DB::table('permissions')->insert([
            'name'          => 'Criação de grupos',
            'slug'          => 'groups_store',
            'description'   => 'Criação de grupos',
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now()
        ]);
        DB::table('permissions')->insert([
            'name'          => 'Edição de grupos',
            'slug'          => 'groups_update',
            'description'   => 'Edição de grupos',
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now()
        ]);
        DB::table('permissions')->insert([
            'name'          => 'Exclusão permanente de grupos.',
            'slug'          => 'groups_delete',
            'description'   => 'Exclusão permanente de grupos.',
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now()
        ]);
        DB::table('permissions')->insert([
            'name'          => 'Exclusão temporaria de grupos',
            'slug'          => 'groups_trash',
            'description'   => 'Exclusão temporaria de grupos',
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now()
        ]);
        DB::table('permissions')->insert([
            'name'          => 'Acesso ao menu de grupos',
            'slug'          => 'groups_menu',
            'description'   => 'Acesso ao menu de grupos',
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now()
        ]);
        DB::table('permissions')->insert([
            'name'          => 'Restaurar grupos',
            'slug'          => 'groups_restore',
            'description'   => 'Restaurar grupos',
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now()
        ]);
        DB::table('permissions')->insert([
            'name'          => 'Visualização de grupos',
            'slug'          => 'groups_view',
            'description'   => 'Visualização de grupos',
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now()
        ]);
        /** Access Permissions */
        DB::table('permissions')->insert([
            'name'          => 'Criação de permissões',
            'slug'          => 'permissions_store',
            'description'   => 'Criação de permissões',
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now()
        ]);
        DB::table('permissions')->insert([
            'name'          => 'Edição de permissões',
            'slug'          => 'permissions_update',
            'description'   => 'Edição de permissões',
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now()
        ]);
        DB::table('permissions')->insert([
            'name'          => 'Exclusão permanente de permissões.',
            'slug'          => 'permissions_delete',
            'description'   => 'Exclusão permanente de permissões.',
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now()
        ]);
        DB::table('permissions')->insert([
            'name'          => 'Exclusão temporaria de permissões',
            'slug'          => 'permissions_trash',
            'description'   => 'Exclusão temporaria de permissões',
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now()
        ]);
        DB::table('permissions')->insert([
            'name'          => 'Acesso ao menu de permissões',
            'slug'          => 'permissions_menu',
            'description'   => 'Acesso ao menu de permissões',
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now()
        ]);
        DB::table('permissions')->insert([
            'name'          => 'Restaurar permissões',
            'slug'          => 'permissions_restore',
            'description'   => 'Restaurar permissões',
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now()
        ]);
        DB::table('permissions')->insert([
            'name'          => 'Visualização de permissões',
            'slug'          => 'permissions_view',
            'description'   => 'Visualização de permissões',
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now()
        ]);
    }
}
