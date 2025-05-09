<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
        $articles = Article::where('user_id', Auth::id())->latest()->get();
        return view('admin.articles.index', compact('articles'));
    }

    /**
     * Store a newly created article in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image_url' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        // dd($request->all());
        $imagePath = null;
        // if ($request->hasFile('image_url')) {
        //     $image = $request->file('image_url');
        //     $imageName = time() . '_' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
        //     $imagePath = $image->storeAs('articles', $imageName, 'public');

        // }
        if ($request->hasFile('image_url')) {
            $image =  $request->file('image_url');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/articles'), $imageName);
            $imagePath = 'images/articles/' . $imageName;
        }
        Article::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => Auth::id(),
            'image_url' => $imagePath,
        ]);

        return back()->with('success', 'تم إضافة المقال بنجاح');
    }

    /**
     * Display the specified article.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        return response()->json([
            'article' => $article
        ]);
    }

    /**
     * Get article data for editing.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        // dd($article);
        return response()->json([
            'article' => $article
        ]);
    }

    /**
     * Update the specified article in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image_url' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        // dd($request->all());
        $data = [
            'title' => $request->title,
            'content' => $request->content,
        ];

        if ($request->hasFile('image_url')) {
            // Delete old image if exists
            if ($article->image_url && file_exists(public_path($article->image_url))) {
                unlink(public_path($article->image_url));
            }

            $image = $request->file('image_url');
            $imageName =  time() . '.' . $image->getClientOriginalExtension();
            $imagePath = 'images/articles/' . $imageName;

            // Make sure the directory exists
            if (!file_exists(public_path('images/articles'))) {
                mkdir(public_path('images/articles'), 0755, true);
            }

            $image->move(public_path('images/articles'), $imageName);
            $article->image_url = $imagePath;
        }

        // if ($request->hasFile('image_url')) {
        //     // Delete old image
        //     if ($article->image_url && Storage::disk('public')->exists($article->image_url)) {
        //         Storage::disk('public')->delete($article->image_url);
        //     }

        //     // Store new image
        //     $image = $request->file('image_url');
        //     $imageName = time() . '_' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
        //     $data['image_url'] = $image->storeAs('articles', $imageName, 'public');
        // }

        $article->update($data);

        return redirect()->route('admin.articles')
            ->with('success', 'تم تحديث المقال بنجاح');
    }

    /**
     * Remove the specified article from storage.
     *`
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        if ($article->image_url && file_exists(public_path($article->image_url))) {
            unlink(public_path($article->image_url));
        }

        $article->delete();

        return redirect()->route('admin.articles')
            ->with('success', 'تم حذف المقال بنجاح');
    }
}
