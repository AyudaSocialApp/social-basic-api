<?php

namespace App\Repositories;

use App\Models\Contributor;
use InfyOm\Generator\Common\BaseRepository;

class ContributorRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'names',
        'last_names',
        'privacy',
        'type_identifications_id',
        'nit_id',
        'type_contributors_id',
        'base64',
        'filetype',
        'preview',
        'cellphone_telephone_contact',
        'users_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Contributor::class;
    }


    public function getbigImage($id){
        $obj = $this->find($id);
        if (empty($obj)) {
            return Response::json(ResponseUtil::makeError('Contributor not found'), 404);
        }
        return $obj->base64;
    }
}
