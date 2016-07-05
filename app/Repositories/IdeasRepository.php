<?php

namespace App\Repositories;

use App\Models\Ideas;
use InfyOm\Generator\Common\BaseRepository;

class IdeasRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'content',
        'users_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Ideas::class;
    }
}
