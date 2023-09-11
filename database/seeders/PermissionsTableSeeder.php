<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_create',
            ],
            [
                'id'    => 3,
                'title' => 'permission_edit',
            ],
            [
                'id'    => 4,
                'title' => 'permission_show',
            ],
            [
                'id'    => 5,
                'title' => 'permission_delete',
            ],
            [
                'id'    => 6,
                'title' => 'permission_access',
            ],
            [
                'id'    => 7,
                'title' => 'role_create',
            ],
            [
                'id'    => 8,
                'title' => 'role_edit',
            ],
            [
                'id'    => 9,
                'title' => 'role_show',
            ],
            [
                'id'    => 10,
                'title' => 'role_delete',
            ],
            [
                'id'    => 11,
                'title' => 'role_access',
            ],
            [
                'id'    => 12,
                'title' => 'user_create',
            ],
            [
                'id'    => 13,
                'title' => 'user_edit',
            ],
            [
                'id'    => 14,
                'title' => 'user_show',
            ],
            [
                'id'    => 15,
                'title' => 'user_delete',
            ],
            [
                'id'    => 16,
                'title' => 'user_access',
            ],
            [
                'id'    => 17,
                'title' => 'company_create',
            ],
            [
                'id'    => 18,
                'title' => 'company_edit',
            ],
            [
                'id'    => 19,
                'title' => 'company_show',
            ],
            [
                'id'    => 20,
                'title' => 'company_delete',
            ],
            [
                'id'    => 21,
                'title' => 'company_access',
            ],
            [
                'id'    => 22,
                'title' => 'team_create',
            ],
            [
                'id'    => 23,
                'title' => 'team_edit',
            ],
            [
                'id'    => 24,
                'title' => 'team_show',
            ],
            [
                'id'    => 25,
                'title' => 'team_delete',
            ],
            [
                'id'    => 26,
                'title' => 'team_access',
            ],
            [
                'id'    => 27,
                'title' => 'asset_management_access',
            ],
            [
                'id'    => 28,
                'title' => 'asset_category_create',
            ],
            [
                'id'    => 29,
                'title' => 'asset_category_edit',
            ],
            [
                'id'    => 30,
                'title' => 'asset_category_show',
            ],
            [
                'id'    => 31,
                'title' => 'asset_category_delete',
            ],
            [
                'id'    => 32,
                'title' => 'asset_category_access',
            ],
            [
                'id'    => 33,
                'title' => 'asset_location_create',
            ],
            [
                'id'    => 34,
                'title' => 'asset_location_edit',
            ],
            [
                'id'    => 35,
                'title' => 'asset_location_show',
            ],
            [
                'id'    => 36,
                'title' => 'asset_location_delete',
            ],
            [
                'id'    => 37,
                'title' => 'asset_location_access',
            ],
            [
                'id'    => 38,
                'title' => 'asset_status_create',
            ],
            [
                'id'    => 39,
                'title' => 'asset_status_edit',
            ],
            [
                'id'    => 40,
                'title' => 'asset_status_show',
            ],
            [
                'id'    => 41,
                'title' => 'asset_status_delete',
            ],
            [
                'id'    => 42,
                'title' => 'asset_status_access',
            ],
            [
                'id'    => 43,
                'title' => 'asset_create',
            ],
            [
                'id'    => 44,
                'title' => 'asset_edit',
            ],
            [
                'id'    => 45,
                'title' => 'asset_show',
            ],
            [
                'id'    => 46,
                'title' => 'asset_delete',
            ],
            [
                'id'    => 47,
                'title' => 'asset_access',
            ],
            [
                'id'    => 48,
                'title' => 'assets_history_access',
            ],
            [
                'id'    => 49,
                'title' => 'license_management_create',
            ],
            [
                'id'    => 50,
                'title' => 'license_management_edit',
            ],
            [
                'id'    => 51,
                'title' => 'license_management_show',
            ],
            [
                'id'    => 52,
                'title' => 'license_management_delete',
            ],
            [
                'id'    => 53,
                'title' => 'license_management_access',
            ],
            [
                'id'    => 54,
                'title' => 'brand_create',
            ],
            [
                'id'    => 55,
                'title' => 'brand_edit',
            ],
            [
                'id'    => 56,
                'title' => 'brand_show',
            ],
            [
                'id'    => 57,
                'title' => 'brand_delete',
            ],
            [
                'id'    => 58,
                'title' => 'brand_access',
            ],
            [
                'id'    => 59,
                'title' => 'supplier_create',
            ],
            [
                'id'    => 60,
                'title' => 'supplier_edit',
            ],
            [
                'id'    => 61,
                'title' => 'supplier_show',
            ],
            [
                'id'    => 62,
                'title' => 'supplier_delete',
            ],
            [
                'id'    => 63,
                'title' => 'supplier_access',
            ],
            [
                'id'    => 64,
                'title' => 'profile_password_edit',
            ],
            [
                'id'    => 65,
                'title' => 'location_access',
            ],
            [
                'id'    => 66,
                'title' => 'accounting_access',
            ],
        ];

        Permission::insert($permissions);
    }
}
