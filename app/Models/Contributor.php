<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="Contributor",
 *      required={names, last_names, privacy, type_contributors_id, base64, filetype, cellphone_telephone_contact, users_id},
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
 *          property="privacy",
 *          description="privacy",
 *          type="boolean"
 *      ),
 *      @SWG\Property(
 *          property="type_identifications_id",
 *          description="type_identifications_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="nit_id",
 *          description="nit_id",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="type_contributors_id",
 *          description="type_contributors_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="base64",
 *          description="base64",
 *          type="string",
 *          format="binary"
 *      ),
 *      @SWG\Property(
 *          property="filetype",
 *          description="filetype",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="cellphone_telephone_contact",
 *          description="cellphone_telephone_contact",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="users_id",
 *          description="users_id",
 *          type="integer",
 *          format="int32"
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
class Contributor extends Model
{
    use SoftDeletes;

    public $table = 'contributors';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'names',
        'last_names',
        'privacy',
        'type_identifications_id',
        'nit_id',
        'type_contributors_id',
        'base64',
        'filetype',
        'preview',
        'cellphone_telephone_contact',
        'users_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'names' => 'string',
        'last_names' => 'string',
        'privacy' => 'boolean',
        'type_identifications_id' => 'integer',
        'nit_id' => 'string',
        'type_contributors_id' => 'integer',
        'filetype' => 'string',
        'cellphone_telephone_contact' => 'string',
        'users_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'names' => 'required',
        'last_names' => 'required',
        'privacy' => 'required',
        'type_contributors_id' => 'required',
        'base64' => 'required',
        'filetype' => 'required',
        'cellphone_telephone_contact' => 'required',
        'users_id' => 'required'
    ];
}
