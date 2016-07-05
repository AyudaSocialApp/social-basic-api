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
}
