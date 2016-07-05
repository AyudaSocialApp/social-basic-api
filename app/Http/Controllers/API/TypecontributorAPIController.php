<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateTypecontributorAPIRequest;
use App\Http\Requests\API\UpdateTypecontributorAPIRequest;
use App\Models\Typecontributor;
use App\Repositories\TypecontributorRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController as InfyOmBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use InfyOm\Generator\Utils\ResponseUtil;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class TypecontributorController
 * @package App\Http\Controllers\API
 */

class TypecontributorAPIController extends InfyOmBaseController
{
    /** @var  TypecontributorRepository */
    private $typecontributorRepository;

    public function __construct(TypecontributorRepository $typecontributorRepo)
    {
        $this->typecontributorRepository = $typecontributorRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/typecontributors",
     *      summary="Get a listing of the Typecontributors.",
     *      tags={"Typecontributor"},
     *      description="Get all Typecontributors",
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
     *                  @SWG\Items(ref="#/definitions/Typecontributor")
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
        $this->typecontributorRepository->pushCriteria(new RequestCriteria($request));
        $this->typecontributorRepository->pushCriteria(new LimitOffsetCriteria($request));
        $typecontributors = $this->typecontributorRepository->all();

        return $this->sendResponse($typecontributors->toArray(), 'Typecontributors retrieved successfully');
    }

    /**
     * @param CreateTypecontributorAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/typecontributors",
     *      summary="Store a newly created Typecontributor in storage",
     *      tags={"Typecontributor"},
     *      description="Store Typecontributor",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Typecontributor that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Typecontributor")
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
     *                  ref="#/definitions/Typecontributor"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateTypecontributorAPIRequest $request)
    {
        $input = $request->all();

        $typecontributors = $this->typecontributorRepository->create($input);

        return $this->sendResponse($typecontributors->toArray(), 'Typecontributor saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/typecontributors/{id}",
     *      summary="Display the specified Typecontributor",
     *      tags={"Typecontributor"},
     *      description="Get Typecontributor",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Typecontributor",
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
     *                  ref="#/definitions/Typecontributor"
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
        /** @var Typecontributor $typecontributor */
        $typecontributor = $this->typecontributorRepository->find($id);

        if (empty($typecontributor)) {
            return Response::json(ResponseUtil::makeError('Typecontributor not found'), 404);
        }

        return $this->sendResponse($typecontributor->toArray(), 'Typecontributor retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateTypecontributorAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/typecontributors/{id}",
     *      summary="Update the specified Typecontributor in storage",
     *      tags={"Typecontributor"},
     *      description="Update Typecontributor",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Typecontributor",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Typecontributor that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Typecontributor")
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
     *                  ref="#/definitions/Typecontributor"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateTypecontributorAPIRequest $request)
    {
        $input = $request->all();

        /** @var Typecontributor $typecontributor */
        $typecontributor = $this->typecontributorRepository->find($id);

        if (empty($typecontributor)) {
            return Response::json(ResponseUtil::makeError('Typecontributor not found'), 404);
        }

        $typecontributor = $this->typecontributorRepository->update($input, $id);

        return $this->sendResponse($typecontributor->toArray(), 'Typecontributor updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/typecontributors/{id}",
     *      summary="Remove the specified Typecontributor from storage",
     *      tags={"Typecontributor"},
     *      description="Delete Typecontributor",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Typecontributor",
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
        /** @var Typecontributor $typecontributor */
        $typecontributor = $this->typecontributorRepository->find($id);

        if (empty($typecontributor)) {
            return Response::json(ResponseUtil::makeError('Typecontributor not found'), 404);
        }

        $typecontributor->delete();

        return $this->sendResponse($id, 'Typecontributor deleted successfully');
    }
}
