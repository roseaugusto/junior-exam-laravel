<?php

namespace App\Http\Controllers;
use App\Models\Article;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Fascades\Auth;

class ArticleController extends Controller
{

    public function index() {
      return Article::all();
    }

    public function userArticle() {
      $articles = Article::where('id', auth()->user()->id)->with('votes')->get();

      return response([
        'articles'=> $articles
      ], 200);
    }

    public function store(Request $request) {
      $fields = $request->validate([
        'title' => 'required',
        'content' => []
      ]);
      
      $article = Article::create([
        'title' => $fields['title'],
        'content' => $fields['content'],
        'user_id' => auth()->user()->id
      ]);

      return response(['id' => $article->id, 'message' => 'Successfully added article.'], 200);
    }

    public function show($id) {
        return Article::find($id);
    }

    public function update(Request $request, $id) {
        $article = Article::find($id);
        $article->update($request->all());
        return response(['message' => 'Successfully updated vote.'], 200);
    }

    public function destroy($id) {
      $article = Article::find($id);
      $article->delete();
      return response(['message' => 'Successfully deleted article.'], 200);
    }

    public function search($name) {
      return Article::where('title', 'like', '%'.$name.'%')->get();
    }

    public function voting(Request $request, $id) {
      $fields = $request->validate([
        'isVoted' => 'required|boolean',
      ]);

      $article = Article::where('id', $id)->first();

      Vote::updateOrCreate(
        ['article_id' => $id, 'user_id' => auth()->user()->id],
        ['isVoted' => $fields['isVoted']]
      );

      return response(['message' => 'Successfully cast vote.'], 200);
    }
    
    public function deleteVoting(Request $request, $id) {
      $vote = Vote::where(
        ['user_id' => auth()->user()->id], 
        ['article_id' => $id]
      );
      $vote->delete();

      return response(['message' => 'Successfully deleted vote.'], 200);
    }
}
