<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\PriceRequestMail;
use App\Models\Infor;
use Illuminate\Support\Facades\Mail;

class SendPriceController extends Controller
{
    // Báo giá gửi mail
    public function sendRequest(Request $request)
    {
        // Validate dữ liệu
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15|min:8',
        ]);
        // Gửi mail
        try {
            $emails = Infor::where('send_price', 1)->pluck('gmail');
            // Mail::to('hoanganhhn596@gmail.com')->send(new PriceRequestMail($request->all()));
            if(!empty($emails)){
                foreach ($emails as $email) {
                    Mail::to($email)->send(new PriceRequestMail($request->all()));
                }

                return response()->json(['success' => 'Yêu cầu báo giá đã được gửi thành công.']);
            }

            return response()->json(['error' => 'Không có mail nào nhận báo giá.'], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Đã xảy ra lỗi trong quá trình gửi yêu cầu.'], 500);
        }
    }
}
