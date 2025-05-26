<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductModel;
use App\Models\ProductSizeModel;
use App\Models\OrderModel;
use App\Models\Order_ItemsModel;
use App\Models\ColorModel;
use App\Models\User;
use Auth;
use Hach;
use Cart;
use Illuminate\Support\Facades\Hash;


class PaymentController extends Controller
{
    public function checkout(Request $request)
    {
        $data['meta_title']='checkout';
        $data['meta_description']='';
        $data['meta_keywords']='';

       return view('Frontend.payment.checkout',$data);
    }

    public function cart(Request $request)
    {
        $data['meta_title']='Cart';
        $data['meta_description']='';
        $data['meta_keywords']='';

       return view('Frontend.payment.cart',$data);
    }
    public function cart_delete($id)
    
    {   
        Cart::remove($id);
        return redirect()->back();

    }


    public function add_to_cart(Request $request)
    {
       $getproduct=ProductModel::getSingle($request->product_id);//يتم استرجاع المنتج من قاعدة البيانات 
       $total=$getproduct->price;
        if(!empty($request->size_id))//إذا كان هناك معرّف للحجم، يتم استرجاع معلومات الحجم وحساب سعره
        {
            $size_id=$request->size_id;
            $getSize=ProductSizeModel::getSingle($size_id);
            
            $size_price=!empty($getSize->price) ? $getSize->price:0;
            $total=$total+$size_price;

        }
        else
        {
            $size_id=0;// .إذا لم يكن هناك معرّف للحجم، يتم تعيين قيمة 0 للحجم 

        }
        $color_id=!empty($request->color_id) ? $request->color_id:0;// . يتم استرجاع معرّف اللون إذا كان موجودا وإلا يرجع 0  

        Cart::add([   //لإضافة المنتج إلى سلة التسوق مع المعلومات اللازمة) Cart::add() يتم اسخدام 
            'id' => $getproduct->id,// (مثل المعرّف والسعر والكمية والخيارات مثل الحجم واللون
            'name' =>'product',
            'price' =>$total,
            'qty' =>$request->qty,
            'options' =>array(
                'size_id' => $size_id,
                'color_id'=>$color_id,       
            )
       ]); 
      return redirect()->back();

    }
    public function update_cart(Request $request)
    {
        foreach($request->cart as $cart)
        {
            Cart::update($cart['id'], array(
                'qty' => array(
                    'relative' => false,
                    'value' => $cart['qty']
                ),
              ));
        }
        return redirect()->back();
       
    }
    public function place_order(Request $request)
    {
        $validate = null; // متغير للتحقق من الأخطاء
        $message = ''; // الرسالة الخاصة بالأخطاء
        $user_id = null; // معرف المستخدم
    
        // التحقق من وجود المستخدم
        if (Auth::check()) {
            // إذا كان المستخدم مسجل الدخول بالفعل
            $user_id = Auth::user()->id;
        } else {
            // إذا لم يكن المستخدم مسجل الدخول
            if (empty($request->is_create)) {
                // التحقق من وجود البريد الإلكتروني في قاعدة البيانات
                $checkEmail = User::where('email', $request->email)->first();
                if ($checkEmail) {
                    $message = "This email is already registered. Please choose another.";
                    $validate = 1;
                } else {
                    // إنشاء مستخدم جديد
                    $save = new User();
                    $save->name = trim($request->first_name);
                    $save->email = trim($request->email);
                    $save->password = Hash::make($request->password);
                    $save->save();
                    $user_id = $save->id;
                }
            } else {
                // إذا كان المستخدم موجود بالفعل ولكن لم يقم بتسجيل الدخول
                $checkEmail = User::where('email', $request->email)->first();
                if ($checkEmail) {
                    // التحقق من كلمة المرور
                    if (Hash::check($request->password, $checkEmail->password)) {
                        $user_id = $checkEmail->id;
                    } else {
                        $message = "Invalid password. Please try again.";
                        $validate = 1;
                    }
                } else {
                    $message = "This email is not registered. Please create an account.";
                    $validate = 1;
                }
            }
        }
    
        // إذا لم يكن هناك أخطاء، تابع في إنشاء الطلب
        if (empty($validate)) {
            $order = new OrderModel();
            $order->user_id = trim($user_id);
            $order->first_name = trim($request->first_name);
            $order->last_name = trim($request->last_name);
            $order->company_name = trim($request->company_name);
            $order->county = trim($request->county);
            $order->address_one = trim($request->address_one);
            $order->address_two = trim($request->address_two);
            $order->city = trim($request->city);
            $order->state = trim($request->state);
            $order->postcode = trim($request->postcode);
            $order->phone = trim($request->phone);
            $order->email = trim($request->email);
            $order->note = trim($request->note);
    
            // الحصول على محتويات السلة من الجلسة
        $cartItemsCollection = session()->get('cart', []);
        
        // تحقق من الهيكل
        if (isset($cartItemsCollection['default']) && $cartItemsCollection['default'] instanceof \Illuminate\Support\Collection) {
            // تحويل مجموعة Collection إلى مصفوفة
            $cartItems = $cartItemsCollection['default']->toArray();
        } else {
            $cartItems = [];
        }

        // حساب المبلغ الإجمالي يدوياً
        $total_amount = 0;
        foreach ($cartItems as $item) {
            // التأكد من أن العناصر تحتوي على الحقول المطلوبة
            if (isset($item['price']) && isset($item['qty'])) {
                $total_amount += $item['price'] * (float) $item['qty']; // تحويل الكمية إلى عدد صحيح
            }
        }

        $order->total_amount = $total_amount; // تعيين إجمالي المبلغ للطلب
        $order->payment_method = trim($request->payment_method);
        $order->save();

        // إضافة عناصر الطلب
        foreach ($cartItems as $item) {
            if (isset($item['id']) && isset($item['price']) && isset($item['qty'])) {
                $order_item = new Order_ItemsModel();
                $order_item->order_id = $order->id;
                $order_item->product_id = $item['id'];
                $order_item->quantity = (int) $item['qty']; // تحويل الكمية إلى عدد صحيح
                $order_item->price = $item['price'];

                // الحصول على اللون
                $color_id = $item['options']['color_id'] ?? null;
                if (!empty($color_id)) {
                    $getColor = ColorModel::getSingle($color_id);
                    if ($getColor) {
                        $order_item->color_name = $getColor->name;
                    }
                }

                // الحصول على الحجم
                $size_id = $item['options']['size_id'] ?? null;
                if (!empty($size_id)) {
                    $getSize = ProductSizeModel::getSingle($size_id);
                    if ($getSize) {
                        $order_item->size_name = $getSize->name;
                        $order_item->size_amount = $getSize->price;
                    }
                }

                // حساب السعر الإجمالي
                $order_item->total_price = $item['price'] * (int) $item['qty']; // تحويل الكمية إلى عدد صحيح
                $order_item->save();
            }
        }

        // إعداد استجابة JSON ناجحة
        return response()->json(['status' => true, 'message' => "Order placed successfully."]);
    } else {
        // إعداد استجابة JSON بفشل
        return response()->json(['status' => false, 'message' => $message]);
    }
}



}
