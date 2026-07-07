<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Toastr;

class CouponController extends Controller
{
    public function index()
    {
        $show_data = Coupon::latest()->get();

        return view('backEnd.coupon.index', compact('show_data'));
    }

    public function create()
    {
        return view('backEnd.coupon.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|unique:coupons,coupon_code',
            'discount_type' => 'required',
            'amount' => 'required|numeric',
            'expiry_date' => 'required|date',
            'buy_amount' => 'nullable|numeric',
            'quantity' => 'nullable|integer|min:1',
            'start_date' => 'nullable|date',
        ]);

        $input = $request->all();
        $input['status'] = $request->status ? 1 : 0;
        Coupon::create($input);

        Toastr::success('Success', 'Coupon created successfully');

        return redirect()->route('admin.coupons.index');
    }

    public function edit($id)
    {
        $edit_data = Coupon::findOrFail($id);

        return view('backEnd.coupon.edit', compact('edit_data'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|unique:coupons,coupon_code,'.$request->hidden_id,
            'discount_type' => 'required',
            'amount' => 'required|numeric',
            'expiry_date' => 'required|date',
            'buy_amount' => 'nullable|numeric',
            'quantity' => 'nullable|integer|min:1',
            'start_date' => 'nullable|date',
        ]);

        $update_data = Coupon::findOrFail($request->hidden_id);
        $input = $request->all();
        $input['status'] = $request->status ? 1 : 0;
        $update_data->update($input);

        Toastr::success('Success', 'Coupon updated successfully');

        return redirect()->route('admin.coupons.index');
    }

    public function inactive(Request $request)
    {
        $inactive = Coupon::findOrFail($request->hidden_id);
        $inactive->status = 0;
        $inactive->save();
        Toastr::success('Success', 'Coupon inactivated successfully');

        return redirect()->back();
    }

    public function active(Request $request)
    {
        $active = Coupon::findOrFail($request->hidden_id);
        $active->status = 1;
        $active->save();
        Toastr::success('Success', 'Coupon activated successfully');

        return redirect()->back();
    }

    public function destroy(Request $request)
    {
        $delete_data = Coupon::findOrFail($request->hidden_id);
        $delete_data->delete();
        Toastr::success('Success', 'Coupon deleted successfully');

        return redirect()->back();
    }
}
