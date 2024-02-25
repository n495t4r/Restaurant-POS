<?php
  
namespace Database\Seeders;
  
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
  
class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * 
     */
    public function run(): void
    {
        $user = User::create([
            'first_name' => 'Francis', 
            'last_name' => 'Onah', 
            'email' => 'onahfa@gmail.com',
            'password' => bcrypt('password')
        ]);
        
        $role = Role::create(['name' => 'Super Admin']);
         
        $permissions = Permission::pluck('id','id')->all();
       
        $role->syncPermissions($permissions);
         
        $user->assignRole([$role->id]);
    }
}