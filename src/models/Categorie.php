<?php
    namespace gift\app\models;

    use gift\app\models\Prestation as Prestation;

    class Categorie extends \Illuminate\Database\Eloquent\Model {
        protected $table = 'categorie';
        protected $primaryKey = 'id';

        protected $fillable = [
            'libelle',
            'description'
        ];

        public $timestamps = false;
        
        public function prestations() {
            return $this->hasMany(Prestation::class, 'cat_id');
        }
    }
?>