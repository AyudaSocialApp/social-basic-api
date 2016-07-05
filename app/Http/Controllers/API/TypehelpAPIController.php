<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateTypehelpAPIRequest;
use App\Http\Requests\API\UpdateTypehelpAPIRequest;
use App\Models\Typehelp;
use App\Repositories\TypehelpRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController as InfyOmBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use InfyOm\Generator\Utils\ResponseUtil;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class TypehelpController
 * @package App\Http\Controllers\API
 */

class TypehelpAPIController extends InfyOmBaseController
{
    /** @var  TypehelpRepository */
    private $typehelpRepository;

    public function __construct(TypehelpRepository $typehelpRepo)
    {
        $this->typehelpRepository = $typehelpRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/typehelps",
     *      summary="Get a listing of the Typehelps.",
     *      tags={"Typehelp"},
     *      description="Get all Typehelps",
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
     *                  @SWG\Items(ref="#/definitions/Typehelp")
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
        $this->typehelpRepository->pushCriteria(new RequestCriteria($request));
        $this->typehelpRepository->pushCriteria(new LimitOffsetCriteria($request));
        $typehelps = $this->typehelpRepository->all();

        return $this->sendResponse($typehelps->toArray(), 'Typehelps retrieved successfully');
    }

    /**
     * @param CreateTypehelpAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/typehelps",
     *      summary="Store a newly created Typehelp in storage",
     *      tags={"Typehelp"},
     *      description="Store Typehelp",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Typehelp that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Typehelp")
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
     *                  ref="#/definitions/Typehelp"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateTypehelpAPIRequest $request)
    {
        $input = $request->all();

        $typehelps = $this->typehelpRepository->create($input);

        return $this->sendResponse($typehelps->toArray(), 'Typehelp saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/typehelps/{id}",
     *      summary="Display the specified Typehelp",
     *      tags={"Typehelp"},
     *      description="Get Typehelp",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Typehelp",
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
     *                  ref="#/definitions/Typehelp"
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
        /** @var Typehelp $typehelp */
        $typehelp = $this->typehelpRepository->find($id);

        if (empty($typehelp)) {
            return Response::json(ResponseUtil::makeError('Typehelp not found'), 404);
        }

        return $this->sendResponse($typehelp->toArray(), 'Typehelp retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateTypehelpAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/typehelps/{id}",
     *      summary="Update the specified Typehelp in storage",
     *      tags={"Typehelp"},
     *      description="Update Typehelp",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Typehelp",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Typehelp that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Typehelp")
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
     *                  ref="#/definitions/Typehelp"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateTypehelpAPIRequest $request)
    {
        $input = $request->all();

        /** @var Typehelp $typehelp */
        $typehelp = $this->typehelpRepository->find($id);

        if (empty($typehelp)) {
            return Response::json(ResponseUtil::makeError('Typehelp not found'), 404);
        }

        $typehelp = $this->typehelpRepository->update($input, $id);

        return $this->sendResponse($typehelp->toArray(), 'Typehelp updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/typehelps/{id}",
     *      summary="Remove the specified Typehelp from storage",
     *      tags={"Typehelp"},
     *      description="Delete Typehelp",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Typehelp",
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
        /** @var Typehelp $typehelp */
        $typehelp = $this->typehelpRepository->find($id);

        if (empty($typehelp)) {
            return Response::json(ResponseUtil::makeError('Typehelp not found'), 404);
        }

        $typehelp->delete();

        return $this->sendResponse($id, 'Typehelp deleted successfully');
    }
}
