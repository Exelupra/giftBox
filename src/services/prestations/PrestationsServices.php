<?php

namespace gift\app\services\prestations;

use gift\app\models\Categorie as Categorie;
use gift\app\models\Prestation as Prestation;
use gift\app\models\Box as Box;
use gift\app\services\utils\Eloquent as Eloquent;
use Slim\Exception\HttpNotFoundException;
use gift\app\services\prestations\Exceptions\PrestationsServicesNotFoundException;

class PrestationsServices {

    public static function getCategories() {
        return Categorie::all()->toArray();
    }

    public static function getCategorieById($id){
        $categorie = Categorie::find($id);
        if($categorie != null){
            return $categorie->toArray();
        } else {
            throw new PrestationsServicesNotFoundException();
        }
    }

    public static function getPrestationById($id){
        $prestation = Prestation::find($id);
        if($prestation != null){
            return $prestation->toArray();
        } else {
            throw new PrestationsServicesNotFoundException();
        }
    }

    public static function getPrestationsByCategorie($id){
        return Categorie::where('id', $id)->first()->prestations()->get()->toArray();
    }

    public static function getPrestations(): array {
        return Prestation::all()->toArray();
    }

    public static function createCategorie($tab){
        $filterlibelle = filter_var($tab['libelle'], FILTER_SANITIZE_SPECIAL_CHARS);
        $filterdescription = filter_var($tab['description'], FILTER_SANITIZE_SPECIAL_CHARS);
        if($tab['libelle'] != $filterlibelle) {
            throw new \Exception("Erreur de saisie");
        }
        if($tab['description'] != $filterdescription){
            throw new \Exception("Erreur de saisie");
        }
        $categorie = new Categorie($tab);
        $categorie->save();
        return $categorie->toArray();
    }
    
}

?>