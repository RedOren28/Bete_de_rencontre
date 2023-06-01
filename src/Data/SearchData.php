<?php
namespace App\Data;

use App\Entity\Poil;
use App\Entity\Race;
use App\Entity\Animal;
use App\Entity\Espece;
use App\Entity\Regime;
use App\Entity\Annonce;
use App\Entity\Couleur;

class SearchData
{
    /**
     * @var string
     */
    public $q = '';

    /**
     * @var boolean
     */
    public $sexes = [];

    /**
     * @var boolean
     */
    public $vaccins = [];

    /**
     * @var boolean
     */
    public $vermifugations = [];
    
    /**
     * @var Espece[]
     */
    public $especes = [];

    /**
     * @var Poil[]
     */
    public $poils = [];

    /**
     * @var Couleur[]
     */
    public $couleurs = [];

    /**
     * @var Race[]
     */
    public $races = [];

    /**
     * @var Regime[]
     */
    public $regimes = [];
}