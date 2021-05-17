<?php

namespace App\Repositories;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PostRepository
{
    /**
    * @var Post
    */
   protected $post;

   /**
    * PostRepository constructor.
    *
    * @param Post $post
    */
   public function __construct(Post $post)
   {
       $this->post = $post;
   }

   /**
    * Get all posts.
    *
    * @return Post $post
    */
   public function getAll()
   {
       return $this->post
           ->get();
   }

   /**
    * Get post by id
    *
    * @param $id
    * @return mixed
    */
   public function getById($id)
   {
       return $this->post
           ->where('id', $id)
           ->get();
   }

   /**
    * Save Post
    *
    * @param $data
    * @return Post
    */
   public function save($data)
   {
       $post = new $this->post;

       $post->title = $data['title'];
       $post->price = $data['price'];
       $post->area = $data['area'];
       $post->address = $data['address'];
       $post->name = $data['name'];
       $post->email = $data['email'];
       $post->phoneNumber = $data['phoneNumber']; 

       $post->save();

       return $post->fresh();
   }

   /**
    * Update Post
    *
    * @param $data
    * @return Post
    */
   public function update($data, $id)
   {
       
       $post = $this->post->find($id);

       $post->title = $data['title'];
       $post->price = $data['price'];
       $post->area = $data['area'];
       $post->address = $data['address'];
       $post->name = $data['name'];
       $post->email = $data['email'];
       $post->phoneNumber = $data['phoneNumber']; 

       $post->update();

       return $post;
   }

   /**
    * Update Post
    *
    * @param $data
    * @return Post
    */
   public function delete($id)
   {
       
       $post = $this->post->find($id);
       $post->delete();

       return $post;
   }

}