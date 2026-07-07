@extends('backEnd.layouts.master')
@section('title',"COUPONS")
@section('content')
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Coupons</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Coupons</h4>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-sm-4">
                                <h4 class="page-title">Coupons</h4>
                            </div>
                            <div class="col-sm-8">
                                <div class="text-sm-right">
                                    <a href="{{ route('coupons.create') }}"
                                        class="btn btn-danger btn-rounded waves-effect waves-light mb-2"><i
                                            class="mdi mdi-plus-circle mr-1"></i> Add Coupon</a>
                                </div>
                            </div><!-- end col-->
                        </div>
                        <div class="table-responsive">
                            <table class="table table-centered table-striped dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Coupon</th>
                                        <th>Code</th>
                                        <th>Discount</th>
                                        <th>Minimum</th>
                                        <th>Status</th>
                                        <th>Expired Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($coupons as $key => $coupon)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $coupon->title }}</td>
                                            <td>
                                                <span class="badge badge-secondary">{{ $coupon->code }}</span>
                                            </td>
                                            <td>
                                                <span
                                                    class="badge badge-success">{{ $coupon->discount_type == 1 ? '%' : '৳' }}{{ $coupon->discount }}</span>
                                            </td>
                                            <td>
                                                <span class="badge badge-primary">{{ $coupon->minimum_order }}</span>
                                            </td>
                                            <td>
                                                @if ($coupon->status == 0)
                                                    <span class="badge badge-success">Active</span>
                                                @else
                                                    <span class="badge badge-warning">Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($coupon->expire_date != null)
                                                    <span
                                                        class="badge badge-danger">{{ date('d M Y', strtotime($coupon->expire_date)) }}</span>
                                                @endif
                                            </td>
                                            <td class="table-action">
                                                <a href="{{ route('coupons.edit', $coupon->id) }}"
                                                    class="action-icon"><i class="mdi mdi-pencil"></i></a>
                                                <a href="{{ route('coupons.destroy', $coupon->id) }}"
                                                    class="action-icon delete"><i class="mdi mdi-delete"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col-->
        </div>
        <!-- end row -->

    </div>
    <!-- end container -->
@endsection