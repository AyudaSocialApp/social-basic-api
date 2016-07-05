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
        'delivered',
        'type_needy_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Help::class;
    }
}
