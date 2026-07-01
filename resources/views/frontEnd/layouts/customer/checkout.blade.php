@extends('frontEnd.layouts.master') @section('title', 'Customer Checkout') @push('css')
<link rel="stylesheet" href="{{ asset('public/frontEnd/css/select2.min.css') }}" />
@endpush @section('content')
<section class="chheckout-section">
    @php
        $subtotal = Cart::instance('shopping')->subtotal();
        $subtotal = str_replace(',', '', $subtotal);
        $subtotal = str_replace('.00', '', $subtotal);
        $shipping = Session::get('shipping') ? Session::get('shipping') : 0;
    @endphp
    <div class="container">
        <div class="row">
            <div class="col-sm-5 cus-order-2">
                <div class="checkout-shipping">
                    <form action="{{ route('customer.ordersave') }}" method="POST" data-parsley-validate="">
                        @csrf
                        <div class="card">
                           <div class="card-header">
                                <h6>আপনার অর্ডারটি কনফার্ম করতে তথ্যগুলো পূরণ করে <span style="color:#fe5200;">"অর্ডার করুন"</span> বাটন এ ক্লিক করুন অথবা ফোনে অর্ডার করতে এই নাম্বার <a href="tel:88{{$contact->hotline}}" style="color:#fe5200;">{{$contact->hotline}}</a> এর উপরে ক্লিক করুন।   </h6>
                                
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group mb-3">
                                            <label for="name">আপনার নাম লিখুন *</label>
                                            <input type="text" id="name"
                                                class="form-control @error('name') is-invalid @enderror" name="name"
                                                value="{{ old('name') }}"
                                                required/>
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- col-end -->
                                    <div class="col-sm-12">
                                        <div class="form-group mb-3">
                                            <label for="phone">আপনার নাম্বার লিখুন *</label>
                                            <input type="text" minlength="11" id="phone" maxlength="11"
                                                pattern="0[0-9]+"
                                                title="Please enter an 11-digit number."
                                                class="form-control @error('phone') is-invalid @enderror" name="phone"
                                                value="{{ old('phone') }}"
                                                required/>
                                            @error('phone')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- col-end -->
                                    <div class="col-sm-12">
                                        <div class="form-group mb-3">
                                            <label for="address">ঠিকানা লিখুন * জেলা,উপজেলা,থানা,পৌরসভা</label>
                                            <input type="address" id="address"
                                                class="form-control @error('address') is-invalid @enderror"
                                                name="address"
                                                value="{{ old('address') }}"
                                                required/>
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group mb-3">
                                            <label for="area">ডেলিভারি এরিয়া নিবার্চন করুন *</label>
                                            <select type="area" id="area"
                                                class="form-control @error('area') is-invalid @enderror" name="area"
                                                required>
                                                @foreach ($shippingcharge as $key => $value)
                                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- col-end -->

                                    <!-------------------->
                                    <!-- col-end -->
                                    <div class="col-sm-12">

                                        <div class="radio_payment">
                                            <label id="payment_method">পেমেন্ট মেথড</label>
                                            <div class="payment_option">
                                                
                                            </div>
                                        </div>
                                        <div class="payment-methods">
                                            
                                            <div class="form-check p_cash">
                                                <input class="form-check-input" type="radio" name="payment_method"
                                                id="inlineRadio1" value="Cash On Delivery" checked required />
                                                <label class="form-check-label" for="inlineRadio1">
                                                    Cash On Delivery
                                                </label>
                                            </div>
                                            @if($bkash_gateway)
                                            <div class="form-check p_bkash">
                                                <input class="form-check-input" type="radio" name="payment_method"
                                                id="inlineRadio2" value="bkash" required/>
                                                <label class="form-check-label" for="inlineRadio2">
                                                    Bkash
                                                </label>
                                            </div>
                                            @endif
                                            
                                            @if($shurjopay_gateway)
                                            <div class="form-check p_shurjo">
                                                <input class="form-check-input" type="radio" name="payment_method"
                                                id="inlineRadio3" value="shurjopay" required/>
                                                <label class="form-check-label" for="inlineRadio3">
                                                    Shurjopay
                                               </label>
                                            </div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-------------------->
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <button class="order_place" type="submit">অর্ডার করুন</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- card end -->




                    </form>
                </div>
            </div>
            <!-- col end -->
            <div class="col-sm-7 cust-order-1">
                <div class="cart_details table-responsive-sm">
                    <div class="card">
                        <div class="card-header">
                            <h5>অর্ডারের তথ্য</h5>
                        </div>
                        <div class="card-body cartlist">
                            <table class="cart_table table table-bordered table-striped text-center mb-0">
                                <thead>
                                    <tr>
                                        <th style="width: 20%;">ডিলিট</th>
                                        <th style="width: 40%;">প্রোডাক্ট</th>
                                        <th style="width: 20%;">পরিমাণ</th>
                                        <th style="width: 20%;">মূল্য</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach (Cart::instance('shopping')->content() as $value)
                                        <tr>
                                            <td>
                                                <a class="cart_remove" data-id="{{ $value->rowId }}"><i
                                                        class="fas fa-trash text-danger"></i></a>
                                            </td>
                                            <td class="text-left">
                                                <a href="{{ route('product', $value->options->slug) }}"> <img
                                                        src="{{ asset($value->options->image) }}" />
                                                    {{ Str::limit($value->name, 20) }}</a>
                                                @if ($value->options->product_size)
                                                    <p>Size: {{ $value->options->product_size }}</p>
                                                @endif
                                                @if ($value->options->product_color)
                                                    <p>Color: {{ $value->options->product_color }}</p>
                                                @endif
                                            </td>
                                            <td class="cart_qty">
                                                <div class="qty-cart vcart-qty">
                                                    <div class="quantity">
                                                        <button class="minus cart_decrement"
                                                            data-id="{{ $value->rowId }}">-</button>
                                                        <input type="text" value="{{ $value->qty }}" readonly />
                                                        <button class="plus cart_increment"
                                                            data-id="{{ $value->rowId }}">+</button>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><span class="alinur">৳ </span><strong>{{ $value->price }}</strong>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="3" class="text-end px-4">মোট</th>
                                        <td class="px-4">
                                            <span id="net_total"><span class="alinur">৳
                                                </span><strong>{{ $subtotal }}</strong></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th colspan="3" class="text-end px-4">ডেলিভারি চার্জ</th>
                                        <td class="px-4">
                                            <span id="cart_shipping_cost"><span class="alinur">৳
                                                </span><strong>{{ $shipping }}</strong></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th colspan="3" class="text-end px-4">সর্বমোট</th>
                                        <td class="px-4">
                                            <span id="grand_total"><span class="alinur">৳
                                                </span><strong>{{ $subtotal + $shipping }}</strong></span>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- col end -->
        </div>
    </div>
</section>
@endsection @push('script')
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
{{-- <script>
    $(document).ready(function() {
        // Setup CSRF token for AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
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
            var phone = $('#phone').val().trim();0000
            var address = $('#address').val().trim();
            var area = $('#area option:selected').text().trim();

            // Do not save if name and phone are empty, or if phone is less than 11 digits
            if (name === "" && phone === "") return;
            if (phone.length < 11) return;

            $.ajax({
                url: "{{ route('customer.incomplete_order_save') }}",
                type: "POST",
                data: {
                    name: name,
                    phone: phone,
                    address: address,
                    area: area
                },
                success: function(response) {
                    console.log("Incomplete order saved");
                }
            });
        }
    });
</script> --}}

<script>
    $(document).ready(function() {
        // Setup CSRF token for AJAX
        $.ajaxSetup({
            headers: {
                // যদি আপনার লেআউটে মেটা ট্যাগ না থাকে, তবে সরাসরি ব্লেড ফাংশন ব্যবহারের ব্যাকআপ ট্রিক
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
            var phone = $('#phone').val().trim(); // টাইপো '0000' রিমুভ করা হয়েছে
            var address = $('#address').val().trim();
            
            // এরিয়া সিলেক্ট করা থাকলে টেক্সট নিবে, নতুবা খালি রাখবে
            var areaSelect = $('#area option:selected');
            var area = "";
            if(areaSelect.val() !== "" && areaSelect.text().indexOf('নিবার্চন') === -1) {
                area = areaSelect.text().trim();
            }

            // ফোন নাম্বার বা নাম খালি থাকলে অথবা ফোন নাম্বার ১১ ডিজিটের কম হলে ডাটা পাঠাবে না
            if (name === "" && phone === "") return;
            if (phone.length > 0 && phone.length < 11) return; 

            $.ajax({
    url: "{{ route('customer.incomplete_order_save') }}",
    type: "POST",
    headers: {
        'Accept': 'application/json' // Laravel-কে বাধ্য করবে HTML এর বদলে JSON বা এরর রেসপন্স দিতে
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
        // যদি এখনও কোনো ভ্যালিডেশন বা অথেন্টিকেশন এরর থাকে, তা এখানে দেখাবে (HTML দেখাবে না)
        console.error("Error saving incomplete order:", xhr.responseJSON);
    }
});
        }
    });
</script>
@endpush
