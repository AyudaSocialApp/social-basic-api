<?php

namespace App\Repositories;

use App\Models\Typeneedy;
use InfyOm\Generator\Common\BaseRepository;

class TypeneedyRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Typeneedy::class;
    }
}
