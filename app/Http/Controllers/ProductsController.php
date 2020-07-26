<?php

namespace App\Http\Controllers;

use App\Product;
use App\PromoCode;
use App\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Integer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Route::getFacadeRoot()->current()->uri() == 'admin/Products') {
            $Products = Product::with('rating')->paginate(15);
            return view('admin.Products', compact('Products'));
        } else {
            return view('shop');
        }
    }

    public static function getItems($category)
    {
        $items = Product::where('category', '=', $category)->orderBy('id', 'desc')->take(3)->get();
        return $items;
    }

    public function indexCategory($category)
    {
        $category = str_replace('-', ' ', $category);
        $items = Product::where('category', '=', $category)->orderBy('id', 'desc')->get();
        return view('category-shop', compact('items'));
    }

    public function addCart(Request $request)
    {
        $id = $request->Item['id'];
        $product = Product::find($id);
        $counter = count(session('cart')) + 1;
        if (!$product) {
            abort(404);
        }
        $cart = session()->get('cart');
        $available_colors = explode(',', $product->color);
        if (!isset($request->Color)) {
            $color = $available_colors[0];
        } else {
            $color = $request->Color;
        }
        // if cart is empty then this the first product
        if (!$cart) {
            $cart = [
                $counter => [
                    "id" => $id,
                    "name" => $product->name,
                    "quantity" => $request->Quantity,
                    "price" => $product->price,
                    "colors" => $available_colors,
                    "selected-color" => $color,
                    "category" => $product->category,
                    "image" => $product->images
                ]
            ];

            session()->put('cart', $cart);

            return json_encode(array('status' => 'success', 'msg' => 'Product added to cart successfully!'));
        }

        // if cart not empty then check if this product exist then increment quantity
        foreach ($cart as $key => $item) {
            if ($item['selected-color'] == $request->Color && $item['id'] == $id) {
                $cart[$key]['quantity'] += $request->Quantity;
                session()->put('cart', $cart);

                return json_encode(array('status' => 'success', 'msg' => 'Product quantity changed successfully!'));
            }
        }

        // if item not exist in cart then add to cart with quantity = 1
        $cart[$counter] = [
            "id" => $id,
            "name" => $product->name,
            "quantity" => $request->Quantity,
            "price" => $product->price,
            "colors" => $available_colors,
            "selected-color" => $color,
            "category" => $product->category,
            "image" => $product->images
        ];

        session()->put('cart', $cart);

        return json_encode(array('status' => 'success', 'msg' => 'Product added to cart successfully!'));
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $check = Product::where('name', '=', $request->name)->first();
        if (!$check) {
            $specs_arr = null;
            if ($request->has('specification')) {
                $specs_arr = '{';
                foreach ($request->specification as $key => $spec) {
                    $specs_arr .= '"' . $key . '":"' . $spec . '",';
                }
                $specs_arr = substr($specs_arr, 0, -1);
                $specs_arr .= '}';
            }
            if ($request->hasFile('images')) {
                $nextId = DB::select("SHOW TABLE STATUS LIKE 'products'")[0]->Auto_increment;
                foreach ($request->file('images') as $file) {
                    $name = $file->getClientOriginalName();
                    $extention = $file->clientExtension();
                    if ($extention == 'png' || $extention == 'jpg' || $extention == 'jpeg') {
                        $file->move(public_path('img/shop/' . $nextId . '/'), $name);
                        $data[] = $name;
                    }
                }
            }
            if (!empty($data)) {
                $images = json_encode($data) ?? 'default.png';
            }
            if (Product::create(['name' => $request->name, 'images' => $images, 'category' => $request->category, 'description' => $request->description, 'specification' => $specs_arr, 'price' => $request->price, 'color' => $request->colors, 'status' => $request->status, 'quantity' => $request->quantity])) {
                return json_encode(array('status' => 'success', 'msg' => 'Product ' . $request->name . ' Has been Inserted'));
            } else {
                return json_encode(array('status' => 'error', 'msg' => 'Something went wrong!'));
            }
        } else {
            return json_encode(array('status' => 'error', 'msg' => 'Something went wrong!'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  Integer $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Product::with('rating')->where([['id', '=', $id], ['status', '!=', 2]])->get()->first();
        if ($item) {
            $rates = Rating::with('User')->where('product_id', '=', $item['id'])->get();
            return view('product.view', compact('item', 'rates'));
        } else {
            abort(404);
        }
    }

    public function promoCode(Request $request)
    {
        $code = PromoCode::where('code', '=', $request->code)->get()->first();
        $total = 0;
        if (!empty($code) and $code['status'] == 0) {
            foreach (session('cart') as $details) {
                $total += $details['price'] * $details['quantity'];
            }
            $total = $total - ($total * $code['discount'] / 100);
            session()->put('cart_total', $code['discount']);
            $resp = array('status' => 'success', 'data' => $total, 'discount' => $code['discount']);
        } elseif ($code['status'] == 1) {
            $resp = array('status' => 'danger', 'data' => 'This code already redeemed');
        } else {
            $resp = array('status' => 'danger', 'data' => 'Invalid Promo Code');
        }
        return json_encode($resp);
    }

    public function rate(Request $request)
    {
        if (Auth::user()) {
            $checkUserRate = Rating::where([['product_id', '=', $request->product_id]], ['user_id', '=', Auth::user()->id]);
            if ($checkUserRate->count() == 0) {
                // Insert new rate
                Rating::create([
                    'product_id' => $request->product_id,
                    'comment' => $request->comment,
                    'user_id' => Auth::user()->id,
                    'rate' => $request->rate
                ]);
                $resp = array('msg' => 'Product Rated', 'status' => 'success');
            } else {
                $oldRate = $checkUserRate->get()->first();
                Rating::find($oldRate['id'])->update(['rate' => $request->rate, 'comment' => $request->comment]);
                $resp = array('msg' => 'Product rate updated', 'status' => 'success');
            }
            return json_encode($resp);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product $Product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $Product)
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
        $Product = Product::findOrFail($request->id);
        if ($request->specification) {
            $specification = json_decode($request->specification);
            $specs = get_object_vars($specification);
            $specs_arr = '{';
            foreach ($specs as $key => $spec) {
                $specs_arr .= '"' . $key . '":"' . $spec . '",';
            }
            $specs_arr = substr($specs_arr, 0, -1);
            $specs_arr .= '}';
        } else {
            $specs_arr = null;
        }
        if ($Product->update(['name' => $request->name, 'color' => $request->colors, 'price' => $request->price, 'quantity' => $request->quantity, 'status' => $request->status, 'category' => $request->category, 'specification' => $specs_arr])) {
            return json_encode(array('status' => 'success', 'msg' => 'Product #' . $request->id . ' Has been updated'));
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
        if (Product::whereIn('id', $request->data)->delete($request->data)) {
            return json_encode(array('status' => 'success', 'msg' => 'Your Order has been deleted.'));
        } else {
            return json_encode(array('status' => 'error', 'msg' => 'Something went wrong!'));
        }
    }

    public function updateCart(Request $request)
    {
        if ($request->id and $request->quantity) {
            $cart = session()->get('cart');

            $cart[$request->id]["quantity"] = $request->quantity;
            $cart[$request->id]["selected-color"] = $request->color;
            session()->put('cart', $cart);

            session()->flash('success', 'Cart updated successfully');
        }
    }

    public function removeCart(Request $request)
    {
        if ($request->id) {

            $cart = session()->get('cart');

            if (isset($cart[$request->id])) {

                unset($cart[$request->id]);

                session()->put('cart', $cart);
            }

            session()->flash('success', 'Product removed successfully');
        }
    }
}
