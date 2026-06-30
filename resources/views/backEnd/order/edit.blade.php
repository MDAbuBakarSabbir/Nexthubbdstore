@extends('backEnd.layouts.master')
@section('title','Order Edit')
@section('css')
<link href="{{asset('public/backEnd')}}/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<link href="{{asset('public/backEnd')}}/assets/libs/summernote/summernote-lite.min.css" rel="stylesheet" type="text/css" />
<style>
    .pos-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 24px rgba(0, 0, 0, 0.05);
        margin-bottom: 24px;
        background: #fff;
    }
    .pos-card-header {
        background-color: #fafbfe;
        border-bottom: 1px solid #f1f3fa;
        padding: 16px 24px;
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
    }
    .pos-card-title {
        font-size: 16px;
        font-weight: 700;
        color: #343a40;
        margin: 0;
    }
    .pos-card-body {
        padding: 24px;
    }
    .form-control, .select2-container .select2-selection--single {
        border-radius: 8px !important;
        border: 1px solid #dee2e6 !important;
        height: 42px !important;
        padding: 6px 12px !important;
        transition: all 0.2s ease-in-out !important;
    }
    .select2-container .select2-selection--single .select2-selection__rendered {
        line-height: 28px !important;
        padding-left: 0 !important;
    }
    .select2-container .select2-selection--single .select2-selection__arrow {
        height: 40px !important;
    }
    .form-control:focus, .select2-container--default.select2-container--focus .select2-selection--single {
        border-color: #6c757d !important;
        box-shadow: 0 0 0 0.15rem rgba(108, 117, 125, 0.15) !important;
    }
    .table-cart {
        margin: 0;
    }
    .table-cart th {
        background-color: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
        color: #495057;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 11px;
        letter-spacing: 0.5px;
        padding: 12px 16px;
    }
    .table-cart td {
        padding: 16px;
        vertical-align: middle;
        border-color: #f1f3fa;
    }
    .product-thumb {
        width: 48px;
        height: 48px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #e3eaef;
    }
    .quantity-selector {
        display: inline-flex;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        overflow: hidden;
        background: #fff;
    }
    .quantity-selector button {
        background: #f8f9fa;
        border: none;
        width: 32px;
        height: 32px;
        font-size: 16px;
        font-weight: 600;
        color: #6c757d;
        transition: background 0.15s;
        cursor: pointer;
    }
    .quantity-selector button:hover {
        background: #e9ecef;
        color: #343a40;
    }
    .quantity-selector input {
        width: 40px;
        border: none;
        border-left: 1px solid #dee2e6;
        border-right: 1px solid #dee2e6;
        text-align: center;
        font-weight: 600;
        color: #495057;
        font-size: 14px;
        height: 32px;
    }
    .discount-input {
        width: 90px;
        border-radius: 6px !important;
        height: 32px !important;
        font-size: 13px !important;
    }
    .summary-table td {
        padding: 12px 0;
        border: none;
        color: #6c757d;
        font-size: 14px;
    }
    .summary-table tr:not(:last-child) td {
        border-bottom: 1px dashed #f1f3fa;
    }
    .summary-table tr.total-row td {
        color: #343a40;
        font-size: 18px;
        font-weight: 700;
        padding-top: 16px;
    }
    .btn-submit-order {
        background: linear-gradient(135deg, #43d39e 0%, #2bb16a 100%);
        border: none;
        border-radius: 8px;
        font-weight: 700;
        color: #fff;
        padding: 12px 24px;
        box-shadow: 0 4px 12px rgba(67, 211, 158, 0.25);
        transition: all 0.2s ease-in-out;
        width: 100%;
    }
    .btn-submit-order:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(67, 211, 158, 0.35);
        color: #fff;
    }
    .delete-btn-custom {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        transition: all 0.2s;
    }
    .page-header-title {
        font-weight: 700;
        color: #343a40;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between py-3">
                <h4 class="page-header-title mb-0">Order Edit</h4>
                <div>
                    <form method="post" action="{{route('admin.order.cart_clear')}}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm rounded-pill delete-confirm" title="Delete"><i class="fas fa-trash-alt me-1"></i> Cart Clear</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <form action="{{route('admin.order.update')}}" method="POST" class="pos_form" data-parsley-validate="" enctype="multipart/form-data">
        @csrf
        <input type="hidden" value="{{$order->id}}" name="order_id">
        <div class="row">
            <!-- Left Column: Products and Cart -->
            <div class="col-lg-8">
                <div class="card pos-card">
                    <div class="pos-card-header">
                        <h5 class="pos-card-title">Select Products</h5>
                    </div>
                    <div class="pos-card-body">
                        <div class="form-group mb-4">
                            <select id="cart_add" class="form-control select2 @error('product_id') is-invalid @enderror" value="{{ old('product_id') }}">
                                <option value="">Select Product...</option>
                                @foreach($products as $value)
                                <option value="{{$value->id}}">{{$value->name}}</option>
                                @endforeach
                            </select>
                            @error('product_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="table-responsive">
                            <table class="table table-cart table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 10%;">Image</th>
                                        <th style="width: 35%;">Name</th>
                                        <th style="width: 20%;">Quantity</th>
                                        <th style="width: 15%;">Price</th>
                                        <th style="width: 10%;">Discount</th>
                                        <th style="width: 10%;">Sub Total</th>
                                        <th style="width: 10%; text-align: center;">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="cartTable">
                                    @php $product_discount = 0; @endphp 
                                    @foreach($cartinfo as $key=>$value)
                                    <tr>
                                        <td><img class="product-thumb" src="{{asset($value->options->image)}}" /></td>
                                        <td class="font-weight-semibold">{{$value->name}}</td>
                                        <td>
                                            <div class="quantity-selector">
                                                <button class="minus cart_decrement" value="{{$value->qty}}" data-id="{{$value->rowId}}">-</button>
                                                <input type="text" value="{{$value->qty}}" readonly />
                                                <button class="plus cart_increment" value="{{$value->qty}}" data-id="{{$value->rowId}}">+</button>
                                            </div>
                                        </td>
                                        <td>৳{{$value->price}}</td>
                                        <td class="discount">
                                            <input type="number" class="form-control discount-input product_discount" value="{{$value->options->product_discount}}" placeholder="0.00" data-id="{{$value->rowId}}" />
                                        </td>
                                        <td class="font-weight-semibold">৳{{($value->price - $value->options->product_discount)*$value->qty}}</td>
                                        <td style="text-align: center;">
                                            <button type="button" class="btn btn-danger btn-sm delete-btn-custom cart_remove" data-id="{{$value->rowId}}"><i class="fa fa-times"></i></button>
                                        </td>
                                    </tr>
                                    @php 
                                        $product_discount += $value->options->product_discount*$value->qty; 
                                        Session::put('product_discount',$product_discount); 
                                    @endphp 
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Customer Info & Order Summary -->
            <div class="col-lg-4">
                <!-- Customer Details Card -->
                <div class="card pos-card">
                    <div class="pos-card-header">
                        <h5 class="pos-card-title">Customer Information</h5>
                    </div>
                    <div class="pos-card-body">
                        <div class="form-group mb-3">
                            <label class="form-label font-weight-semibold">Customer Name *</label>
                            <input type="text" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter name" name="name" value="{{$shippinginfo->name}}" required />
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label font-weight-semibold">Customer Number *</label>
                            <input type="number" id="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="Enter phone number" name="phone" value="{{$shippinginfo->phone}}" required />
                            @error('phone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label font-weight-semibold">Address *</label>
                            <input type="text" placeholder="Enter delivery address" id="address" class="form-control @error('address') is-invalid @enderror" name="address" value="{{$shippinginfo->address}}" required />
                            @error('address')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label font-weight-semibold">Delivery Area *</label>
                            <select id="area" class="form-control select2 @error('area') is-invalid @enderror" name="area" required>
                                <option value="">Select Area...</option>
                                @foreach($shippingcharge as $key=>$value)
                                <option value="{{$value->id}}" @if($shippinginfo->area == $value->name) selected @endif>{{$value->name}}</option>
                                @endforeach
                            </select>
                            @error('area')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Order Summary Card -->
                <div class="card pos-card">
                    <div class="pos-card-header">
                        <h5 class="pos-card-title">Order Summary</h5>
                    </div>
                    <div class="pos-card-body">
                        <table class="table summary-table mb-3">
                            <tbody id="cart_details">
                                @php 
                                    $subtotal = Cart::instance('pos_shopping')->subtotal(); 
                                    $subtotal = str_replace(',','',$subtotal); 
                                    $subtotal = str_replace('.00', '',$subtotal); 
                                    $shipping = Session::get('pos_shipping') ?? 0; 
                                    $total_discount = Session::get('pos_discount') + Session::get('product_discount'); 
                                @endphp
                                <tr>
                                    <td>Sub Total</td>
                                    <td class="text-end font-weight-semibold">৳{{$subtotal}}</td>
                                </tr>
                                <tr>
                                    <td>Shipping Fee</td>
                                    <td class="text-end font-weight-semibold">৳{{$shipping}}</td>
                                </tr>
                                <tr>
                                    <td>Discount</td>
                                    <td class="text-end font-weight-semibold text-danger">-৳{{$total_discount}}</td>
                                </tr>
                                <tr class="total-row">
                                    <td>Grand Total</td>
                                    <td class="text-end text-primary">৳{{($subtotal + $shipping) - $total_discount}}</td>
                                </tr>
                            </tbody>
                        </table>
                        
                        <button type="submit" class="btn btn-submit-order"><i class="fas fa-save me-2"></i> Update Order</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection 
@section('script')
<script src="{{asset('public/backEnd/')}}/assets/libs/parsleyjs/parsley.min.js"></script>
<script src="{{asset('public/backEnd/')}}/assets/js/pages/form-validation.init.js"></script>
<script src="{{asset('public/backEnd/')}}/assets/libs/select2/js/select2.min.js"></script>
<script src="{{asset('public/backEnd/')}}/assets/js/pages/form-advanced.init.js"></script>
<!-- Plugins js -->
<script src="{{asset('public/backEnd/')}}/assets/libs//summernote/summernote-lite.min.js"></script>
<script>
    $(".summernote").summernote({
        placeholder: "Enter Your Text Here",
    });
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $('.select2').select2();
    });
</script>
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

      $('#cart_add').on('change',function(e){
       var id =$(this).val();
        if(id){
            $.ajax({
            cache: 'false',
            type:"GET",
            data:{'id':id},
            url:"{{route('admin.order.cart_add')}}",
            dataType: "json",
            success: function(cartinfo){
                return cart_content()+cart_details();
            }
            });
        }
       });
    $(".cart_increment").click(function(e){
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
                return cart_content()+cart_details();
            }
          });
        }
   });
    $(".cart_decrement").click(function(e){
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
                return cart_content()+cart_details();
            }
          });
        }
   });
    $(".cart_remove").click(function(e){
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
                return cart_content()+cart_details();
            }
          });
        }
   });
   $(".product_discount").change(function(){
        var id = $(this).data("id");
        var discount = $(this).val();
          $.ajax({
           cache: false,
           type:"GET",
           data:{'id':id,'discount':discount},
           url:"{{route('admin.order.product_discount')}}",
           dataType: "json",
          success: function(cartinfo){
            return cart_content()+cart_details();
          }
        });
   });
    $(".cartclear").click(function(e){
      $.ajax({
           cache: false,
           type:"GET",
           url:"{{route('admin.order.cart_clear')}}",
           dataType: "json",
          success: function(cartinfo){
            return cart_content()+cart_details();
          }
       });
   });// pshippingfee from total
    $("#area").on("change", function () {
        var id = $(this).val();
        $.ajax({
            type: "GET",
            data: { id: id },
            url: "{{route('admin.order.cart_shipping')}}",
            dataType: "html",
            success: function(cartinfo){
               return cart_content()+cart_details();
            }
        });
    });
</script>
@endsection
