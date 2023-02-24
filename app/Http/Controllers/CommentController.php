<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Http\Requests\CommentRequest;
use App\Policies\CommentPolicy;
use Tymon\JWTAuth\Facades\JWTAuth;

class CommentController extends Controller
{
    public function __construct()
    {

        $this->middleware([
            'isUser'
        ])->only(['store']);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CommentRequest
     * @return \Illuminate\Http\Response
     */
    public function store(CommentRequest $request)
    {
        $comment = new Comment;
        $comment->content = $request->content;
        $comment->article_id = $request->article_id;
        $comment->user_id = $request->user_id;
        $comment->save();

        return response()->json([
            'message' => 'Comment created successfully',
            'comment' => $comment,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\CommentRequest  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(CommentRequest $request, Comment $comment)
    {
        $this->authorize('update', $comment);

        $comment->content = $request->content;
        $comment->save();
        return response()->json([
            'message' => 'Comment updated successfully',
            'comment' => $comment
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);

        $comment->delete();
        return response()->json([
            'message' => 'Comment deleted'
        ]);
    }
}
