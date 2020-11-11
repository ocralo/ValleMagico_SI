<?php

use Illuminate\Database\Seeder;
use App\UserHierarchy;

class UserHierarchiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $new_hierarchy_admin = new UserHierarchy();
        $new_hierarchy_admin->user_id = 1000;
        $new_hierarchy_admin->destiny_hierarchy_id = 1;
        $new_hierarchy_admin->save();

        $new_hierarchy_admin_2 = new UserHierarchy();
        $new_hierarchy_admin_2->user_id = 1000;
        $new_hierarchy_admin_2->destiny_hierarchy_id = 2;
        $new_hierarchy_admin_2->save();

        $new_hierarchy_cauca = new UserHierarchy();
        $new_hierarchy_cauca->user_id = 1001;
        $new_hierarchy_cauca->destiny_hierarchy_id = 2;
        $new_hierarchy_cauca->save();
    }
}
