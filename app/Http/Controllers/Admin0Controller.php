<?php

namespace App\Http\Controllers;

use App\Http\Requests\InsertIntoCategories;
use App\Http\Requests\InsertIntoProduct;
use App\Http\Requests\RegisterRequest;
use App\Models\admin;
use App\Http\Requests\StoreadminRequest;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateadminRequest;
use App\Models\Categorie;
use App\Models\Product;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Models\ProductOrder;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\search1;
use App\Models\Notification;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class Admin0Controller extends Controller

{
    use HttpResponses;


    public function Register(StoreadminRequest $request)
    {
        $request->validated($request->all);
        $user = admin::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);
        return $this->success([
            'user' => $user,
            'token' => $user->createToken('API Token of' . $user->name)->plainTextToken,
        ]);
    }

    public function Login(UpdateadminRequest $request)
    {
        $users = admin::where('phone', $request->phone)->first();
        if (!$users || !Hash::check($request->password, $users->password)) {
            return $this->error('', 'Credentials do not match', 401);
        }
        // $user=DB::table('users')->where($request->phone)->get();
        //   $user= DB::select('select * from users where phone = ?', $request->phone);

        // return $users;
        return $this->success([
            'user' => $users,
            'token' => $users->createToken('API Token of' . $users->name)->plainTextToken,

        ]);
    }

    public function Logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return $this->success([
            'message' => 'you have successfully been logged out',
        ]);
    }


   public function InsertProduct(InsertIntoProduct $request)

    {
        $p = Product::get();
        $po = Product::get('scientific_name');
        $po = Product::get('createdat');
        if (!(Product::where('scientific_name', $request->scientific_name))->first() || !(Product::where('createdat', $request->createdat))->first() || $p->isEmpty()) {
            $product = Product::create($request->validated());
        } else if (Product::where('scientific_name', $request->scientific_name) && Product::where('createdat', $request->createdat)) {
            $product = Product::where('scientific_name', $request->scientific_name)->first();
            $product->decrement('quantity_available', -$request->quantity_available);
        }
        return response([
            'data' => $product,
            'message' => 'you insert product'
        ]);
    }

    public function InsertCategories(InsertIntoCategories $request)
    {

        if ($product = Categorie::create($request->validated())) {
            return response([
                'data' => $product,
                'message' => 'you  insert Categories successfully',
            ]);
        }
        return response([
            'message' => 'somthing wrong'
        ], 500);
    }
    public function getProduct()
    {
        $product = Product::get();
        return $product;
    }
    public function getCategories()
    {
        $product = Categorie::get();
        return $product;
    }
    public function getOrderDetails(User $user, Order $order)
    {

        $user = auth()->user();

        if ($orderDetails = $order->with('products')->get()) {
            return response([
                'data' => $orderDetails,
                'message' => 'this is your order',
            ]);
        }
        return response([
            'message' => 'this order does not exist'
        ], 500);
    }
    public function stauts(Request $request)
    {
        $id = $request->id;
        $order = $request->id_order;
        $array = ProductOrder::all();
$user_id=$request->user_id;
$fcm=User::find($user_id)->fcm_token;


        if ($id == 1) {
            DB::table('orders')->where('id', $order)->update(['status' => 'Has_Been_Sent']);

            foreach ($array as $item) {
                $product = Product::where('id', $item['product_id'])->first();
                if ($product) {
                    $quantityToSubtract = $item['quantity'];
                    $product->decrement('quantity_available', $quantityToSubtract);
                }

            }
$this->send($fcm,'the stutus of you order','Has_Been_Sent');


            return response()->json([
                'message' => 'the order status has been changed to Has_Been_Sent',


            ], 200);
        } else if ($id == 2) {
            DB::table('orders')->where('id', $order)->update(['status' => 'Received']);

$this->send($fcm,'the stutus of you order','Is Received');

            return response([
                'message' => 'the order status has been changed to Received'
            ], 200);
        }
    }
public function notification(){
$e=Notification::get('data');
return response(['data'=>$e]);
}

public function showpayement(Request $request){
$timeF = $request->timeF;
        $timeE = $request->timeE;
$r=Order::whereBetween('created_at',[$timeE,$timeF])->get();
return response([
'data'=>$r,
]);
}
    public function paid(Request $request)
    {
        $id = $request->id;
        $order = $request->id_order;

        if ($id == 1) {
            DB::table('orders')->where('id', $order)->update(['payment_status' => 'paid']);
            return response([
                'message' => 'the order payment_status has been changed to paid'
            ], 200);
        }
    }
public function expiration()
    {
        $user = Auth::user();

        $exp = Product::where('quantity_available', '=', 0)->get();

        $ex = Product::where('createdat', '<', Carbon::now())->get();


        foreach ($ex as $product) {

            $product->delete();
        }
        foreach ($exp as $product) {

            $product->delete();
        }
        return response()->json(['expiration' => $ex, 'quantity_available' => $exp]);
    }
//////////////////////////////////////////////////////////

    public function all_expiration()
    {
        $user = Auth::user();

        $e = Product::onlyTrashed()->get();

        return response()->json(['data' => $e]);
    }
//////////////////////////////////////////////////////////

    public function deleteExpiration()
    {
        $user = Auth::user();

        $expiredInventory = Product::onlyTrashed()->get();

        foreach ($expiredInventory as $product) {
            $product->forceDelete();
        }

        return response()->json(['message' => 'Soft-deleted products permanently deleted.']);
    }
//////////////////////////////////////////////////////////
}
