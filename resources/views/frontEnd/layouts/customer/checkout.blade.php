@extends('frontEnd.layouts.master')
@section('title', 'Customer Checkout')

@push('css')
<link rel="stylesheet" href="{{ asset('public/frontEnd/css/select2.min.css') }}" />
<style>
    .chheckout-section {
        background-color: #f4f6f8;
        padding: 50px 0;
    }
    .checkout-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
        background: #ffffff;
        margin-bottom: 24px;
        overflow: hidden;
    }
    .checkout-card .card-header {
        background-color: #ffffff;
        border-bottom: 1px solid #f1f3f5;
        padding: 24px;
    }
    .checkout-card .card-header h5 {
        margin: 0;
        font-weight: 700;
        color: #1e293b;
        font-size: 18px;
    }
    .checkout-card .card-body {
        padding: 24px;
    }
    .form-label-premium {
        font-weight: 600;
        color: #475569;
        margin-bottom: 8px;
        font-size: 14px;
    }
    .form-control-premium {
        border-radius: 10px;
        border: 1px solid #cbd5e1;
        padding: 12px 16px;
        font-size: 14px;
        color: #1e293b;
        transition: all 0.3s ease;
        background: #f8fafc;
    }
    .form-control-premium:focus {
        border-color: #fe5200;
        box-shadow: 0 0 0 3px rgba(254, 82, 0, 0.15);
        outline: none;
        background: #ffffff;
    }
    .payment-card-label {
        width: 100%;
        cursor: pointer;
        display: block;
    }
    .payment-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 2px solid #e2e8f0 !important;
        border-radius: 12px;
        padding: 16px;
        background: #ffffff;
    }
    .payment-card:hover {
        border-color: #cbd5e1 !important;
        transform: translateY(-2px);
    }
    .payment-card-label input:checked + .payment-card {
        border-color: #fe5200 !important;
        background-color: rgba(254, 82, 0, 0.04);
        box-shadow: 0 4px 12px rgba(254, 82, 0, 0.08);
    }
    .payment-card-label input:checked + .payment-card i {
        color: #fe5200 !important;
    }
    .order-summary-table {
        width: 100%;
        border-collapse: collapse;
    }
    .order-summary-table th {
        font-weight: 700;
        color: #475569;
        text-transform: uppercase;
        font-size: 12px;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #f1f3f5;
        padding: 12px 16px;
        background: #f8fafc;
    }
    .order-summary-table td {
        padding: 16px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f3f5;
    }
    .product-item {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .product-item img {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
    }
    .product-details a {
        font-weight: 600;
        color: #1e293b;
        text-decoration: none;
        transition: color 0.2s ease;
    }
    .product-details a:hover {
        color: #fe5200;
    }
    .product-meta {
        font-size: 11px;
        color: #64748b;
        margin-top: 4px;
    }
    .btn-order-confirm {
        background-color: #fe5200;
        color: #ffffff;
        font-weight: 700;
        padding: 16px;
        border-radius: 12px;
        border: none;
        width: 100%;
        font-size: 16px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 14px rgba(254, 82, 0, 0.3);
    }
    .btn-order-confirm:hover {
        background-color: #e04800;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(254, 82, 0, 0.4);
        color: #ffffff;
    }
    .coupon-apply-btn {
        background-color: #1e293b;
        color: #ffffff;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        padding: 12px 20px;
        transition: all 0.2s ease;
    }
    .coupon-apply-btn:hover {
        background-color: #0f172a;
    }
    .remove-item-btn {
        background: none;
        border: none;
        color: #ef4444;
        transition: transform 0.2s ease;
        cursor: pointer;
    }
    .remove-item-btn:hover {
        transform: scale(1.1);
    }
    
    .premium-qty {
        display: inline-flex;
        align-items: center;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        overflow: hidden;
        background: #ffffff;
    }
    .premium-qty button {
        border: none;
        background: none;
        padding: 6px 12px;
        font-size: 16px;
        font-weight: 600;
        color: #64748b;
        cursor: pointer;
        transition: background 0.2s ease;
    }
    .premium-qty button:hover {
        background: #f1f3f5;
    }
    .premium-qty input {
        width: 36px;
        text-align: center;
        border: none;
        border-left: 1px solid #cbd5e1;
        border-right: 1px solid #cbd5e1;
        font-size: 14px;
        font-weight: 600;
        color: #1e293b;
        outline: none;
    }
</style>
@endpush

@section('content')
<section class="chheckout-section">
    @php
        $subtotal = Cart::instance('shopping')->subtotal();
        $subtotal = str_replace(',', '', $subtotal);
        $subtotal = str_replace('.00', '', $subtotal);
        $shipping = Session::get('shipping') ? Session::get('shipping') : 0;
        $discount = Session::get('discount') ? Session::get('discount') : 0;
    @endphp
    <div class="container">
        <div class="row">
            <!-- Left Column: Shipping Form -->
            <div class="col-lg-7 col-md-12 mb-4">
                <div class="card checkout-card">
                    <div class="card-header">
                        <h5>আপনার শিপিং ও ডেলিভারি তথ্য</h5>
                        <p class="text-muted mt-2 mb-0" style="font-size: 12px; line-height: 1.5;">
                            অর্ডারটি কনফার্ম করতে নিচের তথ্যগুলো পূরণ করুন অথবা ফোনে অর্ডার করতে 
                            <a href="tel:88{{$contact->hotline}}" class="text-danger font-weight-bold">{{$contact->hotline}}</a> নাম্বারে ক্লিক করুন।
                        </p>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('customer.ordersave') }}" method="POST" id="checkout-form" data-parsley-validate="">
                            @csrf
                            <div class="row">
                                <div class="col-sm-12 mb-3">
                                    <label for="name" class="form-label-premium">আপনার নাম লিখুন *</label>
                                    <input type="text" id="name" name="name" class="form-control form-control-premium @error('name') is-invalid @enderror" value="{{ old('name') }}" required placeholder="e.g. আবির রহমান" />
                                    @error('name')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                                <div class="col-sm-12 mb-3">
                                    <label for="phone" class="form-label-premium">আপনার মোবাইল নাম্বার লিখুন *</label>
                                    <input type="text" minlength="11" id="phone" name="phone" maxlength="11" pattern="0[0-9]+" title="Please enter an 11-digit number." class="form-control form-control-premium @error('phone') is-invalid @enderror" value="{{ old('phone') }}" required placeholder="e.g. 017xxxxxxxx" />
                                    @error('phone')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                                <div class="col-sm-12 mb-3">
                                    <label for="address" class="form-label-premium">ঠিকানা লিখুন (জেলা, উপজেলা, গ্রাম, রোড নম্বর) *</label>
                                    <input type="text" id="address" name="address" class="form-control form-control-premium @error('address') is-invalid @enderror" value="{{ old('address') }}" required placeholder="e.g. ঢাকা, মিরপুর ১০" />
                                    @error('address')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                                <div class="col-sm-12 mb-4">
                                    <label for="area" class="form-label-premium">ডেলিভারি এরিয়া নির্বাচন করুন *</label>
                                    <select id="area" name="area" class="form-control form-control-premium select2 @error('area') is-invalid @enderror" required>
                                        @foreach ($shippingcharge as $key => $value)
                                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('area')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>

                                <!-- Note field -->
                                <div class="col-sm-12 mb-4">
                                    <label for="note" class="form-label-premium">অর্ডারের জন্য বিশেষ কোনো নির্দেশিকা (ঐচ্ছিক)</label>
                                    <textarea id="note" name="note" class="form-control form-control-premium" rows="2" placeholder="e.g. দ্রুত ডেলিভারি দিলে ভালো হয়..."></textarea>
                                </div>

                                <!-- Payment Gateway Selection -->
                                <div class="col-sm-12 mb-4">
                                    <label class="form-label-premium">পেমেন্ট মেথড নির্বাচন করুন *</label>
                                    <div class="row g-2">
                                        <div class="col-4">
                                            <label class="payment-card-label" for="payment_cod">
                                                <input class="form-check-input d-none" type="radio" name="payment_method" id="payment_cod" value="Cash On Delivery" checked required />
                                                <div class="payment-card text-center">
                                                    <i class="fa-solid fa-hand-holding-dollar fa-2x mb-2 text-secondary"></i>
                                                    <div class="font-weight-semibold font-13">ক্যাশ অন ডেলিভারি</div>
                                                </div>
                                            </label>
                                        </div>
                                        @if($bkash_gateway)
                                        <div class="col-4">
                                            <label class="payment-card-label" for="payment_bkash">
                                                <input class="form-check-input d-none" type="radio" name="payment_method" id="payment_bkash" value="bkash" required />
                                                <div class="payment-card text-center">
                                                    <i class="fa-solid fa-wallet fa-2x mb-2 text-danger"></i>
                                                    <div class="font-weight-semibold font-13">বিকাশ (bKash)</div>
                                                </div>
                                            </label>
                                        </div>
                                        @endif
                                        @if($shurjopay_gateway)
                                        <div class="col-4">
                                            <label class="payment-card-label" for="payment_online">
                                                <input class="form-check-input d-none" type="radio" name="payment_method" id="payment_online" value="shurjopay" required />
                                                <div class="payment-card text-center">
                                                    <i class="fa-solid fa-credit-card fa-2x mb-2 text-success"></i>
                                                    <div class="font-weight-semibold font-13">অনলাইন পেমেন্ট</div>
                                                </div>
                                            </label>
                                        </div>
                                        @endif
                                    </div>
                                </div>


                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Right Column: Order Details & Coupon -->
            <div class="col-lg-5 col-md-12">
                <!-- Order Summary Card -->
                <div class="card checkout-card">
                    <div class="card-header">
                        <h5>অর্ডারের বিবরণ</h5>
                    </div>
                    <div class="card-body p-0 cartlist">
                        <!-- Ajax loaded table contents (including footers) -->
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
                    </div>
                </div>

                <!-- Separate Coupon Card (Fixes nested form bug) -->
                <div class="card checkout-card mt-3">
                    <div class="card-body">
                        <h6 class="mb-3" style="font-weight: 700; color: #1e293b;">কুপন কোড ব্যবহার করুন (Apply Coupon)</h6>
                        <form action="{{ route('apply.coupon') }}" method="POST" id="coupon-apply-form" class="d-flex align-items-center">
                            @csrf
                            <input type="text" name="coupon_code" class="form-control form-control-premium me-2" placeholder="কুপন কোড লিখুন" value="{{ session()->get('coupon_code') }}" required style="height: 44px;" />
                            <button type="submit" class="coupon-apply-btn" style="height: 44px;">প্রয়োগ করুন</button>
                        </form>
                    </div>
                </div>
                
                <!-- Order Now Button -->
                <div class="mt-3 mb-4">
                    <button type="submit" form="checkout-form" class="btn-order-confirm">
                        <i class="fa-solid fa-circle-check me-2"></i> অর্ডারটি কনফার্ম করুন
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('script')
<script src="{{ asset('public/frontEnd/') }}/js/parsley.min.js"></script>
<script src="{{ asset('public/frontEnd/') }}/js/form-validation.init.js"></script>
<script src="{{ asset('public/frontEnd/') }}/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $(".select2").select2();
    });
</script>
<script>
    $("#area").on("change", function() {
        var id = $(this).val();
        $.ajax({
            type: "GET",
            data: {
                id: id
            },
            url: "{{ route('shipping.charge') }}",
            dataType: "html",
            success: function(response) {
                $(".cartlist").html(response);
            },
        });
    });

    $(document).on('submit', '#coupon-apply-form', function(e) {
        e.preventDefault();
        var form = $(this);
        var url = form.attr('action');
        var method = form.attr('method');
        var data = form.serialize();

        $.ajax({
            url: url,
            type: method,
            data: data,
            success: function(response) {
                if (response.success) {
                    toastr.success(response.message);
                    $(".cartlist").html(response.html);
                } else {
                    toastr.error(response.message);
                }
            },
            error: function() {
                toastr.error('Something went wrong. Please try again.');
            }
        });
    });
</script>
<script type = "text/javascript">
    dataLayer.push({ ecommerce: null });  // Clear the previous ecommerce object.
    dataLayer.push({
        event    : "view_cart",
        ecommerce: {
            items: [@foreach (Cart::instance('shopping')->content() as $cartInfo){
                item_name     : "{{$cartInfo->name}}",
                item_id       : "{{$cartInfo->id}}",
                price         : "{{$cartInfo->price}}",
                item_brand    : "{{$cartInfo->options->brand}}",
                item_category : "{{$cartInfo->options->category}}",
                item_size     : "{{$cartInfo->options->size}}",
                item_color     : "{{$cartInfo->options->color}}",
                currency      : "BDT",
                quantity      : {{$cartInfo->qty ?? 0}}
            },@endforeach]
        }
    });
</script>
<script type="text/javascript">
    // Clear the previous ecommerce object.
    dataLayer.push({ ecommerce: null });

    // Push the begin_checkout event to dataLayer.
    dataLayer.push({
        event: "begin_checkout",
        ecommerce: {
            items: [@foreach (Cart::instance('shopping')->content() as $cartInfo)
                {
                    item_name: "{{$cartInfo->name}}",
                    item_id: "{{$cartInfo->id}}",
                    price: "{{$cartInfo->price}}",
                    item_brand: "{{$cartInfo->options->brands}}",
                    item_category: "{{$cartInfo->options->category}}",
                    item_size: "{{$cartInfo->options->size}}",
                    item_color: "{{$cartInfo->options->color}}",
                    currency: "BDT",
                    quantity: {{$cartInfo->qty ?? 0}}
                },
            @endforeach]
        }
    });
</script>

<script>
    $(document).ready(function() {
        // Setup CSRF token for AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') || '{{ csrf_token() }}'
            }
        });

        var timer = null;

        $(document).on('input keyup change blur', '#name, #phone, #address, #area', function(event) {
            if (timer) {
                clearTimeout(timer);
            }

            var delay = (event.type === 'blur') ? 0 : 2000;

            timer = setTimeout(function() {
                saveIncompleteOrder();
            }, delay);
        });

        function saveIncompleteOrder() {
            var name = $('#name').val().trim();
            var phone = $('#phone').val().trim();
            var address = $('#address').val().trim();
            
            var areaSelect = $('#area option:selected');
            var area = "";
            if(areaSelect.val() !== "" && areaSelect.text().indexOf('নিবার্চন') === -1) {
                area = areaSelect.text().trim();
            }

            if (name === "" && phone === "") return;
            if (phone.length > 0 && phone.length < 11) return; 

            $.ajax({
                url: "{{ route('customer.incomplete_order_save') }}",
                type: "POST",
                headers: {
                    'Accept': 'application/json'
                },
                data: {
                    name: name,
                    phone: phone,
                    address: address,
                    area: area
                },
                success: function(response) {
                    console.log("Incomplete order saved:", response);
                },
                error: function(xhr) {
                    console.error("Error saving incomplete order:", xhr.responseJSON);
                }
            });
        }
    });
</script>
@endpush
