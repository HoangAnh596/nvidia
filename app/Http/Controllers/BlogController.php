<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CategoryNew;
use App\Models\News;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class BlogController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function blog()
    {
        // $cate = CategoryNew::orderBy('stt_new', 'ASC')->where('slug','<>','blogs')->get();
        $cate = CategoryNew::where('slug','<>','blogs')->get();
        // dd($cate);
        $cateNew = CategoryNew::findOrFail(1);
        $newAll = News::latest()->paginate(10);
        $news = $cateNew->news()->orderBy('created_at', 'DESC')->get();
        $viewer = $cateNew->news()->orderBy('view_count', 'DESC')->take(10)->get();
        $outstand = News::where('is_outstand', 1)->orderBy('created_at', 'DESC')->take(10)->get();
        // Lấy ra sản phẩm liên quan
        if (!empty($cateNew->related_pro)) {
            $relatedPro = $cateNew->getRelatedPro();

            return view('cntt.home.blog', compact('cate', 'news', 'viewer', 'outstand', 'relatedPro', 'newAll'));
        }

        return view('cntt.home.blogs.blog', compact('cate', 'news', 'viewer', 'outstand', 'newAll'));
    }

    public function cateBlog($slug)
    {
        if($slug === 'blogs') {
            abort(404);
        }
        // $cate = CategoryNew::orderBy('stt_new', 'ASC')->where('slug','<>','blogs')->get();
        $cate = CategoryNew::where('slug','<>','blogs')->get();
        $cateNew = CategoryNew::where('slug', $slug)->value('id');
        $titleCate = CategoryNew::where('slug', $slug)->first();
        $news = News::where('cate_id', $cateNew)->orderBy('created_at', 'DESC')->get();
        dd($slug);
        $viewer = News::where('cate_id', $cateNew)->orderBy('view_count', 'DESC')->take(10)->get();
        $outstand = News::where('is_outstand', 1)->orderBy('created_at', 'DESC')->take(10)->get();
        // Lấy ra sản phẩm liên quan
        if (!empty($cateNew->related_pro)) {
            $relatedPro = $cateNew->getRelatedPro();
            
            return view('cntt.home.cateBlog', compact('cate', 'titleCate', 'news', 'viewer', 'outstand', 'relatedPro'));
        }

        return view('cntt.home.blogs.cateBlog', compact('cate', 'titleCate', 'news', 'viewer', 'outstand'));
    }

    public function detailBlog($slugParent, $slug)
    {
        // $cate = CategoryNew::orderBy('stt_new', 'ASC')->where('slug','<>','blogs')->get();
        $cate = CategoryNew::where('slug','<>','blogs')->get();
        $titleCate = CategoryNew::where('slug', $slugParent)->first();
        $news = News::where('slug',$slug)->first();
        $sameCate = News::where('cate_id', $news->cate_id)
            ->where('id', '<>', $news->id)
            ->orderBy('created_at', 'DESC')->take(10)
            ->get();
        
        if(empty($news)) {
            abort(404);
        }
        return view('cntt.home.blogs.detailBlog', compact('cate', 'titleCate', 'news', 'sameCate'));
    }
}
