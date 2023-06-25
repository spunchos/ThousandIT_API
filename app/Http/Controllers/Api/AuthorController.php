<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAuthorRequest;
use App\Http\Requests\UpdateAuthorRequest;
use App\Models\Author;
use App\Models\News;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $data = Author::all();
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
     * @param StoreAuthorRequest $request
     * @return JsonResponse
     */
    public function store(StoreAuthorRequest $request): JsonResponse
    {
        try {
            Author::create($request->validated());
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
     * @param  $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        try {
            $author = Author::findOrFail($id);
        } catch (Exception $exception) {
            $response = [
                'statusCode' => $exception->getCode(),
                'message'    => $exception->getMessage(),
            ];

            return response()->json($response, ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }

        $response = [
            'statusCode' => 0,
            'author'     => $author,
        ];

        return response()->json($response, ResponseAlias::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateAuthorRequest $request
     * @param  $id
     * @return JsonResponse
     */
    public function update(UpdateAuthorRequest $request, $id): JsonResponse
    {
        try {
            $author = Author::findOrFail($id);
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
            'message'    => 'Author updated successfully',
        ];

        return response()->json($response, ResponseAlias::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        try {
            if (!Author::destroy($id)) {
                throw new Exception('Error while deleting author with id - '.$id);
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
            'message'    => 'Author deleted successfully',
        ];

        return response()->json($response, ResponseAlias::HTTP_OK);
    }

    /**
     * Display a listing of the resource by searching request.
     *
     * @param $id
     * @return JsonResponse
     */
    public function newsByAuthor($id): JsonResponse
    {
        try {
            $data = News::query()->where('author_id', '=', "$id")->get();
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
}
