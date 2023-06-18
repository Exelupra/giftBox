<?php
declare(strict_types=1);

namespace gift\test\services\prestations;

require_once __DIR__ . '/../../vendor/autoload.php';

use gift\app\models\Categorie;
use gift\app\models\Prestation;
use gift\app\services\prestations\PrestationsServices;
use \PHPUnit\Framework\TestCase;
use Illuminate\Database\Capsule\Manager as DB ;

final class PrestationsServicesTest extends TestCase
{

    private static array $prestations  = [];
    private static array $categories = [];
    
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        $db = new DB();
        $db->addConnection(parse_ini_file(__DIR__ . '/../../src/conf/gift.db.test.ini'));
        $db->setAsGlobal();
        $db->bootEloquent();
        $faker = \Faker\Factory::create('fr_FR');

        $c1= Categorie::create([
            'libelle' => $faker->word(),
            'description' => $faker->paragraph(3)
        ]);
        $c2=Categorie::create([
            'libelle' => $faker->word(),
            'description' => $faker->paragraph(4)
        ]);
        self::$categories= [$c1, $c2];

        $tab = [];

        for ($i=1; $i<=4; $i++) {
            $p = new Prestation([
                'id' => $faker->uuid(),
                'libelle' => $faker->word(),
                'description' => $faker->paragraph(3),
                'tarif' => $faker->randomFloat(2, 0, 100),
                'unite' => $faker->randomElement(['jour', 'mois', 'année'])
            ]);
            array_push($tab, $p);
        }


        $tab[0]->categorie()->associate($c1); $tab[0]->save();
        $tab[1]->categorie()->associate($c1); $tab[1]->save();
        $tab[2]->categorie()->associate($c2); $tab[2]->save();
        $tab[3]->categorie()->associate($c2); $tab[3]->save();

        foreach($tab as $p){
            array_push(self::$prestations, $p);
        }

    }

    public static function tearDownAfterClass(): void
    {
        foreach(self::$categories as $c){
            foreach($c->prestations as $p){
                $p->delete();
            }
            $c->delete();
        }

    }


    public function testgetCategories(): void {

        $categories = PrestationsServices::getCategories();

        $this->assertEquals(count(self::$categories), count($categories));
        $this->assertEquals(self::$categories[0]['id'], $categories[0]['id']);
        $this->assertEquals(self::$categories[0]['libelle'], $categories[0]['libelle']);
        $this->assertEquals(self::$categories[0]['description'], $categories[0]['description']);
        $this->assertEquals(self::$categories[1]['libelle'], $categories[1]['libelle']);
        $this->assertEquals(self::$categories[1]['description'], $categories[1]['description']);
        $this->assertEquals(self::$categories[1]['id'], $categories[1]['id']);
    }

    public function testgetCategorieById(): void {

        $prestationService = new PrestationsServices();
        $categorie = $prestationService->getCategorieById(self::$categories[0]['id']);

        $this->assertEquals(self::$categories[0]['id'], $categorie['id']);
        $this->assertEquals(self::$categories[0]['libelle'], $categorie['libelle']);
        $this->assertEquals(self::$categories[0]['description'], $categorie['description']);

        $this->expectException(\gift\app\services\prestations\Exceptions\PrestationsServicesNotFoundException::class);
        $prestationService->getCategorieById(-1);
    }
    public function testgetPrestationById(): void
    {

        print_r(self::$prestations[0]);
        $prestation = PrestationsServices::getPrestationById(self::$prestations[0]['id']);

        $this->assertEquals(self::$prestations[0]['id'], $prestation['id']);
        $this->assertEquals(self::$prestations[0]['libelle'], $prestation['libelle']);
        $this->assertEquals(self::$prestations[0]['description'], $prestation['description']);
        $this->assertEquals(self::$prestations[0]['tarif'], $prestation['tarif']);
        $this->assertEquals(self::$prestations[0]['unite'], $prestation['unite']);

        $this->expectException(\gift\app\services\prestations\Exceptions\PrestationsServicesNotFoundException::class);
        PrestationsServices::getPrestationById('AAAAAAA');
    }



}