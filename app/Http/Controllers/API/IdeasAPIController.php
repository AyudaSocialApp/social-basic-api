<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateIdeasAPIRequest;
use App\Http\Requests\API\UpdateIdeasAPIRequest;
use App\Models\Ideas;
use App\Repositories\IdeasRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController as InfyOmBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use InfyOm\Generator\Utils\ResponseUtil;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class IdeasController
 * @package App\Http\Controllers\API
 */

class IdeasAPIController extends InfyOmBaseController
{
    /** @var  IdeasRepository */
    private $ideasRepository;

    public function __construct(IdeasRepository $ideasRepo)
    {
        $this->ideasRepository = $ideasRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/ideas",
     *      summary="Get a listing of the Ideas.",
     *      tags={"Ideas"},
     *      description="Get all Ideas",
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
     *                  @SWG\Items(ref="#/definitions/Ideas")
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
        $this->ideasRepository->pushCriteria(new RequestCriteria($request));
        $this->ideasRepository->pushCriteria(new LimitOffsetCriteria($request));
        $ideas = $this->ideasRepository->all();

        return $this->sendResponse($ideas->toArray(), 'Ideas retrieved successfully');
    }

    /**
     * @param CreateIdeasAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/ideas",
     *      summary="Store a newly created Ideas in storage",
     *      tags={"Ideas"},
     *      description="Store Ideas",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Ideas that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Ideas")
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
     *                  ref="#/definitions/Ideas"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateIdeasAPIRequest $request)
    {
        $input = $request->all();

        $ideas = $this->ideasRepository->create($input);

        return $this->sendResponse($ideas->toArray(), 'Ideas saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/ideas/{id}",
     *      summary="Display the specified Ideas",
     *      tags={"Ideas"},
     *      description="Get Ideas",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Ideas",
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
     *                  ref="#/definitions/Ideas"
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
        /** @var Ideas $ideas */
        $ideas = $this->ideasRepository->find($id);

        if (empty($ideas)) {
            return Response::json(ResponseUtil::makeError('Ideas not found'), 404);
        }

        return $this->sendResponse($ideas->toArray(), 'Ideas retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateIdeasAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/ideas/{id}",
     *      summary="Update the specified Ideas in storage",
     *      tags={"Ideas"},
     *      description="Update Ideas",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Ideas",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Ideas that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Ideas")
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
     *                  ref="#/definitions/Ideas"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateIdeasAPIRequest $request)
    {
        $input = $request->all();

        /** @var Ideas $ideas */
        $ideas = $this->ideasRepository->find($id);

        if (empty($ideas)) {
            return Response::json(ResponseUtil::makeError('Ideas not found'), 404);
        }

        $ideas = $this->ideasRepository->update($input, $id);

        return $this->sendResponse($ideas->toArray(), 'Ideas updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/ideas/{id}",
     *      summary="Remove the specified Ideas from storage",
     *      tags={"Ideas"},
     *      description="Delete Ideas",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Ideas",
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
        /** @var Ideas $ideas */
        $ideas = $this->ideasRepository->find($id);

        if (empty($ideas)) {
            return Response::json(ResponseUtil::makeError('Ideas not found'), 404);
        }

        $ideas->delete();

        return $this->sendResponse($id, 'Ideas deleted successfully');
    }

    public function showWithUser($id)
    {
        /** @var Ideas $ideas */
        $ideas = $this->ideasRepository->with('user')->find($id);

        if (empty($ideas)) {
            return Response::json(ResponseUtil::makeError('Ideas with user not found'), 404);
        }

        return $this->sendResponse($ideas->toArray(), 'Ideas With User retrieved successfully');
    }
}
