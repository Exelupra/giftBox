<?php
    namespace gift\app\models;
    
    use gift\app\models\Categorie as Categorie;
    use gift\app\models\Box as Box;

    class Prestation extends \Illuminate\Database\Eloquent\Model {
        protected $table = 'prestation';
        protected $primaryKey = 'id';
        protected $keyType = 'string';

        protected $fillable = [
            'id',
            'libelle',
            'description',
            'tarif',
            'unite',
            'img',
            'cat_id'
        ];

        public $timestamps = false;
        
        public function box() {
            return $this->belongsToMany(Box::class, 'box2prestation', 'presta_id', 'box_id');
        }

        public function categorie() {
            return $this->belongsTo(Categorie::class, 'cat_id');
        }
    }
?>