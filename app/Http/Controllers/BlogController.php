<?php

namespace App\Http\Controllers;

use App\Models\CategoryNew;
use App\Models\CmtNew;
use App\Models\News;
use App\Services\CategoryNewSrc;
use Illuminate\Support\Facades\Auth;

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
            ->where('slug', '<>', 'blogs')->get();

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
            ->where('slug', '<>', 'blogs')->get();
        // Tin tức bài viết 
        $newArt = News::where('slug', $slug)->first();
        if (!empty($newArt)) {
            $titleSeo = (!empty($newArt->title_seo)) ? $newArt->title_seo : config('common.title_seo_blog');
            $keywordSeo = (!empty($newArt->keyword_seo)) ? $newArt->keyword_seo : config('common.keyword_seo_blog');
            $descriptionSeo = (!empty($newArt->des_seo)) ? $newArt->des_seo : config('common.des_seo_blog');

            $sameCate = News::where('cate_id', $newArt->cate_id)
                ->orderBy('created_at', 'DESC')->take(10)
                ->get();

            $titleCate = CategoryNew::where('id', $newArt->cate_id)->first();
            $allParents = $titleCate->getAllParents();
            // Comments 
            $commentsQuery = CmtNew::query(); // Khởi tạo query builder cho bảng comments

            if (Auth::check() && Auth::user()->role == 1) {
                // Nếu role = 1, lấy tất cả các comments cho sản phẩm này
                $commentsQuery->where('cmt_news.new_id', $newArt->id)
                    ->where('cmt_news.parent_id', 0)
                    ->with('replies') // Load các bình luận con
                    ->orderBy('cmt_news.created_at', 'DESC');
            } else {
                // Nếu role khác 1, lấy các bình luận public hoặc bình luận của chính người dùng đó
                $commentsQuery->where('cmt_news.new_id', $newArt->id)
                    ->where('cmt_news.parent_id', 0)
                    ->where(function ($query) {
                        $query->where('cmt_news.is_public', 1) // Hiển thị bình luận công khai
                            ->orWhere(function ($query) {
                                // Nếu bình luận của chính người dùng hiện tại, hiển thị nó bất kể is_public là gì
                                $query->whereNotNull('cmt_news.user_id')->where('cmt_news.user_id', Auth::id());
                            });
                    })
                    ->with('cmtChild') // Load các bình luận con
                    ->orderBy('cmt_news.created_at', 'DESC');
            }

            $comments = $commentsQuery->get();

            // Tính tổng số bình luận (cha + con)
            $totalCommentsCount = CmtNew::where('new_id', $newArt->id)
                ->where(function ($query) {
                    $query->where('parent_id', 0) // Bình luận cha
                        ->orWhere(function ($query) {
                            $query->where('parent_id', '>', 0); // Bình luận con
                        });
                })
                ->where(function ($query) {
                    if (!Auth::check() || Auth::user()->role != 1) {
                        $query->where('is_public', 1) // Hiển thị bình luận công khai
                            ->orWhere(function ($query) {
                                $query->whereNotNull('user_id')
                                    ->where('user_id', Auth::id());
                            });
                    }
                })
                ->count();
            $user = Auth::user();
            
            return view('cntt.home.blogs.detail', compact(
                'titleSeo', 'keywordSeo', 'descriptionSeo',
                'cateMenu', 'newArt', 'allParents',
                'sameCate', 'titleCate',
                'comments', 'totalCommentsCount', 'user'
            ));
        }
        // Danh mục tin tức bài viết
        $cateNew = CategoryNew::where('slug', $slug)->value('id');
        if (empty($cateNew)) {
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
            ->where('slug', '<>', 'blogs')->get();

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
