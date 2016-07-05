<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateTypeneedyAPIRequest;
use App\Http\Requests\API\UpdateTypeneedyAPIRequest;
use App\Models\Typeneedy;
use App\Repositories\TypeneedyRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController as InfyOmBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use InfyOm\Generator\Utils\ResponseUtil;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class TypeneedyController
 * @package App\Http\Controllers\API
 */

class TypeneedyAPIController extends InfyOmBaseController
{
    /** @var  TypeneedyRepository */
    private $typeneedyRepository;

    public function __construct(TypeneedyRepository $typeneedyRepo)
    {
        $this->typeneedyRepository = $typeneedyRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/typeneedies",
     *      summary="Get a listing of the Typeneedies.",
     *      tags={"Typeneedy"},
     *      description="Get all Typeneedies",
     *      produces={"application/json"},
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="array",
     *                  @SWG\Items(ref="#/definitions/Typeneedy")
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function index(Request $request)
    {
        $this->typeneedyRepository->pushCriteria(new RequestCriteria($request));
        $this->typeneedyRepository->pushCriteria(new LimitOffsetCriteria($request));
        $typeneedies = $this->typeneedyRepository->all();

        return $this->sendResponse($typeneedies->toArray(), 'Typeneedies retrieved successfully');
    }

    /**
     * @param CreateTypeneedyAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/typeneedies",
     *      summary="Store a newly created Typeneedy in storage",
     *      tags={"Typeneedy"},
     *      description="Store Typeneedy",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Typeneedy that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Typeneedy")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Typeneedy"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateTypeneedyAPIRequest $request)
    {
        $input = $request->all();

        $typeneedies = $this->typeneedyRepository->create($input);

        return $this->sendResponse($typeneedies->toArray(), 'Typeneedy saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/typeneedies/{id}",
     *      summary="Display the specified Typeneedy",
     *      tags={"Typeneedy"},
     *      description="Get Typeneedy",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Typeneedy",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Typeneedy"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function show($id)
    {
        /** @var Typeneedy $typeneedy */
        $typeneedy = $this->typeneedyRepository->find($id);

        if (empty($typeneedy)) {
            return Response::json(ResponseUtil::makeError('Typeneedy not found'), 404);
        }

        return $this->sendResponse($typeneedy->toArray(), 'Typeneedy retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateTypeneedyAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/typeneedies/{id}",
     *      summary="Update the specified Typeneedy in storage",
     *      tags={"Typeneedy"},
     *      description="Update Typeneedy",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Typeneedy",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Typeneedy that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Typeneedy")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Typeneedy"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateTypeneedyAPIRequest $request)
    {
        $input = $request->all();

        /** @var Typeneedy $typeneedy */
        $typeneedy = $this->typeneedyRepository->find($id);

        if (empty($typeneedy)) {
            return Response::json(ResponseUtil::makeError('Typeneedy not found'), 404);
        }

        $typeneedy = $this->typeneedyRepository->update($input, $id);

        return $this->sendResponse($typeneedy->toArray(), 'Typeneedy updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/typeneedies/{id}",
     *      summary="Remove the specified Typeneedy from storage",
     *      tags={"Typeneedy"},
     *      description="Delete Typeneedy",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Typeneedy",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="string"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function destroy($id)
    {
        /** @var Typeneedy $typeneedy */
        $typeneedy = $this->typeneedyRepository->find($id);

        if (empty($typeneedy)) {
            return Response::json(ResponseUtil::makeError('Typeneedy not found'), 404);
        }

        $typeneedy->delete();

        return $this->sendResponse($id, 'Typeneedy deleted successfully');
    }



    public function getFamilyType()
    {
        /** @var Typeneedy $typeneedy */
        $typeneedy = $this->typeneedyRepository->findWhere(['name'=>'Familiar'],['name']);

        if (empty($typeneedy)) {
            return Response::json(ResponseUtil::makeError('Typeneedy not found'), 404);
        }

        return $this->sendResponse($typeneedy->toArray(), 'Typeneedy retrieved successfully');
    }

}
