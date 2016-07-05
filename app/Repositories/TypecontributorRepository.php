<?php

namespace App\Repositories;

use App\Models\Typecontributor;
use InfyOm\Generator\Common\BaseRepository;

class TypecontributorRepository extends BaseRepository
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
        return Typecontributor::class;
    }
}
