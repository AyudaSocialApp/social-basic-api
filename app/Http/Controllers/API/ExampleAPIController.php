<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateExampleAPIRequest;
use App\Http\Requests\API\UpdateExampleAPIRequest;
use App\Models\Example;
use App\Repositories\ExampleRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController as InfyOmBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use InfyOm\Generator\Utils\ResponseUtil;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class ExampleController
 * @package App\Http\Controllers\API
 */

class ExampleAPIController extends InfyOmBaseController
{
    /** @var  ExampleRepository */
    private $exampleRepository;

    public function __construct(ExampleRepository $exampleRepo)
    {
        $this->exampleRepository = $exampleRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/examples",
     *      summary="Get a listing of the Examples.",
     *      tags={"Example"},
     *      description="Get all Examples",
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
     *                  @SWG\Items(ref="#/definitions/Example")
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
        $this->exampleRepository->pushCriteria(new RequestCriteria($request));
        $this->exampleRepository->pushCriteria(new LimitOffsetCriteria($request));
        $examples = $this->exampleRepository->all();

        return $this->sendResponse($examples->toArray(), 'Examples retrieved successfully');
    }

    /**
     * @param CreateExampleAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/examples",
     *      summary="Store a newly created Example in storage",
     *      tags={"Example"},
     *      description="Store Example",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Example that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Example")
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
     *                  ref="#/definitions/Example"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateExampleAPIRequest $request)
    {
        $input = $request->all();

        $examples = $this->exampleRepository->create($input);

        return $this->sendResponse($examples->toArray(), 'Example saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/examples/{id}",
     *      summary="Display the specified Example",
     *      tags={"Example"},
     *      description="Get Example",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Example",
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
     *                  ref="#/definitions/Example"
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
        /** @var Example $example */
        $example = $this->exampleRepository->find($id);

        if (empty($example)) {
            return Response::json(ResponseUtil::makeError('Example not found'), 404);
        }

        return $this->sendResponse($example->toArray(), 'Example retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateExampleAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/examples/{id}",
     *      summary="Update the specified Example in storage",
     *      tags={"Example"},
     *      description="Update Example",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Example",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Example that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Example")
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
     *                  ref="#/definitions/Example"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateExampleAPIRequest $request)
    {
        $input = $request->all();

        /** @var Example $example */
        $example = $this->exampleRepository->find($id);

        if (empty($example)) {
            return Response::json(ResponseUtil::makeError('Example not found'), 404);
        }

        $example = $this->exampleRepository->update($input, $id);

        return $this->sendResponse($example->toArray(), 'Example updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/examples/{id}",
     *      summary="Remove the specified Example from storage",
     *      tags={"Example"},
     *      description="Delete Example",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Example",
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
        /** @var Example $example */
        $example = $this->exampleRepository->find($id);

        if (empty($example)) {
            return Response::json(ResponseUtil::makeError('Example not found'), 404);
        }

        $example->delete();

        return $this->sendResponse($id, 'Example deleted successfully');
    }
}
