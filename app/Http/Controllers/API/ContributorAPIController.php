<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateContributorAPIRequest;
use App\Http\Requests\API\UpdateContributorAPIRequest;
use App\Models\Contributor;
use App\Repositories\ContributorRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController as InfyOmBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use InfyOm\Generator\Utils\ResponseUtil;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class ContributorController
 * @package App\Http\Controllers\API
 */

class ContributorAPIController extends InfyOmBaseController
{
    /** @var  ContributorRepository */
    private $contributorRepository;

    public function __construct(ContributorRepository $contributorRepo)
    {
        $this->contributorRepository = $contributorRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/contributors",
     *      summary="Get a listing of the Contributors.",
     *      tags={"Contributor"},
     *      description="Get all Contributors",
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
     *                  @SWG\Items(ref="#/definitions/Contributor")
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
        $this->contributorRepository->pushCriteria(new RequestCriteria($request));
        $this->contributorRepository->pushCriteria(new LimitOffsetCriteria($request));
        $contributors = $this->contributorRepository->all();

        return $this->sendResponse($contributors->toArray(), 'Contributors retrieved successfully');
    }

    /**
     * @param CreateContributorAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/contributors",
     *      summary="Store a newly created Contributor in storage",
     *      tags={"Contributor"},
     *      description="Store Contributor",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Contributor that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Contributor")
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
     *                  ref="#/definitions/Contributor"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateContributorAPIRequest $request)
    {
        $input = $request->all();

        $contributors = $this->contributorRepository->create($input);

        return $this->sendResponse($contributors->toArray(), 'Contributor saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/contributors/{id}",
     *      summary="Display the specified Contributor",
     *      tags={"Contributor"},
     *      description="Get Contributor",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Contributor",
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
     *                  ref="#/definitions/Contributor"
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
        /** @var Contributor $contributor */
        $contributor = $this->contributorRepository->find($id);

        if (empty($contributor)) {
            return Response::json(ResponseUtil::makeError('Contributor not found'), 404);
        }

        return $this->sendResponse($contributor->toArray(), 'Contributor retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateContributorAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/contributors/{id}",
     *      summary="Update the specified Contributor in storage",
     *      tags={"Contributor"},
     *      description="Update Contributor",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Contributor",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Contributor that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Contributor")
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
     *                  ref="#/definitions/Contributor"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateContributorAPIRequest $request)
    {
        $input = $request->all();

        /** @var Contributor $contributor */
        $contributor = $this->contributorRepository->find($id);

        if (empty($contributor)) {
            return Response::json(ResponseUtil::makeError('Contributor not found'), 404);
        }

        $contributor = $this->contributorRepository->update($input, $id);

        return $this->sendResponse($contributor->toArray(), 'Contributor updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/contributors/{id}",
     *      summary="Remove the specified Contributor from storage",
     *      tags={"Contributor"},
     *      description="Delete Contributor",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Contributor",
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
        /** @var Contributor $contributor */
        $contributor = $this->contributorRepository->find($id);

        if (empty($contributor)) {
            return Response::json(ResponseUtil::makeError('Contributor not found'), 404);
        }

        $contributor->delete();

        return $this->sendResponse($id, 'Contributor deleted successfully');
    }
}
