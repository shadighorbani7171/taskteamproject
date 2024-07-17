<?php




namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      
        $adminDashboardPermission = Permission::updateOrCreate(['name' => 'view admindashboard', 'guard_name' => 'web']);
        $ownerDashboardPermission = Permission::updateOrCreate(['name' => 'view ownerdashboard', 'guard_name' => 'web']);

        
        $superAdminRole = Role::updateOrCreate(['name' => 'super_admin']);
        $ownerRole = Role::updateOrCreate(['name' => 'owner']);

      
        $superAdminRole->givePermissionTo($adminDashboardPermission);
        $ownerRole->givePermissionTo($ownerDashboardPermission);

        $superAdminUser = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password123'), ]
        );
        $superAdminUser->assignRole($superAdminRole);

        $ownerUser = User::updateOrCreate(
            ['email' => 'owner@example.com'],
            [
                'name' => 'Owner',
                'password' => Hash::make('password123'),
            ]
        );
        $ownerUser->assignRole($ownerRole);
    }
}
