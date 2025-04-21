<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(News $news) {
        $data = [
            'data' => $news->where('status', '=', 'show')->orderBy('date', 'desc')->simplePaginate(10),
        ];
        return view('pages.frontend.news.index', $data);
    }

    public function show($slug, News $news){
        $getData = $news->where('slug', '=', $slug)->first();
        $news->where('id', '=', $getData->id)->update(['hit' => $getData->hit + 1]);
        $data = [
            'data' => $news->where('slug', '=', $slug)->with('category')->first(),
        ];
        return view('pages.frontend.news.detail', $data);
    }
}
