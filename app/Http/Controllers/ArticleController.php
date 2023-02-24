<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Http\Requests\ArticleRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mockery\Generator\Method;
use Tymon\JWTAuth\Facades\JWTAuth;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ArticleRequest $request)
    {
        
        if(empty($request->name)){
            $articles =  DB::table('articles')
                ->join('users', 'users.id', '=', 'articles.user_id')
                ->join('categories', 'categories.id', '=', 'articles.category_id')
                ->select(
                        'articles.title',
                        'articles.description',
                        'articles.content',
                        'users.name as user',
                        'categories.name as category',
                    )
                ->get();

                return response()->json($articles);
        }else{
            $articles =  DB::table('articles')
                ->join('users', 'users.id', '=', 'articles.user_id')
                ->join('categories', 'categories.id', '=', 'articles.category_id')
                ->leftJoin('article_tag', 'article_tag.article_id' ,'=' ,'articles.id')
                ->leftJoin('tags', 'tags.id' ,'=' ,'article_tag.tag_id')
                ->select(
                        'articles.title',
                        'articles.description',
                        'articles.content',
                        'users.name as user',
                        'categories.name as category',
                        'tags.name as tags'
                    )
                // ->groupBy($request->name)
                ->where('categories.name','like','%'.$request->name.'%')
                ->orWhere('tags.name','like','%'.$request->name.'%')
                ->get();

                return response()->json($articles);
        }
       
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
