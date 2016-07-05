<?php

namespace App\Repositories;

use App\Models\Typehelp;
use InfyOm\Generator\Common\BaseRepository;

class TypehelpRepository extends BaseRepository
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
        return Typehelp::class;
    }
}
