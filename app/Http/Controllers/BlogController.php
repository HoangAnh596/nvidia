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
        // Seo website
        $titleSeo = config('common.title_seo_blog');
        $keywordSeo = config('common.keyword_seo_blog');
        $descriptionSeo = config('common.des_seo_blog');
        
        $cateMenu = CategoryNew::where('parent_id', 0)
        ->where('is_public', 1)
        ->with('children')
        ->get();

        $newAll = News::latest()->paginate(10);
        $viewer = News::orderBy('view_count', 'DESC')->take(10)->get();
        $outstand = News::where('is_outstand', 1)->orderBy('created_at', 'DESC')->take(10)->get();

        return view('cntt.home.blogs.blog', compact(
            'titleSeo', 'keywordSeo', 'descriptionSeo',
            'cateMenu', 'viewer', 'outstand', 'newAll'
        ));
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
            $titleSeo = (!empty($newArt->title_seo)) ? $newArt->title_seo : config('common.title_seo_blog');
            $keywordSeo = (!empty($newArt->keyword_seo)) ? $newArt->keyword_seo : config('common.keyword_seo_blog');
            $descriptionSeo = (!empty($newArt->des_seo)) ? $newArt->des_seo : config('common.des_seo_blog');

            $sameCate = News::where('cate_id', $newArt->cate_id)
            ->orderBy('created_at', 'DESC')->take(10)
            ->get();

            $titleCate = CategoryNew::where('id', $newArt->cate_id)->first();
            $parentIds = $this->categoryNewSrc->getRootParentCategory($newArt->id);
            
            if(empty($newArt)) {
                abort(404);
            }
            return view('cntt.home.blogs.detail', compact(
                'titleSeo', 'keywordSeo', 'descriptionSeo',
                'cateMenu', 'newArt',
                'sameCate', 'parentIds', 'titleCate'
            ));
        }

        // Danh mục tin tức bài viết
        $cateNew = CategoryNew::where('slug', $slug)->value('id');
        if(empty($cateNew   )) {
            abort(404);
        }
        $childrenIds = $this->categoryNewSrc->getAllChildrenIds($cateNew);
        $newArray = array_merge([$cateNew], $childrenIds);

        $titleCate = CategoryNew::where('slug', $slug)->first();
        $titleSeo = (!empty($titleCate->title_seo)) ? $titleCate->title_seo : config('common.title_seo_blog');
        $keywordSeo = (!empty($titleCate->keyword_seo)) ? $titleCate->keyword_seo : config('common.keyword_seo_blog');
        $descriptionSeo = (!empty($titleCate->des_seo)) ? $titleCate->des_seo : config('common.des_seo_blog');

        $news = News::whereIn('cate_id', $newArray)->latest()->paginate(10);
        $viewer = News::whereIn('cate_id', $newArray)->orderBy('view_count', 'DESC')->take(10)->get();
        $outstand = News::whereIn('cate_id', $newArray)->where('is_outstand', 1)->orderBy('created_at', 'DESC')->take(10)->get();
        // Lấy ra sản phẩm liên quan
        $related = CategoryNew::findOrFail($cateNew);
        if (!empty($related->related_pro)) {
            $relatedPro = $related->getRelatedPro();

            return view('cntt.home.blogs.cateBlog', compact(
                'titleSeo', 'keywordSeo', 'descriptionSeo',
                'cateMenu', 'titleCate', 'news',
                'viewer', 'outstand', 'relatedPro'
            ));
        }

        return view('cntt.home.blogs.cateBlog', compact(
            'titleSeo', 'keywordSeo', 'descriptionSeo',
            'cateMenu', 'titleCate',
            'news', 'viewer', 'outstand'
        ));
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
        
        $titleCate = CategoryNew::where('slug', $slug)->first();
        $titleSeo = (!empty($titleCate->title_seo)) ? $titleCate->title_seo : config('common.title_seo_blog');
        $keywordSeo = (!empty($titleCate->keyword_seo)) ? $titleCate->keyword_seo : config('common.keyword_seo_blog');
        $descriptionSeo = (!empty($titleCate->des_seo)) ? $titleCate->des_seo : config('common.des_seo_blog');
        
        $news = News::where('cate_id', $newArray)->latest()->paginate(10);
        $viewer = News::where('cate_id', $newArray)->orderBy('view_count', 'DESC')->take(10)->get();
        $outstand = News::where('cate_id', $newArray)->where('is_outstand', 1)->orderBy('created_at', 'DESC')->take(10)->get();
        // Lấy ra sản phẩm liên quan
        $related = CategoryNew::findOrFail($cateNew);
        if (!empty($related->related_pro)) {
            $relatedPro = $related->getRelatedPro();

            return view('cntt.home.blogs.childBlog', compact(
                'titleSeo', 'keywordSeo', 'descriptionSeo',
                'cateMenu', 'titleCate', 'news', 'viewer',
                'outstand', 'relatedPro', 'parentIds'
            ));
        }

        return view('cntt.home.blogs.childBlog', compact(
            'titleSeo', 'keywordSeo', 'descriptionSeo',
            'cateMenu', 'titleCate', 'news',
            'viewer', 'outstand', 'parentIds'
        ));
    }
}
