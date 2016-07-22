<?php

namespace App\Repositories;

use App\Models\Help;
use InfyOm\Generator\Common\BaseRepository;

class HelpRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'type_helps_id',
        'description',
        'date',
        'contributors_id',
        'needy_id',
        'place_delivery',
        'date_hour',
        'delivered'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Help::class;
    }


    /**
    * Obtener el listado de mis ayudas de un colaborador con todas las foraneas para detallar
    * de a 10 por vez teniendo en cuenta un ID maximo, descendentemente según el ID
    **/
    public function indexWithForeysOfContributor($idcontributor,$maxId)
    {

        $this->applyCriteria();
        $this->applyScope();

        $results = $this->model
            ->with('contributor')
            ->with('typehelp')
            ->with('needy')
            ->where('id','<=',$maxId)
            ->where('contributors_id',$idcontributor)
            ->orderBy('id','DESC')
            ->take(10)
            ->get();

        $this->resetModel();
        $this->resetScope();

        return $this->parserResult($results);
    }


    /**
    * Obtener el listado de mis ayudas de un necesitado con todas las foraneas para detallar
    * de a 10 por vez teniendo en cuenta un ID maximo, descendentemente según el ID
    **/
    public function indexWithForeysOfNeedy($idneedy,$maxId)
    {

        $this->applyCriteria();
        $this->applyScope();

        $results = $this->model
            ->with('contributor')
            ->with('typehelp')
            ->with('needy')
            ->where('id','<=',$maxId)
            ->where('needy_id',$idneedy)
            ->orderBy('id','DESC')
            ->take(10)
            ->get();

        $this->resetModel();
        $this->resetScope();

        return $this->parserResult($results);
    }

    /**
    * Obtener el listado de todas las ayudas que aun no tienen colaborador (Necesitados)
    **/
    public function indexWithAllNeedy($maxId)
    {

        $this->applyCriteria();
        $this->applyScope();

        $results = $this->model
            ->with('typehelp')
            ->with('needy')
            ->where('id','<=',$maxId)
            ->whereNull('contributors_id')
            ->orderBy('id','DESC')
            ->take(10)
            ->get();

        $this->resetModel();
        $this->resetScope();

        return $this->parserResult($results);
    }

    public function registerNewHelp($input)
    {
        date_default_timezone_set('America/Bogota');
        $input['date'] = date('Y-m-d');
        $input['delivered'] = false;
        $input['type_helps_id'] = $input['type_helps_id']['id'];
        return $this->create($input);
        
    }


    public function indexWithLastHelpOfNeedy($idneedy){
        $this->applyCriteria();
        $this->applyScope();

        $results = $this->model
            ->with('typehelp')
            ->where('needy_id',$idneedy)
            ->orderBy('id','DESC')
            ->take(10)
            ->get();

        $this->resetModel();
        $this->resetScope();

        return $this->parserResult($results);
    }


}
