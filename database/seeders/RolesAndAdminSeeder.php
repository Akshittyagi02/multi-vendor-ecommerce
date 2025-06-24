<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Vendor; // Import Vendor model to check vendor status
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class RolesAndAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // --- Create Permissions (This section remains the same as it defines all permissions) ---
        Permission::firstOrCreate(['name' => 'view dashboard']);
        Permission::firstOrCreate(['name' => 'manage roles']);
        Permission::firstOrCreate(['name' => 'manage permissions']);
        Permission::firstOrCreate(['name' => 'manage users']);
        Permission::firstOrCreate(['name' => 'approve vendors']);
        Permission::firstOrCreate(['name' => 'disapprove vendors']);
        Permission::firstOrCreate(['name' => 'view all vendors']);
        Permission::firstOrCreate(['name' => 'view vendor payouts']);
        Permission::firstOrCreate(['name' => 'process payouts']);
        Permission::firstOrCreate(['name' => 'approve products']);
        Permission::firstOrCreate(['name' => 'disapprove products']);
        Permission::firstOrCreate(['name' => 'view all products']);
        Permission::firstOrCreate(['name' => 'manage categories']);
        Permission::firstOrCreate(['name' => 'manage brands']);
        Permission::firstOrCreate(['name' => 'manage attributes']);
        Permission::firstOrCreate(['name' => 'view all orders']);
        Permission::firstOrCreate(['name' => 'manage sitewide settings']);
        Permission::firstOrCreate(['name' => 'view reports']);
        Permission::firstOrCreate(['name' => 'create products']);
        Permission::firstOrCreate(['name' => 'edit own products']);
        Permission::firstOrCreate(['name' => 'delete own products']);
        Permission::firstOrCreate(['name' => 'view own products']);
        Permission::firstOrCreate(['name' => 'manage own shop settings']);
        Permission::firstOrCreate(['name' => 'view own orders']);
        Permission::firstOrCreate(['name' => 'update own order status']);
        Permission::firstOrCreate(['name' => 'request payouts']);
        Permission::firstOrCreate(['name' => 'view own earnings']);
        Permission::firstOrCreate(['name' => 'view own reviews']);
        Permission::firstOrCreate(['name' => 'view public products']);
        Permission::firstOrCreate(['name' => 'place orders']);
        Permission::firstOrCreate(['name' => 'view own order history']);
        Permission::firstOrCreate(['name' => 'submit product reviews']);

        // --- Create Roles (Ensure roles exist) ---
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $vendorRole = Role::firstOrCreate(['name' => 'vendor']);
        $customerRole = Role::firstOrCreate(['name' => 'customer']);


        // --- Assign Permissions to Roles (This section remains the same) ---
        $adminRole->givePermissionTo(Permission::all());
        $vendorRole->givePermissionTo([
            'view dashboard', 'create products', 'edit own products', 'delete own products',
            'view own products', 'manage own shop settings', 'view own orders',
            'update own order status', 'request payouts', 'view own earnings',
            'view own reviews', 'view public products',
        ]);
        $customerRole->givePermissionTo([
            'view public products', 'place orders', 'view own order history',
            'submit product reviews',
        ]);


        // --- Ensure Default Admin User ---
        $defaultAdminUser = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'is_admin' => true, // Ensure this is true upon creation
            ]
        );
        $this->command->info('Default admin user (admin@example.com) ensured.');


        // --- Loop through ALL users to synchronize roles based on flags/status ---
        $allUsers = User::with('vendor')->get(); // Eager load vendor to check status efficiently

        foreach ($allUsers as $user) {
            // Priority 1: Admin Role (if is_admin is true)
            if ($user->is_admin) {
                // If user is intended to be admin, sync only 'admin' role
                $user->syncRoles(['admin']); // syncRoles will remove other roles and assign only 'admin'
                $user->syncPermissions(Permission::all()); // Give all permissions
                $this->command->info("Synchronized: User '{$user->email}' is now ONLY 'admin'.");
            }
            // Priority 2: Vendor Role (if not admin, but has an approved vendor profile)
            elseif ($user->vendor && $user->vendor->is_approved) {
                // If user has an approved vendor profile and is not admin, sync only 'vendor' role
                $user->syncRoles(['vendor']); // Remove other roles and assign only 'vendor'
                $this->command->info("Synchronized: User '{$user->email}' is now ONLY 'vendor'.");
            }
            // Priority 3: Customer Role (if neither admin nor approved vendor)
            else {
                // If user is neither admin nor approved vendor, ensure they are 'customer'
                if (!$user->hasRole('customer')) {
                    $user->syncRoles(['customer']); // Remove other roles and assign only 'customer'
                    $this->command->info("Synchronized: User '{$user->email}' is now ONLY 'customer'.");
                }
            }
        }
    }
}
