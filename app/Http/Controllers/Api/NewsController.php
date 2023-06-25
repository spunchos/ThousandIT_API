<?php /** @noinspection PhpUndefinedMethodInspection */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNewsRequest;
use App\Http\Requests\UpdateNewsRequest;
use App\Mail\NewsCreated;
use App\Models\Author;
use App\Models\News;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $data = News::all();
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
     * @param StoreNewsRequest $request
     * @return JsonResponse
     */
    public function store(StoreNewsRequest $request): JsonResponse
    {
        try {
            $author = Author::findOrFail(auth()->id());
            $news = $author->news()->create($request->except('rubric'));
            $news->rubrics()->sync($request->only('rubric'));
            Mail::to($author)->queue(new NewsCreated($news));
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
            $news = News::findOrFail($id);
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
     * Update the specified resource in storage.
     *
     * @param UpdateNewsRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(UpdateNewsRequest $request, $id): JsonResponse
    {
        try {
            $news = News::findOrFail($id);
            if ($request->only('rubric') !== null)
            {
                $news->rubrics()->attach($request->only('rubric'));
            }
            $news->update($request->except('rubric'));

        } catch (Exception $exception) {
            $response = [
                'statusCode' => $exception->getCode(),
                'message'    => $exception->getMessage(),
            ];

            return response()->json($response, ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }

        $response = [
            'statusCode' => 0,
            'message'    => 'News updated successfully',
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
            if (!News::destroy($id)) {
                throw new Exception('Error while deleting news with id - '.$id);
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
            'message'    => 'News deleted successfully',
        ];

        return response()->json($response, ResponseAlias::HTTP_OK);
    }

    /**
     * Display a listing of the resource by searching request.
     *
     * @param $title
     * @return JsonResponse
     */
    public function search($title): JsonResponse
    {
        try {
            $data = News::query()->where('title', 'LIKE', "%{$title}%")->get();
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
