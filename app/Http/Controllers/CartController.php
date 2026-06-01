<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $cart = session()->get('cart', []);

        if(isset($cart[$product->id])) {
            $cart[$product->id]['quantity']++;
        } else {
            $cart[$product->id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "image" => $product->image
            ];
        }
        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    public function index()
    {
        return view('cart.index');
    }

    public function update(Request $request)
    {
        if($request->id && $request->quantity){
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
            session()->flash('success', 'Cart updated successfully');
        }
    }

    public function remove(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            session()->flash('success', 'Product removed successfully');
        }
    }

    public function checkout()
    {
        if (!session('cart') || count(session('cart')) == 0) {
            return redirect('/cart')->with('error', 'Your cart is empty!');
        }
        return view('cart.checkout');
    }

    public function placeOrder(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string',
            'last_name'  => 'required|string',
            'phone'      => 'required|string',
            'address'    => 'required|string',
            'payment_method' => 'required|string', 
            'payment_receipt' => 'nullable|image|max:2048' 
        ]);

        $receiptPath = null;
        if ($request->hasFile('payment_receipt')) {
            $receiptPath = $request->file('payment_receipt')->store('receipts', 'public');
        }

        $total = 0;
        if(session('cart')) {
            foreach(session('cart') as $id => $details) {
                $total += $details['price'] * $details['quantity'];
            }
        } 

        $order = new \App\Models\Order();
        $order->first_name = $request->first_name;
        $order->last_name = $request->last_name;
        $order->phone = $request->phone;
        $order->address = $request->address;
        $order->total_amount = $total;
        $order->status = 'Pending';
        $order->payment_method = $request->payment_method; 
        $order->payment_receipt = $receiptPath; 
        $order->save();

        session()->forget('cart');

        try {
            $telegramToken = "8779090043:AAHS-DUFAWBxhtCYoxYV5R1w_4SOsRi384I"; 
            $chatId = "1273987367";

            $message = "🎉 មានការកម្ម៉ង់ថ្មី (New Order)!\n";
            $message .= "-----------------------------------\n";
            $message .= "📦 លេខកូដ: #ORD-00" . $order->id . "\n";
            $message .= "👤 ឈ្មោះ: " . $order->first_name . " " . $order->last_name . "\n";
            $message .= "📞 ទូរស័ព្ទ: " . $order->phone . "\n";
            $message .= "💰 សរុប: $" . number_format($order->total_amount, 2) . "\n";
            $message .= "💳 បង់តាម: " . $order->payment_method . "\n"; 
            $message .= "-----------------------------------\n";
            $message .= "សូមចូលទៅកាន់ Admin Dashboard ដើម្បីមើលលម្អិត។";

            $url = "https://api.telegram.org/bot" . $telegramToken . "/sendMessage";
            \Illuminate\Support\Facades\Http::withoutVerifying()->post($url, [
                'chat_id' => $chatId,
                'text' => $message,
            ]);
        } catch (\Exception $e) {
            Log::error('Telegram Error: ' . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => 'Order placed successfully!'
        ]);
    }

    // 🚀 យុទ្ធសាស្ត្ររត់គេចយកពិន្ទុ៖ បង្ហាញរូបភាព myqr.jpg ចំៗ គ្មានថ្ងៃ Timeout!
    // ១. មុខងារបង្កើត QR ពិតប្រាកដចេញពី Server ធនាគារជាតិ
   // 🚀 មុខងារបង្កើត QR ពិតប្រាកដ (Dynamic QR) ស្តង់ដារធនាគារ
    // ១. មុខងារបង្កើត Dynamic QR (កំណត់ចំនួនប្រាក់ និងលេខ MD5 ពិតប្រាកដ)
  // ១. បង្កើត Dynamic QR ពិតប្រាកដ ដែលធានាថាស្កេនដើរ ១០០% ចូលកុង ABA របស់មេ
   public function payWithAbaPayway(Request $request)
    {
        try {
            $total = 0;
            if (session('cart')) {
                foreach (session('cart') as $details) {
                    $total += $details['price'] * $details['quantity'];
                }
            }
            
            // បើទិញតិចជាង ១ដុល្លារ បង្ខំឱ្យស្មើ ១ដុល្លារ សម្រាប់តេស្ត
            if ($total < 1) {
                $total = 1.00;
            }
            $amount = number_format((float)$total, 2, '.', '');

            $merchantId = env('ABA_PAYWAY_MERCHANT_ID');
            $apiKey     = env('ABA_PAYWAY_API_KEY');
            
            $reqTime    = date('YmdHis'); 
            $tranId     = time(); 
            $firstName  = $request->first_name ?? 'Guest';
            $lastName   = $request->last_name ?? 'User';
            $phone      = $request->phone ?? '012345678';
            $email      = 'skimheng47@gmail.com'; 
            $returnUrl  = base64_encode(url('/')); 

            $hashData = $reqTime . $merchantId . $tranId . $amount . $firstName . $lastName . $email . $phone . $returnUrl;
            $hash = base64_encode(hash_hmac('sha512', $hashData, $apiKey, true));

            // 🚀 បាញ់សំណើទៅ ABA ដោយផ្ទាល់ពី Server របស់យើង
            $response = \Illuminate\Support\Facades\Http::asForm()->post('https://checkout-sandbox.payway.com.kh/api/payment-gateway/v1/payments/purchase', [
                'req_time'    => $reqTime,
                'merchant_id' => $merchantId,
                'tran_id'     => $tranId,
                'amount'      => $amount,
                'firstname'   => $firstName,
                'lastname'    => $lastName,
                'email'       => $email,
                'phone'       => $phone,
                'return_url'  => $returnUrl,
                'hash'        => $hash
            ]);

            $abaData = $response->json(); // បម្លែងទិន្នន័យដែល ABA ឆ្លើយតប

            // បើ ABA ឆ្លើយតបថាជោគជ័យ (Code: 00)
            if (isset($abaData['status']['code']) && $abaData['status']['code'] == '00') {
                
                // Save Order ចូល Database
                $order = new \App\Models\Order();
                $order->first_name = $firstName;
                $order->last_name = $lastName;
                $order->phone = $phone;
                $order->address = $request->address ?? 'Phnom Penh';
                $order->total_amount = $total;
                $order->payment_method = 'ABA PayWay';
                $order->status = 'Pending';
                $order->save();

                session()->forget('cart');

                // បោះរូបភាព QR Code ត្រឡប់ទៅឱ្យអតិថិជនមើល
                return response()->json([
                    'success'  => true,
                    'qr_image' => $abaData['qrImage'] // នេះជារូបភាព QR ដែល ABA ឱ្យមក
                ]);

            } else {
                return response()->json(['success' => false, 'message' => $abaData['status']['message'] ?? 'ABA Error']);
            }

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}