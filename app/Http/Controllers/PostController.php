<?php

namespace App\Http\Controllers;

use App\Http\Api\ApiResponse;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    private $ERROR_INVALID_POST = 200;
    private $ERROR_SAVE_POST = 201;

    /**
     * Get the list of posts
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        Log::debug([PostController::class, 'index()', 'page', request('page')]);

        $posts = Post::latest('created_at')->paginate(15);

        return response()->json($posts, 200);
    }

    /**
     * Save the new post
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $data = $this->requestData();
        $data['user_id'] = auth()->user()->id;

        Log::debug([PostController::class, 'store()', '$data', $data]);

        return $this->createOrUpdate($data);
    }

    /**
     * Show the detailed information of post
     *
     * @param Post $post
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Update a post
     *
     * @param Request $request
     * @param Post $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Post $post)
    {
        $data = $this->requestData();
        $data['id'] = $post->id;

        Log::debug([PostController::class, 'update()', '$data', $data]);

        return $this->createOrUpdate($data, $post);
    }

    /**
     * Delete a post
     *
     * @param Post $post
     */
    public function destroy(Post $post)
    {
        //
    }

    /**
     * Filter the data from request
     *
     * @return array|Request|string
     */
    protected function requestData()
    {
        return request(['title', 'content']);
    }

    /**
     * Create a validator for data
     *
     * @param array $data
     * @return mixed
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'title' => 'required',
            'content' => 'required',
        ]);
    }

    /**
     * Create or update a post
     *
     * @param array $data
     * @param Post|null $post
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createOrUpdate(array $data, Post $post = null) {
        $validator = $this->validator($data);

        $apiResponse = new ApiResponse();

        if ($validator->fails()) {
            $apiResponse->setCode($this->ERROR_INVALID_POST);
            $apiResponse->setMsg(__('messages.invalid_post_error'));
            $apiResponse->setData($validator->errors());

            return respondApiError($apiResponse);
        } else {
            if ($post == null) {
                $post = Post::create($data);
            } else {
                $post->update($data);
            }

            if ($post) {
                $apiResponse->setMsg(__('messages.save_post_success'));
                return respondApiSuccess($apiResponse);
            } else {
                $apiResponse->setCode($this->ERROR_SAVE_POST);
                $apiResponse->setMsg(__('messages.save_post_error'));
                return respondApiError($apiResponse);
            }
        }
    }
}
