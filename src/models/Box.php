<?php
    namespace gift\app\models;

    use gift\app\models\Prestation as Prestation;
    class Box extends \Illuminate\Database\Eloquent\Model {
        protected $table = 'box';
        protected $primaryKey = 'id';
        public $keyType = 'string';

        public $fillable = ['id', 'token', 'libelle', 'description', 'kdo', 'message_kdo', 'montant', 'statut'];

        const CREATED = 1;
        const VALIDATED = 2;
        const PAYED = 3;
        const DELIVERED = 4;
        const USED = 5;

        public function prestations() {
            return $this->belongsToMany(Prestation::class, 'box2presta', 'box_id', 'presta_id')
            ->WithPivot('quantite')->as('contenu');
        }
    }
?>