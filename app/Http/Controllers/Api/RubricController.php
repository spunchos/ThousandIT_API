<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRubricRequest;
use App\Http\Requests\UpdateRubricRequest;
use App\Models\News;
use App\Models\News_rubric;
use App\Models\Rubric;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class RubricController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $data = Rubric::all();
        } catch (Exception $exception) {
            $response = [
                'statusCode' => $exception->getCode(),
                'message'    => $exception->getMessage(),
            ];

            return response()->json($response, ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }

        $response = [
            'statusCode' => 0,
            'data'       => $data,
        ];

        return response()->json($response, ResponseAlias::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRubricRequest $request
     * @return JsonResponse
     */
    public function store(StoreRubricRequest $request): JsonResponse
    {
        try {
            Rubric::create($request->validated());
        } catch (Exception $exception) {
            $response = [
                'statusCode' => $exception->getCode(),
                'message'    => $exception->getMessage(),
            ];

            return response()->json($response, ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }

        $response = [
            'statusCode' => 0,
            'message'    => 'saved successfully',
        ];

        return response()->json($response, ResponseAlias::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        try {
            $rubric = Rubric::findOrFail($id);
        } catch (Exception $exception) {
            $response = [
                'statusCode' => $exception->getCode(),
                'message'    => $exception->getMessage(),
            ];

            return response()->json($response, ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }

        $response = [
            'statusCode' => 0,
            'rubric'     => $rubric,
        ];

        return response()->json($response, ResponseAlias::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRubricRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(UpdateRubricRequest $request, $id): JsonResponse
    {
        try {
            $author = Rubric::findOrFail($id);
            $author->update($request->validated());
        } catch (Exception $exception) {
            $response = [
                'statusCode' => $exception->getCode(),
                'message'    => $exception->getMessage(),
            ];

            return response()->json($response, ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }

        $response = [
            'statusCode' => 0,
            'message'    => 'Updated successfully',
        ];

        return response()->json($response, ResponseAlias::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        try {
            if (!Rubric::destroy($id)) {
                throw new Exception('Error while deleting rubric with id - '.$id);
            }
        } catch (Exception $exception) {
            $response = [
                'statusCode' => $exception->getCode(),
                'message'    => $exception->getMessage(),
            ];

            return response()->json($response, ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }

        $response = [
            'statusCode' => 0,
            'message'    => 'Deleted successfully',
        ];

        return response()->json($response, ResponseAlias::HTTP_OK);
    }

    /**
     * Display a listing of the resource by searching request.
     *
     * @param $id
     * @return JsonResponse
     */
    public function newsByRubric($id): JsonResponse
    {
        try {
            $rubric = Rubric::query()->where('id', '=', "$id")->get();
            $ids = [];
            self::recutsiveSearch($rubric, $ids);
            $newsIDs = News_rubric::query()
                ->whereIn('rubric_id', $ids)
                ->pluck('news_id')
                ->unique();
            $news = News::query()->whereIn('id', $newsIDs)->get();
        } catch (Exception $exception) {
            $response = [
                'statusCode' => $exception->getCode(),
                'message'    => $exception->getMessage(),
            ];

            return response()->json($response, ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }

        $response = [
            'statusCode' => 0,
            'news'       => $news,
        ];

        return response()->json($response, ResponseAlias::HTTP_OK);
    }

    /**
     * Function that performs a recursive search for child rubrics.
     * Supports any level of nesting, but not optimized.
     *
     * @param $dRubrics
     * @param $ids
     * @return void
     */
    public function recutsiveSearch($dRubrics, &$ids): void
    {
        foreach ($dRubrics as $rubric) {
            $ids[] = $rubric->id;
            $doughterRubric = Rubric::query()->where('pid', '=', "$rubric->id")->get();

            if ($doughterRubric === null) continue;
            else self::recutsiveSearch($doughterRubric, $ids);
        }
    }
}
