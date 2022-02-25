<?php

/** @var \Illuminate\Database\Eloquent\Factory  $factory */

use Faker\Generator as Faker;
use WalkerChiu\Firewall\Models\Entities\Setting;
use WalkerChiu\Firewall\Models\Entities\SettingLang;

$factory->define(Setting::class, function (Faker $faker) {
    return [
        'morph_type' => 'WalkerChiu\Group\Models\Entities\Group',
        'morph_id'   => 1,
        'identifier' => $faker->slug
    ];
});

$factory->define(SettingLang::class, function (Faker $faker) {
    return [
        'code'  => $faker->locale,
        'key'   => $faker->randomElement(['name', 'description']),
        'value' => $faker->sentence
    ];
});
