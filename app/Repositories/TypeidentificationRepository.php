<?php

namespace App\Repositories;

use App\Models\Typeidentification;
use InfyOm\Generator\Common\BaseRepository;

class TypeidentificationRepository extends BaseRepository
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
        return Typeidentification::class;
    }
}
