<?php

namespace App\Http\Controllers;

use App\Address;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
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
        $validatedData = $request->validate([
            'current-password' => 'required|string|min:3',
            'newPassword' => 'required|string|min:3|confirmed',
        ]);
        $User = Auth::user();
        if ($User->update(['password' => Hash::make($request->newPassword)])) {
            return redirect()->back()->with(['msg' => 'Password Updated successfully']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    public function getAddress()
    {
        $addresses = User::with('Addresses')->find(Auth::id());
        return view('account.address', compact('addresses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function storeAddress(Request $request)
    {
        $User = Auth::user();

        $validatedData = $request->validate([
            'address_name' => 'required|string',
            'address' => 'required|string'
        ]);
        if (Address::firstOrCreate(['address' => $validatedData['address'], 'address_name' => $validatedData['address_name'], 'user_id' => $User->id])) {
            return redirect()->back()->with(['msg' => 'Address Added successfully!', 'status' => 'success']);
        } else {
            return redirect()->back()->with(['msg' => 'Something went wrong!', 'status' => 'danger']);
        }
    }

    public function setAddress($address)
    {
        $address = Address::findOrFail($address);
        if ($address->update(['status' => 1])) {
            return redirect()->back()->with(['msg' => 'Your new default address is set successfully!', 'status' => 'success']);
        } else {
            return redirect()->back()->with(['msg' => 'Something went wrong!', 'status' => 'danger']);
        }
    }

    public function DashboardIndex()
    {
        $Users = User::paginate(15);
        return view('admin.Users', compact('Users'));
    }

    public function DashboardUpdate(Request $request)
    {
        $id = $request->id;
        $validatedData = Validator::make($request->all(), [
            'firstname' => 'required|string|max:25',
            'lastname' => 'required|string|max:25',
            'password' => 'required|max:255',
            'email' => 'required|unique:users,email,' . $id,
            'phone' => 'required|string|max:15',
            'admin' => 'boolean',
        ]);
        if ($validatedData->fails()) {
            return json_encode(array('status' => 'error', 'errors' => $validatedData->messages()));
        }
        $User = User::findOrFail($request->id);
        $data = $validatedData->validated();
        $data['password'] = Hash::Make($request->password);
        if ($User->update($data)) {
            return json_encode(array('status' => 'success', 'msg' => 'User Updated Successfuly'));
        } else {
            return json_encode(array('status' => 'error', 'msg' => 'Failed to Update User'));
        }
    }

    public function DashboardStore(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'firstname' => 'required|string|max:25',
            'lastname' => 'required|string|max:25',
            'password' => 'required|max:255',
            'email' => 'required|unique:users',
            'phone' => 'required|string|max:15',
            'admin' => 'boolean',
        ]);
        if ($validatedData->fails()) {
            return json_encode(array('status' => 'error', 'errors' => $validatedData->messages()));
        }
        $data = $validatedData->validated();
        $data['password'] = Hash::Make($request->password);
        if (User::create($data)) {
            return json_encode(array('status' => 'success', 'msg' => 'User Added Successfuly'));
        } else {
            return json_encode(array('status' => 'error', 'msg' => 'Failed to Add User'));
        }
    }

    public function DashboardDestroy(Request $request)
    {
        if (User::whereIn('id', $request->data)->delete($request->data)) {
            return json_encode(array('status' => 'success', 'msg' => 'Your Users has been deleted.'));
        } else {
            return json_encode(array('status' => 'error', 'msg' => 'Something went wrong!'));
        }
    }
}
