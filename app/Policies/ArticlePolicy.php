<?php

namespace App\Policies;

use App\Models\Article;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticlePolicy
{
    use HandlesAuthorization;


    public function delete(User $user, Article $article) {
        return $user->id === $article->user()->id || $user->isAdmin;
    }

    public function update(User $user, Article $article) {
        return $user->id === $article->user()->id || $user->isAdmin;
    }
}
