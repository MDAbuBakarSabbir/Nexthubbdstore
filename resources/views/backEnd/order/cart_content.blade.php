@php
  $product_discount = 0;
@endphp
@if($cartinfo->isEmpty())
<tr>
  <td colspan="7" class="text-center py-4 text-muted">
    <i class="fas fa-shopping-basket fa-2x mb-2 d-block text-secondary"></i>
    No products added yet. Please select products from above.
  </td>
</tr>
@else
@foreach($cartinfo as $key=>$value)
<tr>
  <td><img class="product-thumb" src="{{asset($value->options->image)}}" alt="{{$value->name}}"></td>
  <td class="font-weight-semibold">{{$value->name}}</td>
  <td>
    <div class="quantity-selector">
      <button type="button" class="minus cart_decrement" value="{{$value->qty}}" data-id="{{$value->rowId}}">-</button>
      <input type="text" value="{{$value->qty}}" readonly />
      <button type="button" class="plus cart_increment" value="{{$value->qty}}" data-id="{{$value->rowId}}">+</button>
    </div>
  </td>
  <td>৳{{$value->price}}</td>
  <td class="discount">
    <input type="number" class="form-control discount-input product_discount" value="{{$value->options->product_discount}}" placeholder="0.00" data-id="{{$value->rowId}}">
  </td>
  <td class="font-weight-semibold">৳{{($value->price - $value->options->product_discount)*$value->qty}}</td>
  <td style="text-align: center;">
    <button type="button" class="btn btn-danger btn-sm delete-btn-custom cart_remove" data-id="{{$value->rowId}}" title="Remove Item"><i class="fa fa-times"></i></button>
  </td>
</tr>
@php
  $product_discount += $value->options->product_discount*$value->qty;
  Session::put('product_discount',$product_discount);
@endphp
@endforeach
@endif
<script>
    function cart_content(){
           $.ajax({
             type:"GET",
             url:"{{route('admin.order.cart_content')}}",
             dataType: "html",
             success: function(cartinfo){
               $('#cartTable').html(cartinfo)
             }
          });
      }
      function cart_details(){
           $.ajax({
             type:"GET",
             url:"{{route('admin.order.cart_details')}}",
             dataType: "html",
             success: function(cartinfo){
               $('#cart_details').html(cartinfo)
             }
          });
      }
    $(".cart_increment").off("click").on("click", function(e){
        e.preventDefault();
        var id = $(this).data("id");
        var qty = $(this).val();
        if(id){
              $.ajax({
               cache: false,
               data:{'id':id,'qty':qty},
               type:"GET",
               url:"{{route('admin.order.cart_increment')}}",
               dataType: "json",
            success: function(cartinfo){
                cart_content();
                cart_details();
            }
          });
        }
   });
    $(".cart_decrement").off("click").on("click", function(e){
        e.preventDefault();
        var id = $(this).data("id");
        var qty = $(this).val();
        if(id){
              $.ajax({
               cache: false, 
               type:"GET",
               data:{'id':id,'qty':qty},
               url:"{{route('admin.order.cart_decrement')}}",
               dataType: "json",
            success: function(cartinfo){
                cart_content();
                cart_details();
            }
          });
        }
   });
    $(".cart_remove").off("click").on("click", function(e){
        e.preventDefault();
        var id = $(this).data("id");
        if(id){
              $.ajax({
               cache: false,
               type:"GET",
               data:{'id':id},
               url:"{{route('admin.order.cart_remove')}}",
               dataType: "json",
              success: function(cartinfo){
                cart_content();
                cart_details();
            }
          });
        }
   });
   $(".product_discount").off("change").on("change", function(){
        var id = $(this).data("id");
        var discount = $(this).val();
          $.ajax({
           cache: false,
           type:"GET",
           data:{'id':id,'discount':discount},
           url:"{{route('admin.order.product_discount')}}",
           dataType: "json",
          success: function(cartinfo){
            cart_content();
            cart_details();
          }
        });
   });
    $(".cartclear").off("click").on("click", function(e){
      e.preventDefault();
      $.ajax({
           cache: false,
           type:"GET",
           url:"{{route('admin.order.cart_clear')}}",
           dataType: "json",
          success: function(cartinfo){
            cart_content();
            cart_details();
          }
       });
   });
    $("#area").off("change").on("change", function () {
        var id = $(this).val();
        $.ajax({
            type: "GET",
            data: { id: id },
            url: "{{route('admin.order.cart_shipping')}}",
            dataType: "html",
            success: function(cartinfo){
               cart_content();
               cart_details();
            }
        });
    });
</script>