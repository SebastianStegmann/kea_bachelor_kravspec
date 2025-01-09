<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Spec;
use App\Models\SpecRow;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        User::factory()->create([
            'name' => 'John',
            'email' => 'test1@example.com',
        ]);

        $roles = [
            ['id' => 1, 'role' => 'admin'],
            ['id' => 2, 'role' => 'viewer'],
            // Add more roles as needed
        ];

        // Insert the roles into the database
        foreach ($roles as $role) {
            DB::table('roles')->insert($role);
        }

        // Ensure there are Specs to associate with SpecRows
        $specs = Spec::factory()->count(5)->create();

        // Create new rows for each Spec
        $specs->each(function ($spec) {
            $newRows = SpecRow::factory()
                ->count(2)
                ->newRow()
                ->create(['spec_id' => $spec->id]);

            // Create new versions for the newly created rows
            $newRows->each(function ($row) {
                $versionsToCreate = rand(1, 3);
                for ($i = 0; $i < $versionsToCreate; $i++) {
                    SpecRow::factory()
                        ->newVersion()
                        ->create([
                            'spec_id' => $row->spec_id,
                            'row_identifier' => $row->row_identifier,
                        ]);
                }
            });
        });


        $spec_role_user = [
            ['id' => 1, 'user_id' => 1, 'spec_id' => 1, 'role_id' => 1],
            ['id' => 2, 'user_id' => 1, 'spec_id' => 2, 'role_id' => 1],
            ['id' => 3, 'user_id' => 1, 'spec_id' => 3, 'role_id' => 1],
            ['id' => 4, 'user_id' => 1, 'spec_id' => 4, 'role_id' => 1],
            ['id' => 5, 'user_id' => 1, 'spec_id' => 5, 'role_id' => 1],
            ['id' => 6, 'user_id' => 2, 'spec_id' => 1, 'role_id' => 2],
        ];

        foreach ($spec_role_user as $sru) {
            DB::table('spec_role_user')->insert($sru);
        }
    }
}
