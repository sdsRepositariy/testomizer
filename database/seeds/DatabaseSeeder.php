<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CountriesTableSeeder::class);
        $this->call(LocationSeeder::class);
        $this->call(CommunityTypesTableSeeder::class);
        $this->call(CommunitiesTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(ObjectsTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(UserGroupsTableSeeder::class);
        $this->call(PeriodsTableSeeder::class);
        $this->call(LevelsTableSeeder::class);
        $this->call(StreamsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(PermissionRoleTableSeeder::class);
        $this->call(TaskFoldersTableSeeder::class);
        $this->call(TaskItemsTableSeeder::class);
    }
}
