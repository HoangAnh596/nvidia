<?php

namespace App\Http\Controllers;

use App\Models\CategoryNew;
use App\Models\News;
use App\Services\CategoryNewSrc;

class BlogController extends Controller
{
    protected $categoryNewSrc;

    public function __construct(CategoryNewSrc $categoryNewSrc)
    {
        $this->categoryNewSrc = $categoryNewSrc;
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function blog()
    {
        $cateMenu = CategoryNew::where('parent_id', 0)
        ->where('is_public', 1)
        ->with('children')
        ->get();

        $newAll = News::latest()->paginate(10);
        $viewer = News::orderBy('view_count', 'DESC')->take(10)->get();
        $outstand = News::where('is_outstand', 1)->orderBy('created_at', 'DESC')->take(10)->get();

        return view('cntt.home.blogs.blog', compact('cateMenu', 'viewer', 'outstand', 'newAll'));
    }

    public function cateBlog($slug)
    {
        $cateMenu = CategoryNew::where('parent_id', 0)
        ->where('is_public', 1)
        ->with('children')
        ->get();
        // Tin tức bài viết 
        $newArt = News::where('slug',$slug)->first();
        if(!empty($newArt)) {
            $sameCate = News::where('cate_id', $newArt->cate_id)
            ->orderBy('created_at', 'DESC')->take(10)
            ->get();

            $titleCate = CategoryNew::where('id', $newArt->cate_id)->first();
            $parentIds = $this->categoryNewSrc->getRootParentCategory($newArt->id);
            
            if(empty($newArt)) {
                abort(404);
            }
            return view('cntt.home.blogs.detail', compact('cateMenu', 'newArt', 'sameCate', 'parentIds', 'titleCate'));
        }

        // Danh mục tin tức bài viết
        $cateNew = CategoryNew::where('slug', $slug)->value('id');

        $childrenIds = $this->categoryNewSrc->getAllChildrenIds($cateNew);
        $newArray = array_merge([$cateNew], $childrenIds);

        $titleCate = CategoryNew::where('slug', $slug)->first();
        $news = News::whereIn('cate_id', $newArray)->latest()->paginate(10);
        $viewer = News::whereIn('cate_id', $newArray)->orderBy('view_count', 'DESC')->take(10)->get();
        $outstand = News::whereIn('cate_id', $newArray)->where('is_outstand', 1)->orderBy('created_at', 'DESC')->take(10)->get();
        // Lấy ra sản phẩm liên quan
        $related = CategoryNew::findOrFail($cateNew);
        if (!empty($related->related_pro)) {
            $relatedPro = $related->getRelatedPro();

            return view('cntt.home.blogs.cateBlog', compact('cateMenu', 'titleCate', 'news', 'viewer', 'outstand', 'relatedPro'));
        }

        return view('cntt.home.blogs.cateBlog', compact('cateMenu', 'titleCate', 'news', 'viewer', 'outstand'));
    }

    public function detailBlog($slugParent, $slug)
    {
        $cateMenu = CategoryNew::where('parent_id', 0)
        ->where('is_public', 1)
        ->with('children')
        ->get();

        $cateNew = CategoryNew::where('slug', $slug)->value('id');
        $childrenIds = $this->categoryNewSrc->getAllChildrenIds($cateNew);
        $newArray = array_merge([$cateNew], $childrenIds);

        $parentIds = $this->categoryNewSrc->getRootParentCategory($cateNew);
        // dd($parentIds);
        $titleCate = CategoryNew::where('slug', $slug)->first();
        $news = News::where('cate_id', $newArray)->latest()->paginate(10);
        $viewer = News::where('cate_id', $newArray)->orderBy('view_count', 'DESC')->take(10)->get();
        $outstand = News::where('cate_id', $newArray)->where('is_outstand', 1)->orderBy('created_at', 'DESC')->take(10)->get();
        // Lấy ra sản phẩm liên quan
        $related = CategoryNew::findOrFail($cateNew);
        if (!empty($related->related_pro)) {
            $relatedPro = $related->getRelatedPro();

            return view('cntt.home.blogs.childBlog', compact('cateMenu', 'titleCate', 'news', 'viewer', 'outstand', 'relatedPro', 'parentIds'));
        }

        return view('cntt.home.blogs.childBlog', compact('cateMenu', 'titleCate', 'news', 'viewer', 'outstand', 'parentIds'));
    }
}
