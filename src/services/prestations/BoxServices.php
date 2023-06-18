<?php

namespace gift\app\services\prestations;

use gift\app\models\Box as Box;
use gift\app\models\Prestation;
use gift\app\services\utils\Eloquent;
use gift\app\services\prestations\Exceptions\BoxServicesException;

//Eloquent::init(__DIR__.'/../../conf/gift.db.conf.ini');

class BoxServices {

    public static function getBoxs(): array {
        return Box::all()->toArray();
    }

    public static function getBoxById($id){
        $box = Box::find($id);
        if($box != null){
            return $box->toArray();
        } else {
            throw new BoxServicesException("Box introuvable");
        }
    }

    public static function createBox($tab){
        $filterlibelle = filter_var($tab['libelle'], FILTER_SANITIZE_SPECIAL_CHARS);
        $filterdescription = filter_var($tab['description'], FILTER_SANITIZE_SPECIAL_CHARS);
        if($tab['libelle'] != $filterlibelle) {
            throw new BoxServicesException("Erreur de saisie");
        }
        if($tab['description'] != $filterdescription){
            throw new BoxServicesException("Erreur de saisie");
        }
        if($tab['kdo'] == 1){
            if($tab['message_kdo'] == ""){
                throw new BoxServicesException("Erreur de saisie");
            }
        }
        $box = new Box($tab);
        $box->save();
        return $box->toArray();
    }

    public static function getPrestationByBox($id){
        $box = Box::find($id);
        $prestations = $box->prestations;
        return $prestations->toArray();
    }

    public static function addPrestation($tab){
        $qte = $tab['qte'];
        $box = Box::find($tab['boxid']);
        $prestation = Prestation::find($tab['prestid']);
        if($box->prestations->contains($tab['prestid'])){
            $qte += $box->prestations->find($tab['prestid'])->contenu->quantite;
            $box->prestations()->updateExistingPivot($tab['prestid'], ['quantite' => $qte]);
        } else {
            $box->prestations()->attach($tab['prestid'], ['quantite' => $qte]);
        }

        $box->montant += $prestation->tarif*$qte;

        $box->save();
        
        return $box->toArray();
    }

    public static function delPrestation($tab){
        $box = Box::find($tab['boxid']);
        $box->prestations()->detach($tab['prestid']);
        return $box->toArray();
    }

    public static function updateBox2Presta($tab){
        $box = Box::find($tab['boxid']);
        if($tab['qte'] == $box->prestations->find($tab['prestid'])->contenu->quantite){
            $box->prestations()->detach($tab['prestid']);
        } else {
            $qte = $box->prestations->find($tab['prestid'])->contenu->quantite-$tab['qte'];
            $box->prestations()->updateExistingPivot($tab['prestid'], ['quantite' => $qte]);
        }
        
        return $box->toArray();
    }
    
}