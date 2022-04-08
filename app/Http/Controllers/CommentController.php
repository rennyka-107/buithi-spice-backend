<?php

namespace App\Http\Controllers;

use App\Http\Requests\Comment\CreateRequest;
use App\Http\Requests\Comment\GetAllCommentRequest;
use App\Http\Requests\Comment\UpdateRequest;
use App\Services\CommentService\CommentServiceInterface as CommentService;

class CommentController extends Controller
{
    protected $comment_service;
    public function __construct(CommentService $comment_service)
    {
        $this->comment_service = $comment_service;
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function getAll(GetAllCommentRequest $request)
    {
        try {
            $comments = $this->comment_service->getAll($request->all());
            return response()->json(["status" => count($comments) > 0, "comments" => $comments]);
        } catch (Exception $error) {
            return response()->json(['error' => $error->getMessage()]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(CreateRequest $request)
    {
        try {
            $comment = $this->comment_service->create($request->all());
            return response()->json(["status" => $comment !== null, "comment" => $comment]);
        } catch (Exception $error) {
            return response()->json(['error' => $error->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function get($id)
    {
        try {
            $comment = $this->comment_service->get($id);
            return response()->json(["status" => $comment !== null, "comment" => $comment]);
        } catch (Exception $error) {
            return response()->json(['error' => $error->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        try {
            $request['id'] = $id;
            $comment = $this->comment_service->update($request->all());
            return response()->json(["status" => $comment !== null, "comment" => $comment]);
        } catch (Exception $error) {
            return response()->json(['error' => $error->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        try {
            return response()->json(["status" => $this->comment_service->delete($id)]);
        } catch (Exception $error) {
            return response()->json(['error' => $error->getMessage()]);
        }
    }

    public function getCommentsByPostId(GetAllCommentRequest $request, $id)
    {
        try {
            $data = $this->comment_service->getCommentsByPostId($id, $request->all());
            $data['status'] = count($data['comments']) > 0;
            return response()->json($data);
        } catch (Exception $error) {
            return response()->json(['error' => $error->getMessage()]);
        }
    }

    public function getCommentsByUserId(GetAllCommentRequest $request, $id)
    {
        try {
            $data = $this->comment_service->getCommentsByUserId($id, $request->all());
            $data['status'] = count($data['comments']) > 0;
            return response()->json($data);
        } catch (Exception $error) {
            return response()->json(['error' => $error->getMessage()]);
        }
    }
}
