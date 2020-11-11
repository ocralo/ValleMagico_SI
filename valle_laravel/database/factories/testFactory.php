<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Avatar;
use App\Location;
use App\LocationSkin;
use App\MapSkin;
use App\Dissability;
use App\GameUser;
use App\MiniGame;
use App\GameUserRecord;
use App\LocationSkinMapSkin;
use App\Subject;
use App\SubjectMiniGame;
use App\Grade;
use App\Intelligence;
use App\Style;
use App\IntelligenceIndicator;
use App\DescriptionStyle;
use App\Competence;
use App\GuRecordIntelligenceIndDescStyle;
use App\Recomendation;

use Faker\Generator as Faker;

$factory->define(MapSkin::class, function (Faker $faker) {
    return [
    ];
});
$factory->define(GameUser::class, function (Faker $faker) {
    $first_name = mb_strtoupper($faker->firstName);
    $second_name= mb_strtoupper($faker->firstName);
    $first_surname= mb_strtoupper($faker->lastName);
    $second_surname= mb_strtoupper($faker->lastName);
    return [
        'first_name'=> $first_name,
        'second_name'=> $second_name,
        'first_surname'=> $first_surname,
        'second_surname'=> $second_surname,
        'headquarter_id'=> $faker->numberBetween($min = 1, $max = 1000),
        'grade_id'=> $faker->numberBetween($min = 1, $max = 10),
        'username'=> substr($first_name,0,1).substr($second_name,0,1).$first_surname.($faker->randomNumber($nbDigits = 4, $strict = true)),
    ];
});
$factory->define(GameUserRecord::class, function (Faker $faker) {
    return [
        'errors'=>$faker->randomDigitNotNull,
        'repeated_guide'=>$faker->randomDigitNotNull,
        'total_score'=>$faker->numberBetween($min = 1, $max = 100),
        'mini_game_id'=>$faker->numberBetween($min = 1, $max = 204),
        'game_user_id'=>$faker->numberBetween($min = 10000, $max = 20000),
    ];
});
$factory->define(GuRecordIntelligenceIndDescStyle::class, function (Faker $faker) {
    return [
        'game_user_record_id'=>$faker->numberBetween($min = 25000, $max = 30000),
        'intelligence_indicator_id'=>$faker->numberBetween($min = 300, $max = 429),
        'description_style_id'=>$faker->numberBetween($min = 700, $max = 707),
        'competence_id'=>$faker->numberBetween($min = 1, $max = 3),
        'percentage_value'=>$faker->numberBetween($min = 1, $max = 100),
        'vocational_orientation_id'=>$faker->numberBetween($min = 500, $max = 506)
    ];
});
// $factory->define(Recomendation::class, function (Faker $faker) {
//     return [
//         'performance_id'=>$faker->numberBetween($min = 1, $max = 4),
//         'subject_id'=>$faker->numberBetween($min = 1, $max = 6),
//         'hierarchy_id'=>$faker->numberBetween($min = 1, $max = 6),
//         'grade_id'=>$faker->numberBetween($min = 0, $max = 14),
//         'recomendation'=>$faker->sentence(6)
//     ];
// });
