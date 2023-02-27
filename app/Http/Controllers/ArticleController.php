<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Http\Requests\ArticleRequest;
use App\Policies\ArticlePolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mockery\Generator\Method;
use Tymon\JWTAuth\Facades\JWTAuth;

class ArticleController extends Controller
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
    public function index(ArticleRequest $request)
    {
        $articles = Article::with('tags', 'category')
        ->where(function ($query) use ($request) {
            $query->whereHas('tags', function ($query) use ($request) {
                $query->where('name', 'like', '%'.$request->name.'%');
            })
            ->orWhereHas('category', function ($query) use ($request) {
                $query->where('name', 'like', '%'.$request->name.'%');
            });
        })
        ->get();
    
        return response()->json($articles);
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
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ArticleRequest  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(ArticleRequest $request, Article $article) // PUT PATCH
    {
        $this->authorize('update', $article);

        $arrayValider = $request->validated();
        $tags = $request->input('tags');

        if(! $user = JWTAuth::user()) {
            return response()->json(['error'=>'Unauthorized']);
        }

        // $article->name = $request->get('name');
        $article->content = $request->get('content');
        $article->description = $request->get('description');
        $article->title = $request->get('title');

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
    public function destroy(Article $article)
    {
        $this->authorize('delete', $article);

        $article->delete();
        return response()->json([
            'success'=>'Article has been delete',
        ], 201);
    }
}
