<?php

namespace App\Repositories;

use App\Models\Example;
use InfyOm\Generator\Common\BaseRepository;

class ExampleRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'age'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Example::class;
    }
}
