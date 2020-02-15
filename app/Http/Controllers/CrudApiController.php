<?php


namespace App\Http\Controllers;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Traits\ExceptionTrait;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

abstract class CrudApiController extends Controller
{
    use ExceptionTrait;

    /**
     * Eloquent model instance.
     *
     * @var Model;
     */
    protected $model;

    /**
     * Illuminate\Http\Request instance.
     *
     * @var Request
     */
    protected $request;
    /**
     * @var string
     */
    protected $resource;
    /**
     * @var string|string[]
     */
    protected $controllerName;

    /**
     * CrudApiController constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->model = new $this->model();
        $this->controllerName = str_replace('Controller', '', class_basename($this));
        $this->request = $request;
        $this->resource = 'App\\Http\\Resources\\' . $this->controllerName . 'Resource';
    }

    /**
     * Route for getting all data
     *
     * Returns data from $this->model
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        try {
            $data = $this->model->get();

            if (!$data) {
                return response()->json(['Not found'], Response::HTTP_NOT_FOUND);
            }

            $this->authorize('viewAny', $this->model);
            return response()->json($this->resource::collection($data));
        } catch (AuthorizationException $e) {
            return $this->apiException($e->getMessage(), Response::HTTP_UNAUTHORIZED);
        } catch (\Exception $e) {
            return $this->apiException($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Route for insert new data in the database.
     *
     * Validate, checks authorization and returns a json.
     *
     * @return JsonResponse
     */
    public function store()
    {
        try {
            $validator = Validator::make(
                $this->request->all(),
                $this->model->insertRules(),
                $this->model->insertRulesMessages()
            );

            if ($validator->fails()) {
                return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
            }

            $this->authorize('create', $this->model);
            $data = $this->model->create($this->request->all());
            $data->refresh();

            return response()->json(new $this->resource($data));
        } catch (AuthorizationException $e) {
            return $this->apiException($e->getMessage(), Response::HTTP_UNAUTHORIZED);
        } catch (\Exception $e) {
            return $this->apiException($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Route for show the data.
     *
     * Searches the data using the value in $id.
     * If it is found and the user has authorization
     * to view, show what was found.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id)
    {
        try {
            $data = $this->model->find($id);

            if (!$data) {
                return response()->json('Not found', Response::HTTP_NOT_FOUND);
            }

            $this->authorize('view', $data);
            return response()->json(new $this->resource($data));
        } catch (AuthorizationException $e) {
            return $this->apiException($e->getMessage(), Response::HTTP_UNAUTHORIZED);
        } catch (\Exception $e) {
            return $this->apiException($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Route for update data in the database.
     *
     * Searches the data using the value in $id.
     * If is found  and is valid, update what was found.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function update(int $id)
    {
        try {
            $data = $this->model->find($id);

            if (!$data) {
                return response()->json('Not found', Response::HTTP_NOT_FOUND);
            }

            $this->authorize('update', $data);

            $validator = Validator::make(
                $this->request->all(),
                $this->model->updateRules($id),
                $this->model->updateRulesMessages()
            );

            if ($validator->fails()) {
                return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
            }

            $data->fill($this->request->all());
            $data->save();
            $data->refresh();

            return response()->json( new $this->resource($data));
        } catch (AuthorizationException $e) {
            return $this->apiException($e->getMessage(), Response::HTTP_UNAUTHORIZED);
        } catch (\Exception $e) {
            return $this->apiException($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Route for delete data from the database.
     *
     * Searches the data using the value in $id.
     * If is found, delete what was found.
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id)
    {
        try {
            $data = $this->model->find($id);

            if (!$data) {
                return response()->json('Not found', Response::HTTP_NOT_FOUND);
            }

            $this->authorize('delete', $data);
            $data->delete();

            return response()->json('', Response::HTTP_NO_CONTENT);
        } catch (AuthorizationException $e) {
            return $this->apiException($e->getMessage(), Response::HTTP_UNAUTHORIZED);
        } catch (\Exception $e) {
            return $this->apiException($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

