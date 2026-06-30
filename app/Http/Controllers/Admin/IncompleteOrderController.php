<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IncompleteOrder;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\OrderStatus;
use App\Models\Shipping;
use Illuminate\Http\Request;
use Toastr;

class IncompleteOrderController extends Controller
{
    public function index(Request $request)
    {
        $show_data = IncompleteOrder::latest()->paginate(10);
        $order_status = (object) [
            'name' => 'Incomplete',
            'orders_count' => IncompleteOrder::count(),
        ];
        $users = \App\Models\User::get();

        $steadfast = null;
        $pathaocities = [];
        $pathaostore = [];

        return view('backEnd.order.incomplete', compact('show_data', 'order_status', 'users', 'steadfast', 'pathaostore', 'pathaocities'));
    }

    public function status_change(Request $request)
    {
        $order_status = OrderStatus::find($request->order_status);
        if (! $order_status) {
            return response()->json(['status' => 'failed', 'message' => 'Status not found']);
        }

        foreach ($request->order_ids as $id) {
            $incompleteOrder = IncompleteOrder::find($id);
            if (! $incompleteOrder) {
                continue;
            }

            if ($order_status->slug == 'cancel' || $order_status->slug == 'cancelled') {
                $incompleteOrder->status = 'cancelled';
                $incompleteOrder->save();

                continue;
            }

            // Migrate to real order
            $order = new Order();
            $order->invoice_id = rand(11111, 99999);
            $order->amount = 0;
            $order->discount = 0;
            $order->shipping_charge = 0;
            $order->customer_id = 0;
            $order->order_status = $order_status->id;
            $order->note = 'Migrated from incomplete order';
            $order->save();

            $shipping = new Shipping();
            $shipping->order_id = $order->id;
            $shipping->name = $incompleteOrder->name;
            $shipping->phone = $incompleteOrder->phone;
            $shipping->address = $incompleteOrder->address;
            $shipping->save();

            // Decode cart and add to order details, recalculate amount
            $cart_items = json_decode($incompleteOrder->cart_details);
            $total = 0;
            if ($cart_items) {
                // If it's stored as associative array or stdClass from Cart::instance('shopping')->content()
                foreach ($cart_items as $item) {
                    $order_details = new OrderDetails();
                    $order_details->order_id = $order->id;
                    $order_details->product_id = $item->id;
                    $order_details->product_name = $item->name;
                    $order_details->sale_price = $item->price;
                    $order_details->qty = $item->qty;
                    $order_details->save();
                    $total += ($item->price * $item->qty);
                }
            }
            $order->amount = $total;
            $order->save();

            // Delete incomplete order
            $incompleteOrder->delete();
        }

        return response()->json(['status' => 'success', 'message' => 'Order statuses updated']);
    }

    public function destroy(Request $request)
    {
        $incompleteOrder = IncompleteOrder::find($request->id);
        if ($incompleteOrder) {
            $incompleteOrder->delete();
            Toastr::success('Success', 'Incomplete order deleted successfully');
        } else {
            Toastr::error('Failed', 'Incomplete order not found');
        }
        return redirect()->back();
    }

    public function bulk_destroy(Request $request)
    {
        $order_ids = $request->order_ids;
        if ($order_ids) {
            IncompleteOrder::whereIn('id', $order_ids)->delete();
            return response()->json(['status' => 'success', 'message' => 'Incomplete orders deleted successfully']);
        }
        return response()->json(['status' => 'failed', 'message' => 'No orders selected']);
    }
}
