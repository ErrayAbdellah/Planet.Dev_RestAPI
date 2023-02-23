<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Http\Requests\ArticleRequest;
use Mockery\Generator\Method;
use Tymon\JWTAuth\Facades\JWTAuth;

class ArticleController extends Controller
{
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
     * @param  \App\Http\Requests\ArticleRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ArticleRequest $request)
    {
        $confident = $request->only(['title', 'content', 'description', 'category_id']);
        $tags = $request->input('tags');

        if(! $user = JWTAuth::user()) {
            return response()->json(['error'=>'Unauthorized']);
        }
        $article = $user->articles()->create($confident);
        $article->tags()->sync($tags);

        return response()->json([
            'success'=>'Article has been saved',
            'data' => ['article' => $article]
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        //
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ArticleRequest  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(ArticleRequest $request, Article $article) // PUT PATCH
    {

        // return response()->json();
        $arrayValider = $request->validated();
        $tags = $request->input('tags');

        if(! $user = JWTAuth::user()) {
            return response()->json(['error'=>'Unauthorized']);
        }

        // $article->name = $request->get('name');
        $article->content = $request->get('content');
        $article->description = $request->get('description');
        $article->title = $request->get('title');
        $article->user_id = JWTAuth::user()->id;
       
        $article->tags()->sync($tags);

        $article->update();


        return response()->json([
            'success'=>'Article has been update',
            'data' => ['article' => $article]
        ], 201);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $article = Article::find($id);
        $article->delete();
        return response()->json([
            'success'=>'Article has been delete',
        ], 201);
    }
}
