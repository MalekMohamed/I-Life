<?php

namespace App\Http\Controllers;

use App\Order;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Route::getFacadeRoot()->current()->uri() == 'admin/Orders') {
            $Orders = Order::with('Product')->paginate(15);
            return view('admin.Orders', compact('Orders'));
        } else {
            $Orders = Order::with('Product')->get();
            return view('account.orders', compact('Orders'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (session()->has('cart')) {
            if (session()->has('cart_total')) {
                $promo = 'true';
            } else {
                $promo = 'false';
            }
            $total = 0;
            $items = session()->get('cart');
            foreach (session('cart') as $item) {
                $Product = Product::findOrFail($item['id']);
                $total += $item['price'] * $item['quantity'];
                $grand = $total - ($total * session('cart_total') / 100);
                $details = '{"color":"' . $item['selected-color'] . '","quantity":' . $item['quantity'] . ',"promo": ' . $promo . ',"total":' . $grand . '}';
                $quantity = $Product->quantity - $item['quantity'];
                if ($Product->quantity - $item['quantity'] <= 0) {
                    $quantity = 0;
                    $Product->update(['status' => 0, 'quantity' => $quantity]);
                    $errors = array('error' => ['msg' => 'This Product is Out of Stock.','Item' => $Product->id]);
                }
                $Product->update(['quantity' => $quantity]);
                $Order = Order::create(['product_id' => $item['id'], 'user_id' => Auth::user()->id, 'details' => $details,'total'=>$total])->id;
            }
            if ($Order) {
                session()->forget('cart');
                session()->forget('cart_total');
                return view('account.createOrder', compact('items', 'Order'));
            } else {
                return Redirect()->back()->with($errors);
            }
        } else {
            abort(404);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $Order = Order::findOrFail($request->id);
        $OrderDetails = json_decode($Order->details);
        $promo = $OrderDetails->promo ? 'true' : 'false';
        $OrderDetails = '{"color":"' . $request->color . '","quantity":' . $request->quantity . ',"promo":' . $promo . ',"total":' . $request->total . '}';
        if ($Order->update(['status' => $request->status, 'details' => $OrderDetails,'total'=>$request->total])) {
            return json_encode(array('status' => 'success', 'msg' => 'Order #' . $request->id . ' Has been updated'));
        } else {
            return json_encode(array('status' => 'error', 'msg' => 'Something went wrong!'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if (Order::whereIn('id', $request->data)->delete($request->data)) {
            return json_encode(array('status' => 'success', 'msg' => 'Your Order has been deleted.'));
        } else {
            return json_encode(array('status' => 'error', 'msg' => 'Something went wrong!'));
        }
    }
}
