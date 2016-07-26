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


    public function defineMaxid($maxId){
        $this->applyCriteria();
        $this->applyScope();

        try {
            if(is_null($maxId) || $maxId == '-'){
                return  $this->model->orderBy('id','DESC')->first()->id;
            }
        } catch (Exception $e) {

        }

        $this->resetModel();
        $this->resetScope();

        return $maxId;
    }

    /**
    * Obtener el listado de mis ayudas de un colaborador con todas las foraneas para detallar
    * de a 10 por vez teniendo en cuenta un ID maximo, descendentemente según el ID
    **/
    public function indexWithForeysOfContributor($idcontributor,$maxId)
    {

        $maxId = $this->defineMaxid($maxId);

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
            ->with('typehelp') // Ya esta
            ->where('id','<=',$maxId)
            ->where('contributors_id',$idcontributor)
            ->orderBy('id','DESC')
            ->take(20)
            ->get();

        $this->resetModel();
        $this->resetScope();

        if(count($results) > 0){
            $lastResultDesc = $results[count($results)-1];
            $maxId = $lastResultDesc->id - 1;
        }else{
            $maxId = -1;
        }

        return $this->parserResult(['list'=>$results,'maxId'=>$maxId]);
    }


    /**
    * Obtener el listado de mis ayudas de un necesitado con todas las foraneas para detallar
    * de a 10 por vez teniendo en cuenta un ID maximo, descendentemente según el ID
    **/
    public function indexWithForeysOfNeedy($idneedy,$maxId)
    {

        $maxId = $this->defineMaxid($maxId);

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
            ->take(20)
            ->get();

        $this->resetModel();
        $this->resetScope();

        if(count($results) > 0){
            $lastResultDesc = $results[count($results)-1];
            $maxId = $lastResultDesc->id - 1;
        }else{
            $maxId = -1;
        }

        return $this->parserResult(['list'=>$results,'maxId'=>$maxId]);
    }

    /**
    * Obtener el listado de todas las ayudas que aun no tienen colaborador (Necesitados)
    **/
    public function indexWithAllNeedy($maxId)
    {

        $maxId = $this->defineMaxid($maxId);

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
            ->take(6)
            ->get();

        $this->resetModel();
        $this->resetScope();

        if(count($results) > 0){
            $lastResultDesc = $results[count($results)-1];
            $maxId = $lastResultDesc->id - 1;
        }else{
            $maxId = -1;
        }

        return $this->parserResult(['list'=>$results,'maxId'=>$maxId]);
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
        }catch(Exception $e){
            return false;
        }
        
    }

    public function updateAsDelivered($input){
        try{
            $id_help = $input['id_help'];
            $help = $this->model->find($id_help);
            $help->delivered = $input['delivered'];
            $help->save();
            return $help->toArray();
        }catch(Exception $e){
            return false;
        }        
    }

    public function updateAsAccepted($input){
        try{
            $id_help = $input['id_help'];
            $help = $this->model->find($id_help);
            $help->accepted = $input['accepted'];
            $help->save();
            return $help->toArray();
        }catch(Exception $e){
            return false;
        }                
    }

}
