<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateTypeidentificationAPIRequest;
use App\Http\Requests\API\UpdateTypeidentificationAPIRequest;
use App\Models\Typeidentification;
use App\Repositories\TypeidentificationRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController as InfyOmBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use InfyOm\Generator\Utils\ResponseUtil;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class TypeidentificationController
 * @package App\Http\Controllers\API
 */

class TypeidentificationAPIController extends InfyOmBaseController
{
    /** @var  TypeidentificationRepository */
    private $typeidentificationRepository;

    public function __construct(TypeidentificationRepository $typeidentificationRepo)
    {
        $this->typeidentificationRepository = $typeidentificationRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/typeidentifications",
     *      summary="Get a listing of the Typeidentifications.",
     *      tags={"Typeidentification"},
     *      description="Get all Typeidentifications",
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
     *                  @SWG\Items(ref="#/definitions/Typeidentification")
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
        $this->typeidentificationRepository->pushCriteria(new RequestCriteria($request));
        $this->typeidentificationRepository->pushCriteria(new LimitOffsetCriteria($request));
        $typeidentifications = $this->typeidentificationRepository->all();

        return $this->sendResponse($typeidentifications->toArray(), 'Typeidentifications retrieved successfully');
    }

    /**
     * @param CreateTypeidentificationAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/typeidentifications",
     *      summary="Store a newly created Typeidentification in storage",
     *      tags={"Typeidentification"},
     *      description="Store Typeidentification",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Typeidentification that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Typeidentification")
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
     *                  ref="#/definitions/Typeidentification"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateTypeidentificationAPIRequest $request)
    {
        $input = $request->all();

        $typeidentifications = $this->typeidentificationRepository->create($input);

        return $this->sendResponse($typeidentifications->toArray(), 'Typeidentification saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/typeidentifications/{id}",
     *      summary="Display the specified Typeidentification",
     *      tags={"Typeidentification"},
     *      description="Get Typeidentification",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Typeidentification",
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
     *                  ref="#/definitions/Typeidentification"
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
        /** @var Typeidentification $typeidentification */
        $typeidentification = $this->typeidentificationRepository->find($id);

        if (empty($typeidentification)) {
            return Response::json(ResponseUtil::makeError('Typeidentification not found'), 404);
        }

        return $this->sendResponse($typeidentification->toArray(), 'Typeidentification retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateTypeidentificationAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/typeidentifications/{id}",
     *      summary="Update the specified Typeidentification in storage",
     *      tags={"Typeidentification"},
     *      description="Update Typeidentification",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Typeidentification",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Typeidentification that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Typeidentification")
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
     *                  ref="#/definitions/Typeidentification"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateTypeidentificationAPIRequest $request)
    {
        $input = $request->all();

        /** @var Typeidentification $typeidentification */
        $typeidentification = $this->typeidentificationRepository->find($id);

        if (empty($typeidentification)) {
            return Response::json(ResponseUtil::makeError('Typeidentification not found'), 404);
        }

        $typeidentification = $this->typeidentificationRepository->update($input, $id);

        return $this->sendResponse($typeidentification->toArray(), 'Typeidentification updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/typeidentifications/{id}",
     *      summary="Remove the specified Typeidentification from storage",
     *      tags={"Typeidentification"},
     *      description="Delete Typeidentification",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Typeidentification",
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
        /** @var Typeidentification $typeidentification */
        $typeidentification = $this->typeidentificationRepository->find($id);

        if (empty($typeidentification)) {
            return Response::json(ResponseUtil::makeError('Typeidentification not found'), 404);
        }

        $typeidentification->delete();

        return $this->sendResponse($id, 'Typeidentification deleted successfully');
    }
}
