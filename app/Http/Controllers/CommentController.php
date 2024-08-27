<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentFormRequest;
use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::where('parent_id', 0)
            ->with('replies')
            ->latest()->paginate(20);

        return view('admin.comment.index', compact('comments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $products = ;
        return view('admin.comment.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CommentFormRequest $request)
    {
        $this->insertOrUpdate($request);

        return redirect()->back()->with(['message' => 'Tạo mới thành công']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $comment = Comment::findOrFail($id);
        // $categories = CategoryNew::with('children')->where('parent_id', 0)->get();
        
        return view('admin.comments.edit', compact('comment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CommentFormRequest $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function insertOrUpdate(Request $request, $id = '')
    {
        $comment = empty($id) ? new Comment() : Comment::findOrFail($id);

        // dd($request->all());
        $comment->fill($request->all());
        
        $comment->save();
    }

    public function search(Request $request)
    {
        $product_id = [];
        if ($search = $request->name) {
            $product_id = Product::where('name', 'LIKE', "%$search%")->get();
        }
        return response()->json($product_id);
    }

    public function sendCmt(CommentFormRequest $request)
    {
        // dd($request->all());
        try {
            $sendCmt = new Comment();
    
            // Lưu các dữ liệu vào commentsendRequest
            $sendCmt->fill($request->all());
    
            // Lưu comment vào cơ sở dữ liệu
            $sendCmt->save();
            // Render view của bình luận mới
            $comment_html = view('cntt.home.partials.cmt', compact('sendCmt'))->render();
            // Trả về phản hồi thành công
            return response()->json([
                'success' => true,
                'comment_html' => $comment_html,
            ]);
        } catch (\Exception $e) {
            // Trả về phản hồi lỗi
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi lưu bình luận.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function parent(Request $request)
    {
        // Kiểm tra xem product_id có tồn tại không
        if ($request->has('product_id')) {
            $cate = Comment::where('product_id', $request->product_id)
                ->where('parent_id', 0)
                ->with('replies')
                ->get();
            
            return response()->json($cate);
        }

        return response()->json([]);
        }
}
