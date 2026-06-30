@php
    $subtotal = Cart::instance('pos_shopping')->subtotal();
    $subtotal = str_replace(',','',$subtotal);
    $subtotal = str_replace('.00', '',$subtotal);
    $shipping = Session::get('pos_shipping', 0);
    $total_discount = (Session::get('pos_discount', 0) + Session::get('product_discount', 0));
@endphp
<tr>
    <td>Sub Total</td>
    <td class="text-end font-weight-semibold">৳{{$subtotal ?: '0'}}</td>
</tr>
<tr>
    <td>Shipping Fee</td>
    <td class="text-end font-weight-semibold">৳{{$shipping ?: '0'}}</td>
</tr>
<tr>
    <td>Discount</td>
    <td class="text-end font-weight-semibold text-danger">-৳{{$total_discount ?: '0'}}</td>
</tr>
<tr class="total-row">
    <td>Grand Total</td>
    <td class="text-end text-primary font-weight-bold">৳{{($subtotal + $shipping) - $total_discount}}</td>
</tr>