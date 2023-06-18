<?php

    require_once '../../vendor/autoload.php';

    use gift\app\models\Prestation as Prestation;
    use gift\app\services\utils\Eloquent;
    use gift\app\models\Box as Box;

    Eloquent::init('../conf/gift.db.test.ini');

    $faker = \Faker\Factory::create('fr_FR');

    $testf = $faker->uuid();
    $testb = Box::all();

    echo getType($testf);
    echo getType($testb[0]->id);