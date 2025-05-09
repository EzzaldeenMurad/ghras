<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReviewFormRequest;
use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticlesController extends Controller
{
    /**
     * Display a listing of the articles.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::latest()->get();
        return view('articles.index', compact('articles'));
    }

    /**
     * Display the specified article.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        // dd($id);
        // $article = Article::with('user')->find($id);
        $article = Article::with(['user', 'reviews'])->findOrFail($id);
        // return view('articles.show', compact('article'));
        return view('articles.show', compact('article'));
    }
    public function storeReview(ReviewFormRequest $request)
    {
        if (Auth::guest()) {
            return back()
                ->with('success', 'يرجى تسجيل الدخول اولا');
        }
        
        $id = $request->input('article_id');
        $review = $request->input('review');
        $rating = $request->input('rating');
        $buyer = auth()->user();
        $article = Article::with('user')->find($id);
        // $article = Article::find($id);
        // dd( $id );
        $article->reviews()->create([
            'review' => $review,
            'rate' => $rating,
            'buyer_id' => $buyer->id
        ]);
        return redirect()->route('articles.show', $article->id)
            ->with('success', 'تم التعليق بنجاح');
    }
}
