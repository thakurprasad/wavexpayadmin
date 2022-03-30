<?php


use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;


class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $permissions = [
            'country-list',
            'country-create',
            'country-edit',
            'country-delete',
            'country-publish',
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'role-publish',
            'state-list',
            'state-create',
            'state-edit',
            'state-delete',
            'state-publish',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'user-publish',
            'bill-list',
            'bill-create',
            'bill-edit',
            'bill-delete',
            'cost-list',
            'cost-create',
            'cost-edit',
            'cost-delete',
            'report-list',
            'setting-list',
            'setting-create',
            'setting-edit',
            'setting-delete',
            'customer-list',
            'customer-create',
            'customer-edit',
            'customer-delete',
            'branch-list',
            'branch-create',
            'branch-edit',
            'branch-delete',
            'order-list',
            'order-create',
            'order-edit',
            'order-delete',
        ];


        foreach ($permissions as $permission) {
             Permission::updateOrCreate(['name' => $permission]);
        }
    }
}
