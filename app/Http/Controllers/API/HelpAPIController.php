<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateHelpAPIRequest;
use App\Http\Requests\API\UpdateHelpAPIRequest;
use App\Models\Help;
use App\Repositories\HelpRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController as InfyOmBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use InfyOm\Generator\Utils\ResponseUtil;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class HelpController
 * @package App\Http\Controllers\API
 */

class HelpAPIController extends InfyOmBaseController
{
    /** @var  HelpRepository */
    private $helpRepository;

    public function __construct(HelpRepository $helpRepo)
    {
        $this->helpRepository = $helpRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/helps",
     *      summary="Get a listing of the Helps.",
     *      tags={"Help"},
     *      description="Get all Helps",
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
     *                  @SWG\Items(ref="#/definitions/Help")
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
        $this->helpRepository->pushCriteria(new RequestCriteria($request));
        $this->helpRepository->pushCriteria(new LimitOffsetCriteria($request));
        $helps = $this->helpRepository->all();

        return $this->sendResponse($helps->toArray(), 'Helps retrieved successfully');
    }

    /**
     * @param CreateHelpAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/helps",
     *      summary="Store a newly created Help in storage",
     *      tags={"Help"},
     *      description="Store Help",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Help that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Help")
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
     *                  ref="#/definitions/Help"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateHelpAPIRequest $request)
    {
        $input = $request->all();

        $helps = $this->helpRepository->create($input);

        return $this->sendResponse($helps->toArray(), 'Help saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/helps/{id}",
     *      summary="Display the specified Help",
     *      tags={"Help"},
     *      description="Get Help",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Help",
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
     *                  ref="#/definitions/Help"
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
        /** @var Help $help */
        $help = $this->helpRepository->find($id);

        if (empty($help)) {
            return Response::json(ResponseUtil::makeError('Help not found'), 404);
        }

        return $this->sendResponse($help->toArray(), 'Help retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateHelpAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/helps/{id}",
     *      summary="Update the specified Help in storage",
     *      tags={"Help"},
     *      description="Update Help",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Help",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Help that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Help")
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
     *                  ref="#/definitions/Help"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateHelpAPIRequest $request)
    {
        $input = $request->all();

        /** @var Help $help */
        $help = $this->helpRepository->find($id);

        if (empty($help)) {
            return Response::json(ResponseUtil::makeError('Help not found'), 404);
        }

        $help = $this->helpRepository->update($input, $id);

        return $this->sendResponse($help->toArray(), 'Help updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/helps/{id}",
     *      summary="Remove the specified Help from storage",
     *      tags={"Help"},
     *      description="Delete Help",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Help",
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
        /** @var Help $help */
        $help = $this->helpRepository->find($id);

        if (empty($help)) {
            return Response::json(ResponseUtil::makeError('Help not found'), 404);
        }

        $help->delete();

        return $this->sendResponse($id, 'Help deleted successfully');
    }

    public function indexWithForeysOfContributor(Request $request,$idcontributor,$maxId){
        $this->helpRepository->pushCriteria(new RequestCriteria($request));
        $this->helpRepository->pushCriteria(new LimitOffsetCriteria($request));
        $helps = $this->helpRepository->indexWithForeysOfContributor($idcontributor,$maxId);
        return $this->sendResponse($helps->toArray(), 'Helps retrieved successfully');
    }

    public function indexWithForeysOfNeedy(Request $request,$idneedy,$maxId){
        $this->helpRepository->pushCriteria(new RequestCriteria($request));
        $this->helpRepository->pushCriteria(new LimitOffsetCriteria($request));
        $helps = $this->helpRepository->indexWithForeysOfNeedy($idneedy,$maxId);
        return $this->sendResponse($helps->toArray(), 'Helps retrieved successfully');
    }

    public function indexWithAllNeedy(Request $request,$maxId){
        $this->helpRepository->pushCriteria(new RequestCriteria($request));
        $this->helpRepository->pushCriteria(new LimitOffsetCriteria($request));
        $helps = $this->helpRepository->indexWithAllNeedy($maxId);
        return $this->sendResponse($helps->toArray(), 'Helps retrieved successfully'); 
    }

    public function registerNewHelp(CreateHelpAPIRequest $request)
    {
        $input = $request->all();

        $helps = $this->helpRepository->registerNewHelp($input);

        return $this->sendResponse($helps->toArray(), 'Help saved successfully');
    }


    public function indexWithLastHelpOfNeedy($idneedy){
        $helps = $this->helpRepository->indexWithLastHelpOfNeedy($idneedy);
        return $this->sendResponse($helps->toArray(), 'Last Helps of needy retrieved successfully');
    }

    public function updateAsColaborator(Request $request){
        $input = $request->all();
        $help = $this->helpRepository->updateAsColaborator($input);
        return $this->sendResponse($help, 'Help updated successfully');        
    } 

}
