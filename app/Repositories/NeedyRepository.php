<?php

namespace App\Repositories;

use App\Models\Needy;
use InfyOm\Generator\Common\BaseRepository;

class NeedyRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'names',
        'last_names',
        'identification',
        'type_identifications_id',
        'history',
        'contributor',
        'cellphone_telephone_contact',
        'users_id',
        'preview',
        'filetype'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Needy::class;
    }

    public function getbigImage($id){
        $obj = $this->find($id);
        if (empty($obj)) {
            return Response::json(ResponseUtil::makeError('Contributor not found'), 404);
        }
        return $obj->base64;
    }
}
