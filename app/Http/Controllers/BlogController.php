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

        $cateMenu = CategoryNew::select('name', 'slug')->orderBy('stt_new', 'ASC')
            ->where('is_public', 1)
            ->where('slug','<>','blogs')->get();

        $newAll = News::select('name', 'slug', 'desc', 'image', 'alt_img', 'title_img')->latest()->paginate(10);
        $viewer = News::select('name', 'slug')->orderBy('view_count', 'DESC')->take(10)->get();
        $outstand = News::select('name', 'slug', 'image', 'alt_img', 'title_img')->where('is_outstand', 1)->orderBy('created_at', 'DESC')->take(10)->get();

        return view('cntt.home.blogs.blog', compact(
            'titleSeo', 'keywordSeo', 'descriptionSeo',
            'cateMenu', 'viewer', 'outstand', 'newAll'
        ));
    }

    public function cateBlog($slug)
    {
        $cateMenu = CategoryNew::select('name', 'slug')->orderBy('stt_new', 'ASC')
            ->where('is_public', 1)
            ->where('slug','<>','blogs')->get();
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
            $allParents = $titleCate->getAllParents();
            
            if(empty($newArt)) {
                abort(404);
            }
            return view('cntt.home.blogs.detail', compact(
                'titleSeo', 'keywordSeo', 'descriptionSeo',
                'cateMenu', 'newArt', 'allParents',
                'sameCate', 'titleCate'
            ));
        }
        // Danh mục tin tức bài viết
        $cateNew = CategoryNew::where('slug', $slug)->value('id');
        if(empty($cateNew)) {
            abort(404);
        }
        $childrenIds = $this->categoryNewSrc->getAllChildrenIds($cateNew);
        $newArray = array_merge([$cateNew], $childrenIds);

        $titleCate = CategoryNew::where('slug', $slug)->first();
        $allParents = $titleCate->getAllParents();

        $titleSeo = (!empty($titleCate->title_seo)) ? $titleCate->title_seo : config('common.title_seo_blog');
        $keywordSeo = (!empty($titleCate->keyword_seo)) ? $titleCate->keyword_seo : config('common.keyword_seo_blog');
        $descriptionSeo = (!empty($titleCate->des_seo)) ? $titleCate->des_seo : config('common.des_seo_blog');

        $news = News::select('name', 'slug', 'desc', 'image', 'alt_img', 'title_img')
            ->whereIn('cate_id', $newArray)
            ->latest()->paginate(10);
        $viewer = News::select('name', 'slug')
            ->whereIn('cate_id', $newArray)
            ->orderBy('view_count', 'DESC')->take(10)->get();
        $outstand = News::select('name', 'slug', 'image', 'alt_img', 'title_img')
            ->whereIn('cate_id', $newArray)->where('is_outstand', 1)
            ->orderBy('created_at', 'DESC')->take(10)->get();
        // Lấy ra sản phẩm liên quan
        $related = CategoryNew::findOrFail($cateNew);
        if (!empty($related->related_pro)) {
            $relatedPro = $related->getRelatedPro();

            return view('cntt.home.blogs.cateBlog', compact(
                'titleSeo', 'keywordSeo', 'descriptionSeo',
                'cateMenu', 'titleCate', 'news', 'allParents',
                'viewer', 'outstand', 'relatedPro'
            ));
        }

        return view('cntt.home.blogs.cateBlog', compact(
            'titleSeo', 'keywordSeo', 'descriptionSeo',
            'cateMenu', 'titleCate', 'allParents',
            'news', 'viewer', 'outstand'
        ));
    }

    public function detailBlog($slugParent, $slug)
    {
        $cateMenu = CategoryNew::select('name', 'slug')->orderBy('stt_new', 'ASC')
            ->where('is_public', 1)
            ->where('slug','<>','blogs')->get();
        
        $cateNew = News::where('slug', $slug)->value('id');
        $childrenIds = $this->categoryNewSrc->getAllChildrenIds($cateNew);
        $newArray = array_merge([$cateNew], $childrenIds);

        $titleCate = CategoryNew::where('slug', $slugParent)->first();
        $allParents = $titleCate->getAllParents();
        $titleSeo = (!empty($titleCate->title_seo)) ? $titleCate->title_seo : config('common.title_seo_blog');
        $keywordSeo = (!empty($titleCate->keyword_seo)) ? $titleCate->keyword_seo : config('common.keyword_seo_blog');
        $descriptionSeo = (!empty($titleCate->des_seo)) ? $titleCate->des_seo : config('common.des_seo_blog');
        
        $news = News::select('name', 'slug', 'desc', 'image', 'alt_img', 'title_img')
            ->where('cate_id', $newArray)
            ->latest()->paginate(10);
        $viewer = News::select('name', 'slug')
            ->where('cate_id', $newArray)
            ->orderBy('view_count', 'DESC')->take(10)->get();
        $outstand = News::select('name', 'slug', 'image', 'alt_img', 'title_img')
            ->where('cate_id', $newArray)->where('is_outstand', 1)
            ->orderBy('created_at', 'DESC')->take(10)->get();
        // Lấy ra sản phẩm liên quan
        $related = CategoryNew::findOrFail($cateNew);
        if (!empty($related->related_pro)) {
            $relatedPro = $related->getRelatedPro();

            return view('cntt.home.blogs.childBlog', compact(
                'titleSeo', 'keywordSeo', 'descriptionSeo',
                'cateMenu', 'titleCate', 'news', 'viewer',
                'outstand', 'relatedPro', 'allParents'
            ));
        }

        return view('cntt.home.blogs.childBlog', compact(
            'titleSeo', 'keywordSeo', 'descriptionSeo',
            'cateMenu', 'titleCate', 'news',
            'viewer', 'outstand', 'allParents'
        ));
    }
}
