<?php

namespace App\Services;

use App\Repositories\PostRepository;
use Illuminate\Support\Facades\Log;
use \DB;

use Illuminate\Support\Facades\Validator;

class PostService
{
    protected $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }
    /*public function postRecord()
    {
        $post_data = $this->postRepository->postRecord();
        if ($post_data) {
            Log::info('List fetched successfully', ['method' => __METHOD__]);
            return response()->json(['response' => ['code' => 200, 'message' => 'List fetched successfully', 'data' => $post_data]]);
        } else {
            return response()->json(['response' => ['code' => 400, 'message' => 'Unable to fetch the list', 'data' => $list]]);
        }
    } */
 
    public function deleteById($id)
    {
        DB::beginTransaction();

        try {
            $post = $this->postRepository->delete($id);

        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new InvalidArgumentException('Unable to delete post data');
        }

        DB::commit();

        return $post;

    }

   
    public function getAll()
    {
        return $this->postRepository->getAll();
    }

 
    public function getById($id)
    {
        return $this->postRepository->getById($id);
    }

 
    public function updatePost($data, $id)
    {
        $validator = Validator::make($data, [
            'title' => 'required|min:2',
            'email' => 'required|max:255'
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        DB::beginTransaction();

        try {
            $post = $this->postRepository->update($data, $id);

        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new InvalidArgumentException('Unable to update post data');
        }

        DB::commit();

        return $post;

    }

    /**
     * Validate post data.
     * Store to DB if there are no errors.
     *
     * @param array $data
     * @return String
     */
    public function savePostData($data)
    {
        $validator = Validator::make($data, [
            'title' => 'required',
            'email' => 'required'
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        $result = $this->postRepository->save($data);

        return $result;
    }

}