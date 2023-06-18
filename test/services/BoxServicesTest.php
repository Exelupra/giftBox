<?php
declare(strict_types=1);

namespace gift\test\services\prestations;

require_once __DIR__ . '/../../vendor/autoload.php';

use gift\app\models\Categorie;
use gift\app\models\Prestation;
use gift\app\models\Box;
use gift\app\services\prestations\BoxServices;
use \PHPUnit\Framework\TestCase;
use Illuminate\Database\Capsule\Manager as DB ;
use gift\app\services\prestations\Exceptions\BoxServicesException;

final class BoxServicesTest extends TestCase {

    private static array $boxes  = [];
    private static array $prestations = [];
    private static array $categories = [];

    public static function setUpBeforeClass(): void
    {
        //créé une connexion à la base de données puis crée des catégories et des prestations et des box
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

        for($i=1; $i<=4; $i++){
            array_push(self::$prestations, Prestation::create([
                'id' => $faker->uuid(),
                'libelle' => $faker->word(),
                'description' => $faker->paragraph(3),
                'tarif' => $faker->randomFloat(2, 0, 100),
                'unite' => $faker->randomDigit(),
                'img' => 'img.png',
                'cat_id' => ($i%2 == 0 ? $c1->id : $c2->id)
            ]));
        }


        $b1 = new Box([
            'id' => $faker->uuid(),
            'token' => $faker->uuid(),
            'libelle' => $faker->word(),
            'description' => $faker->paragraph(3),
            'montant' => 0,
            'kdo' => 0,
            'message_kdo' => "",
            'statut' => 1,
        ]);

        $b2 = new Box([
            'id' => $faker->uuid(),
            'token' => $faker->uuid(),
            'libelle' => $faker->word(),
            'description' => $faker->paragraph(3),
            'montant' => 0,
            'kdo' => 0,
            'message_kdo' => "",
            'statut' => 1,
        ]);

        self::$boxes = [$b1, $b2];

        self::$boxes[0]->save();
        self::$boxes[1]->save();

    }

    public static function tearDownAfterClass(): void
    {

        $box = Box::all();

        foreach($box as $b){
            foreach($b->prestations as $p){
                $b->prestations()->detach($p->id);
            }
            $b->delete();
        }

        $categorie = Categorie::all();
        foreach($categorie as $c){
            foreach($c->prestations as $p){
                $p->delete();
            }
            $c->delete();
        }

    }

    public function testGetAllBoxes(): void
    {
        $boxes = BoxServices::getBoxs();
        
        $this->assertEquals(count(self::$boxes), count($boxes));
        $this->assertEquals(self::$boxes[0]->id, $boxes[0]['id']);
        $this->assertEquals(self::$boxes[0]->token, $boxes[0]['token']);
        $this->assertEquals(self::$boxes[0]->libelle, $boxes[0]['libelle']);
        $this->assertEquals(self::$boxes[0]->description, $boxes[0]['description']);
        $this->assertEquals(self::$boxes[1]->id, $boxes[1]['id']);
        $this->assertEquals(self::$boxes[1]->token, $boxes[1]['token']);
        $this->assertEquals(self::$boxes[1]->libelle, $boxes[1]['libelle']);
        $this->assertEquals(self::$boxes[1]->description, $boxes[1]['description']);

    }

    public function testGetBoxById(): void {
        
        $box = BoxServices::getBoxById(self::$boxes[0]->id);

        $this->assertEquals(self::$boxes[0]->id, $box['id']);
        $this->assertEquals(self::$boxes[0]->token, $box['token']);
        $this->assertEquals(self::$boxes[0]->libelle, $box['libelle']);
        $this->assertEquals(self::$boxes[0]->description, $box['description']);

        $this->expectException(BoxServicesException::class);
        $box = BoxServices::getBoxById('00000000-0000-0000-0000-000000000000');

    }

    public function testCreateBox(): void {

        $uuid = \Faker\Factory::create('fr_FR')->uuid();

        $newbox = BoxServices::createBox([
            'id' => $uuid,
            'token' => \Faker\Factory::create('fr_FR')->uuid(),
            'libelle' => 'test',
            'description' => 'test',
            'montant' => 0,
            'kdo' => 0,
            'message_kdo' => "",
            'statut' => 1,
        ]);

        $testbox = Box::find($uuid);

        $this->assertEquals('test', $newbox['libelle']);
        $this->assertEquals('test', $newbox['description']);
        $this->assertEquals(0, $newbox['montant']);
        $this->assertEquals(1, $newbox['statut']);

        $this->assertEquals(0,count($testbox->prestations));

        $this->expectException(BoxServicesException::class);
        $newbox = BoxServices::createBox([
            'id' => \Faker\Factory::create('fr_FR')->uuid(),
            'token' => \Faker\Factory::create('fr_FR')->uuid(),
            'libelle' => 0,
            'description' => 0,
            'montant' => 0,
            'kdo' => 1,
            'message_kdo' => "",
            'statut' => 1,
        ]);
    }

    public function testAddPrestation(): void {

        $box = BoxServices::getBoxById(self::$boxes[1]->id);
        $prestation = Prestation::find(self::$prestations[0]->id);

        BoxServices::addPrestation([
            'boxid' => $box['id'],
            'prestid' => $prestation['id'],
            'qte' => 2
        ]);

        $this->assertEquals(1, count($box->prestations));
        $this->assertEquals(self::$prestations[0]->id, $box->prestations[0]->id);
        $this->assertEquals(2, $box->prestations[0]->contenu->quantite);
        $this->assertEquals(20, $box->montant);

    }

}