<?php

namespace App\Repositories;

use App\User;
use InfyOm\Generator\Common\BaseRepository;
use DB;
use Helpers\Image;
use Hash;
use App\Repositories\ContributorRepository;
use App\Repositories\NeedyRepository;

class UserRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'email'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return User::class;
    }

    public function register($input,$idrol){
      
      try {

        $tablerol = "";
        $himage = new Image(' ');
        $newuser = [
          'email' => strtolower($input['names']),
          'name' => ucfirst(strtolower($input['names']))." ".ucfirst(strtolower($input['last_names'])),
          'password' => Hash::make($input['password'])
        ];

        if($idrol == 1){
            // contributors
          $tablerol = 'contributors';
          $reporol = app(ContributorRepository::class);
          $newrol = [
            "names" => ucfirst(strtolower($input['names'])),
            "last_names" => ucfirst(strtolower($input['last_names'])),
            "privacy" => $input['privacy'],
            "type_identifications_id" => $input['type_identifications_id']['id'],
            "nit_id" => $input['nit_id'],
            "type_contributors_id" => $input['type_contributors_id'],
            "base64" => $himage->resizeBase64img($input['base64']['base64'],strtolower($input['base64']['filetype']),80,71),
            "filetype" => strtolower($input['base64']['filetype']),
            "preview" => $himage->resizeBase64andScaleWidth($input['base64']['base64'],strtolower($input['base64']['filetype']),300),
            "cellphone_telephone_contact" => $input['cellphone_telephone_contact']
          ];
        }else{
          // needies
          $tablerol = 'needies';
          $reporol = app(NeedyRepository::class);
          $newrol = [
            "names" => $input['names'],
            "last_names" => $input['last_names'],
            "type_identifications_id" => $input['type_identifications_id']['id'],
            "identification" => $input['identification'],
            "history" => $input['history'],
            "filetype" => strtolower($input['base64']['filetype']),
            "preview" => $himage->resizeBase64andScaleWidth($input['base64']['base64'],strtolower($input['base64']['filetype']),300),
            "cellphone_telephone_contact" => $input['cellphone_telephone_contact'],
            "contributor" => $input['contributor'],
            "city" => $input['city']
          ];
        }

        $id_user = "";
        $id_rol = "";

        // $id_user,$newuser,$id_rol,$newrol,$tablerol
        DB::transaction(function () use (&$id_user,$newuser,&$id_rol,$newrol,$tablerol) {

          $id_user = DB::table('users')->insertGetId($newuser);
          $newrol['users_id'] = $id_user;
          $id_rol = DB::table($tablerol)->insertGetId($newrol);

        });

        $user = $this->find($id_user);
        $rol = $reporol->find($id_rol);

        return ['user'=>$user,'rol'=>$rol];

      } catch (Exception $e) {
        return false;
      }

    }
}
