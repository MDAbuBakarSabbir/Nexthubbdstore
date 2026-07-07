@php
    $subtotal = Cart::instance('shopping')->subtotal();
    $subtotal = str_replace(',', '', $subtotal);
    $subtotal = str_replace('.00', '', $subtotal);
    $shipping = Session::get('shipping') ? Session::get('shipping') : 0;
    $discount = Session::get('discount') ? Session::get('discount') : 0;
@endphp
<div class="table-responsive">
    <table class="order-summary-table">
        <thead>
            <tr>
                <th style="width: 50%;">প্রোডাক্ট</th>
                <th style="width: 25%; text-align: center;">পরিমাণ</th>
                <th style="width: 25%; text-align: right;">মূল্য</th>
            </tr>
        </thead>
        <tbody>
            @foreach (Cart::instance('shopping')->content() as $value)
                <tr>
                    <td>
                        <div class="product-item">
                            <img src="{{ asset($value->options->image) }}" alt="{{ $value->name }}" />
                            <div class="product-details">
                                <a href="{{ route('product', $value->options->slug) }}">{{ Str::limit($value->name, 25) }}</a>
                                @if ($value->options->product_size || $value->options->product_color)
                                    <div class="product-meta">
                                        @if ($value->options->product_size) Size: {{ $value->options->product_size }} @endif
                                        @if ($value->options->product_color) Color: {{ $value->options->product_color }} @endif
                                    </div>
                                @endif
                                <button type="button" class="remove-item-btn cart_remove mt-1 font-12" data-id="{{ $value->rowId }}" style="padding:0; font-size: 11px;">
                                    <i class="fas fa-trash text-danger me-1"></i> বাদ দিন
                                </button>
                            </div>
                        </div>
                    </td>
                    <td style="text-align: center;">
                        <div class="premium-qty">
                            <button type="button" class="minus cart_decrement" data-id="{{ $value->rowId }}">-</button>
                            <input type="text" value="{{ $value->qty }}" readonly />
                            <button type="button" class="plus cart_increment" data-id="{{ $value->rowId }}">+</button>
                        </div>
                    </td>
                    <td style="text-align: right; font-weight: 700; color: #1e293b;">
                        ৳{{ $value->price * $value->qty }}
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr style="border-top: 2px solid #e2e8f0;">
                <td colspan="2" class="text-end font-weight-semibold" style="padding: 12px 16px;">মোট:</td>
                <td style="text-align: right; font-weight: 700; padding: 12px 16px;">৳{{ $subtotal }}</td>
            </tr>
            <tr>
                <td colspan="2" class="text-end font-weight-semibold" style="padding: 12px 16px;">ডেলিভারি চার্জ:</td>
                <td style="text-align: right; font-weight: 700; padding: 12px 16px;">৳{{ $shipping }}</td>
            </tr>
            @if($discount > 0)
            <tr class="text-success">
                <td colspan="2" class="text-end font-weight-bold" style="padding: 12px 16px;">ডিসকাউন্ট:</td>
                <td style="text-align: right; font-weight: 700; padding: 12px 16px;">- ৳{{ $discount }}</td>
            </tr>
            @endif
            <tr style="border-top: 1px solid #e2e8f0; font-size: 16px;">
                <td colspan="2" class="text-end font-weight-bold text-dark" style="padding: 16px;">সর্বমোট:</td>
                <td style="text-align: right; font-weight: 800; color: #fe5200; padding: 16px;">৳{{ ($subtotal + $shipping) - $discount }}</td>
            </tr>
        </tfoot>
    </table>
</div>

<script src="{{asset('public/frontEnd/js/jquery-3.6.3.min.js')}}"></script>
<script>
    $('.cart_store').off('click').on('click', function(){
        var id = $(this).data('id'); 
        var qty = $(this).parent().find('input').val();
        if(id){
            $.ajax({
               type:"GET",
               data:{'id':id,'qty':qty?qty:1},
               url:"{{route('cart.store')}}",
               success:function(data){               
                if(data){
                    return cart_count();
                }
               }
            });
         }  
    });

    $('.cart_remove').off('click').on('click', function(){
        var id = $(this).data('id');   
        if(id){
            $.ajax({
               type:"GET",
               data:{'id':id},
               url:"{{route('cart.remove')}}",
               success:function(data){               
                if(data){
                    $(".cartlist").html(data);
                    return cart_count();
                }
               }
            });
         }  
    });

    $('.cart_increment').off('click').on('click', function(){
        var id = $(this).data('id');  
        if(id){
            $.ajax({
               type:"GET",
               data:{'id':id},
               url:"{{route('cart.increment')}}",
               success:function(data){               
                if(data){
                    $(".cartlist").html(data);
                    return cart_count();
                }
               }
            });
         }  
    });

    $('.cart_decrement').off('click').on('click', function(){
        var id = $(this).data('id');  
        if(id){
            $.ajax({
               type:"GET",
               data:{'id':id},
               url:"{{route('cart.decrement')}}",
               success:function(data){               
                if(data){
                    $(".cartlist").html(data);
                    return cart_count();
                }
               }
            });
         }  
    });

    function cart_count(){
        $.ajax({
           type:"GET",
           url:"{{route('cart.count')}}",
           success:function(data){               
            if(data){
                $("#cart-qty").html(data);
            }else{
               $("#cart-qty").empty();
            }
           }
        }); 
    }
</script>