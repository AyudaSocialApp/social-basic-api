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
            ->with(['contributor' => function($q)
                    {
                        $q->addSelect(['id', 'names', 'last_names', 'privacy', 'type_identifications_id', 'nit_id', 'type_contributors_id', 'filetype', 'cellphone_telephone_contact', 'users_id', 'created_at', 'updated_at', 'deleted_at', 'preview', 'name_business']);
                    }])
            ->with(['needy' => function($q)
                    {
                        $q->addSelect(['id', 'names', 'last_names', 'identification', 'type_identifications_id', 'history', 'contributor', 'cellphone_telephone_contact', 'users_id', 'created_at', 'updated_at', 'deleted_at', 'city', 'preview', 'filetype', 'type_needy_id']);
                    }])
            ->with('typehelp')
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
            ->with(['contributor' => function($q)
                    {
                        $q->addSelect(['id', 'names', 'last_names', 'privacy', 'type_identifications_id', 'nit_id', 'type_contributors_id', 'filetype', 'cellphone_telephone_contact', 'users_id', 'created_at', 'updated_at', 'deleted_at', 'preview', 'name_business']);
                    }])
            ->with('typehelp')
            ->with(['needy' => function($q)
                    {
                        $q->addSelect(['id', 'names', 'last_names', 'identification', 'type_identifications_id', 'history', 'contributor', 'cellphone_telephone_contact', 'users_id', 'created_at', 'updated_at', 'deleted_at', 'city', 'preview', 'filetype', 'type_needy_id']);
                    }])
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
            ->with(['needy' => function($q)
                    {
                        $q->addSelect(['id', 'names', 'last_names', 'identification', 'type_identifications_id', 'history', 'contributor', 'cellphone_telephone_contact', 'users_id', 'created_at', 'updated_at', 'deleted_at', 'city', 'preview', 'filetype', 'type_needy_id']);
                    }])
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

    public function updateAsColaborator($input){

        try{
            $id_help = $input['id_help'];
            $help = $this->model->find($id_help);
            $help->contributors_id = $input['id_contributor'];
            $help->type_helps_id = $input['type_helps_id']['id'];
            $help->description = $input['description'];
            $help->place_delivery = $input['place_delivery'];
            $help->date_hour = $input['date_hour'];
            $help->save();
            return $help->toArray();
        }catch(Exceptio $e){
            return false;
        }
        
    }

    public function updateAsDelivered(){
        
    }

    public function updateAsAccepted(){
        
    }

}
