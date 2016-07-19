<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="Needy",
 *      required={names, last_names, history, cellphone_telephone_contact, users_id},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="names",
 *          description="names",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="last_names",
 *          description="last_names",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="history",
 *          description="history",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="contributor",
 *          description="contributor",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="created_at",
 *          description="created_at",
 *          type="string",
 *          format="date-time"
 *      ),
 *      @SWG\Property(
 *          property="updated_at",
 *          description="updated_at",
 *          type="string",
 *          format="date-time"
 *      )
 * )
 */
class Needy extends Model
{
    use SoftDeletes;

    public $table = 'needies';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'names',
        'last_names',
        'identification',
        'type_identifications_id',
        'history',
        'contributor',
        'preview',
        'cellphone_telephone_contact',
        'users_id',
        'filetype',
        'base64',
        'type_needy_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'names' => 'string',
        'last_names' => 'string',
        'history' => 'string',
        'contributor' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [];
}
