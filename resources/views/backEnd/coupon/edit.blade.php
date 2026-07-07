@extends('backEnd.layouts.master')
@section('title', 'Coupon Edit')
@section('css')
<link href="{{asset('public/backEnd')}}/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<link href="{{asset('public/backEnd')}}/assets/css/switchery.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<div class="container-fluid">
    
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <a href="{{route('admin.coupons.index')}}" class="btn btn-primary rounded-pill">Manage</a>
                </div>
                <h4 class="page-title">Coupon Edit</h4>
            </div>
        </div>
    </div>       
    <!-- end page title --> 
   <div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <form action="{{route('admin.coupons.update')}}" method="POST" class="row" data-parsley-validate="">
                    @csrf
                    <input type="hidden" value="{{$edit_data->id}}" name="hidden_id">
                    
                    <div class="col-sm-12">
                        <div class="form-group mb-3">
                            <label for="coupon_code" class="form-label">Coupon Code *</label>
                            <input type="text" class="form-control @error('coupon_code') is-invalid @enderror" name="coupon_code" value="{{ $edit_data->coupon_code }}" id="coupon_code" required="" placeholder="e.g. SAVE20">
                            @error('coupon_code')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-sm-6">
                        <div class="form-group mb-3">
                            <label for="discount_type" class="form-label">Discount Type *</label>
                            <select class="form-control @error('discount_type') is-invalid @enderror" name="discount_type" id="discount_type" required="">
                                <option value="">Select...</option>
                                <option value="fixed" {{ $edit_data->discount_type == 'fixed' ? 'selected' : '' }}>Fixed Amount (৳)</option>
                                <option value="percentage" {{ $edit_data->discount_type == 'percentage' ? 'selected' : '' }}>Percentage (%)</option>
                            </select>
                            @error('discount_type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group mb-3">
                            <label for="amount" class="form-label">Discount Value *</label>
                            <input type="number" step="any" class="form-control @error('amount') is-invalid @enderror" name="amount" value="{{ $edit_data->amount }}" id="amount" required="" placeholder="e.g. 50 or 10">
                            @error('amount')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group mb-3">
                            <label for="buy_amount" class="form-label">Minimum Purchase Amount (Optional)</label>
                            <input type="number" step="any" class="form-control @error('buy_amount') is-invalid @enderror" name="buy_amount" value="{{ $edit_data->buy_amount }}" id="buy_amount" placeholder="e.g. 500">
                            @error('buy_amount')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group mb-3">
                            <label for="quantity" class="form-label">Quantity (Optional)</label>
                            <input type="number" class="form-control @error('quantity') is-invalid @enderror" name="quantity" value="{{ $edit_data->quantity }}" id="quantity" placeholder="e.g. 100">
                            @error('quantity')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group mb-3">
                            <label for="start_date" class="form-label">Start Date (Optional)</label>
                            <input type="date" class="form-control @error('start_date') is-invalid @enderror" name="start_date" value="{{ $edit_data->start_date }}" id="start_date">
                            @error('start_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group mb-3">
                            <label for="expiry_date" class="form-label">Expiry Date *</label>
                            <input type="date" class="form-control @error('expiry_date') is-invalid @enderror" name="expiry_date" value="{{ $edit_data->expiry_date }}" id="expiry_date" required="">
                            @error('expiry_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-6 mb-3">
                        <div class="form-group">
                            <label for="status" class="d-block">Status</label>
                            <label class="switch">
                              <input type="checkbox" value="1" name="status" @if($edit_data->status==1) checked @endif>
                              <span class="slider round"></span>
                            </label>
                            @error('status')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <input type="submit" class="btn btn-success" value="Submit">
                    </div>

                </form>

            </div> <!-- end card-body-->
        </div> <!-- end card-->
    </div> <!-- end col-->
   </div>
</div>
@endsection

@section('script')
<script src="{{asset('public/backEnd/')}}/assets/libs/parsleyjs/parsley.min.js"></script>
<script src="{{asset('public/backEnd/')}}/assets/js/pages/form-validation.init.js"></script>
<script src="{{asset('public/backEnd/')}}/assets/libs/select2/js/select2.min.js"></script>
<script src="{{asset('public/backEnd/')}}/assets/js/pages/form-advanced.init.js"></script>
<script src="{{asset('public/backEnd/')}}/assets/js/switchery.min.js"></script>
@endsection
