<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateNeedyAPIRequest;
use App\Http\Requests\API\UpdateNeedyAPIRequest;
use App\Models\Needy;
use App\Repositories\NeedyRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController as InfyOmBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use InfyOm\Generator\Utils\ResponseUtil;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class NeedyController
 * @package App\Http\Controllers\API
 */

class NeedyAPIController extends InfyOmBaseController
{
    /** @var  NeedyRepository */
    private $needyRepository;

    public function __construct(NeedyRepository $needyRepo)
    {
        $this->needyRepository = $needyRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/needies",
     *      summary="Get a listing of the Needies.",
     *      tags={"Needy"},
     *      description="Get all Needies",
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
     *                  @SWG\Items(ref="#/definitions/Needy")
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
        $this->needyRepository->pushCriteria(new RequestCriteria($request));
        $this->needyRepository->pushCriteria(new LimitOffsetCriteria($request));
        $needies = $this->needyRepository->all();

        return $this->sendResponse($needies->toArray(), 'Needies retrieved successfully');
    }

    /**
     * @param CreateNeedyAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/needies",
     *      summary="Store a newly created Needy in storage",
     *      tags={"Needy"},
     *      description="Store Needy",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Needy that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Needy")
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
     *                  ref="#/definitions/Needy"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateNeedyAPIRequest $request)
    {
        $input = $request->all();

        $needies = $this->needyRepository->create($input);

        return $this->sendResponse($needies->toArray(), 'Needy saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/needies/{id}",
     *      summary="Display the specified Needy",
     *      tags={"Needy"},
     *      description="Get Needy",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Needy",
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
     *                  ref="#/definitions/Needy"
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
        /** @var Needy $needy */
        $needy = $this->needyRepository->find($id);

        if (empty($needy)) {
            return Response::json(ResponseUtil::makeError('Needy not found'), 404);
        }

        return $this->sendResponse($needy->toArray(), 'Needy retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateNeedyAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/needies/{id}",
     *      summary="Update the specified Needy in storage",
     *      tags={"Needy"},
     *      description="Update Needy",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Needy",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Needy that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Needy")
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
     *                  ref="#/definitions/Needy"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateNeedyAPIRequest $request)
    {
        $input = $request->all();

        /** @var Needy $needy */
        $needy = $this->needyRepository->find($id);

        if (empty($needy)) {
            return Response::json(ResponseUtil::makeError('Needy not found'), 404);
        }

        $needy = $this->needyRepository->update($input, $id);

        return $this->sendResponse($needy->toArray(), 'Needy updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/needies/{id}",
     *      summary="Remove the specified Needy from storage",
     *      tags={"Needy"},
     *      description="Delete Needy",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Needy",
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
        /** @var Needy $needy */
        $needy = $this->needyRepository->find($id);

        if (empty($needy)) {
            return Response::json(ResponseUtil::makeError('Needy not found'), 404);
        }

        $needy->delete();

        return $this->sendResponse($id, 'Needy deleted successfully');
    }
}
