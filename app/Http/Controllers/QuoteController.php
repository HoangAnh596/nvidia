<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Helper;
use App\Mail\PriceRequestMail;
use App\Models\Infor;
use App\Models\Quote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class QuoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyWord = $request->input('keyword');
        $quotes = Quote::where('name', 'like', "%" . Helper::escape_like($keyWord) . "%")
            ->latest()
            ->paginate(config('common.default_page_size'));

        return view('admin.quote.index', compact('quotes', 'keyWord'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
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

    // Báo giá gửi mail
    public function sendRequest(Request $request)
    {
        // Validate dữ liệu
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15|min:8',
            'code' => 'required'
        ]);
        // Gửi mail
        try {
            $emails = Infor::where('send_price', 1)->pluck('gmail');
            $customerEmail = $request->email;
            // Mail::to('hoanganhhn596@gmail.com')->send(new PriceRequestMail($request->all()));
            if(!empty($emails)){
                foreach ($emails as $email) {
                    Mail::to($email)
                        ->cc($customerEmail) // Thêm địa chỉ email khách hàng vào CC
                        ->send(new PriceRequestMail($request->all()));
                }
        
            }
            // Lưu báo giá vào bảng quotes
            Quote::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'gmail' => $request->email,
                'product' => $request->code,
                'quantity' => $request->amount,
                'purpose' => $request->purpose
            ]);

            return response()->json(['success' => 'Yêu cầu báo giá đã được gửi thành công.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Đã xảy ra lỗi trong quá trình gửi yêu cầu.'], 500);
        }
    }
}
