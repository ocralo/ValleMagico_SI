<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(DestinyHierarchySeeder::class);
        $this->call(PermissionTableSeeder::class);
        $this->call(RolTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(UserHierarchiesTableSeeder::class);
        $this->call(GradesTableSeeder::class);
        $this->call(SubjectsTableSeeder::class);
        $this->call(DissabilityTableSeeder::class);
        $this->call(LocationsTableSeeder::class);
        $this->call(MiniGamesTableSeeder::class);
        $this->call(SubjectMiniGamesTableSeeder::class);
        $this->call(LocationSkinsTableSeeder::class);
        $this->call(CompetencesTableSeeder::class);
        $this->call(IntelligencesTableSeeder::class);
        $this->call(IntelligenceIndicatorsTableSeeder::class);
        $this->call(StylesTableSeeder::class);
        $this->call(DescriptionStylesTableSeeder::class);
        $this->call(AvatarsTableSeeder::class);

        factory(App\MapSkin::class, 1)
        ->create();
        factory(App\GameUser::class, 1000)
        ->create()
        ->each(function ($user) {
            for ($i=0; $i < 5; $i++) {
                $user->game_records()->save(factory(App\GameUserRecord::class)->make());
            }
        });

        $this->call(GameUsersTableSeeder::class);
        $this->call(DissabilityGameUserTableSeeder::class);
        $this->call(LocationSkinMapSkinTableSeeder::class);
        $this->call(VocationalsOrientationsTableSeeder::class);
        $this->call(PerformancesTableSeeder::class);
        $this->call(RecomendationsTableSeeder::class);

        factory(App\GuRecordIntelligenceIndDescStyle::class, 50)
            ->create();
    }
}