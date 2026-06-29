@extends('backEnd.layouts.master')
@section('title','Dashboard')
@section('css')
<!-- Plugins css -->
<link href="{{asset('public/backEnd/')}}/assets/libs/flatpickr/flatpickr.min.css" rel="stylesheet" type="text/css" />
<link href="{{asset('public/backEnd/')}}/assets/libs/selectize/css/selectize.bootstrap3.css" rel="stylesheet" type="text/css" />

<style>
    /* Premium Dashboard Styles */
    :root {
        --dash-primary: #4a81d4;
        --dash-success: #1abc9c;
        --dash-info: #35b8e0;
        --dash-warning: #f1556c;
        --dash-purple: #727cf5;
        --card-bg-light: rgba(255, 255, 255, 0.95);
        --card-border-color: rgba(222, 226, 230, 0.7);
        --glow-shadow: 0 8px 30px rgba(0, 0, 0, 0.04);
        --transition-base: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    }

    body[data-theme="dark"] {
        --card-bg-light: rgba(43, 53, 64, 0.95);
        --card-border-color: rgba(65, 78, 93, 0.7);
        --glow-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
    }

    /* Grid Stats Cards */
    .stat-card {
        background: var(--card-bg-light);
        border: 1px solid var(--card-border-color);
        border-radius: 16px;
        box-shadow: var(--glow-shadow);
        transition: var(--transition-base);
        overflow: hidden;
        position: relative;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        transition: var(--transition-base);
    }

    .stat-card.card-primary::before { background: linear-gradient(90deg, #4a81d4, #64b5f6); }
    .stat-card.card-success::before { background: linear-gradient(90deg, #1abc9c, #4db6ac); }
    .stat-card.card-info::before { background: linear-gradient(90deg, #35b8e0, #4fc3f7); }
    .stat-card.card-purple::before { background: linear-gradient(90deg, #727cf5, #9575cd); }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
    }

    .stat-icon-wrapper {
        width: 56px;
        height: 56px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        font-size: 24px;
        transition: var(--transition-base);
    }

    .stat-card:hover .stat-icon-wrapper {
        transform: scale(1.1) rotate(5deg);
    }

    /* Custom Tables */
    .table-modern {
        vertical-align: middle;
    }

    .table-modern thead th {
        background-color: rgba(243, 247, 249, 0.8) !important;
        border-bottom: 2px solid var(--card-border-color) !important;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 11px;
        letter-spacing: 0.5px;
        color: #6c757d;
        padding: 12px 16px;
    }

    .table-modern tbody td {
        padding: 14px 16px;
        border-bottom: 1px solid var(--card-border-color);
    }

    /* Status Badges */
    .badge-modern {
        padding: 6px 12px;
        border-radius: 30px;
        font-weight: 600;
        font-size: 11px;
        letter-spacing: 0.3px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    
    .badge-modern::before {
        content: '';
        display: inline-block;
        width: 6px;
        height: 6px;
        border-radius: 50%;
    }

    .badge-status-pending { background-color: rgba(241, 180, 76, 0.15); color: #f1b44c; }
    .badge-status-pending::before { background-color: #f1b44c; }

    .badge-status-accepted { background-color: rgba(53, 184, 224, 0.15); color: #35b8e0; }
    .badge-status-accepted::before { background-color: #35b8e0; }

    .badge-status-completed, .badge-status-delivered, .badge-status-active { background-color: rgba(26, 188, 156, 0.15); color: #1abc9c; }
    .badge-status-completed::before, .badge-status-delivered::before, .badge-status-active::before { background-color: #1abc9c; }

    .badge-status-cancelled, .badge-status-inactive { background-color: rgba(241, 85, 108, 0.15); color: #f1556c; }
    .badge-status-cancelled::before, .badge-status-inactive::before { background-color: #f1556c; }

    /* Section Cards */
    .dashboard-section-card {
        background: var(--card-bg-light);
        border: 1px solid var(--card-border-color);
        border-radius: 18px;
        box-shadow: var(--glow-shadow);
        margin-bottom: 24px;
        overflow: hidden;
    }

    .dashboard-section-card .card-body {
        padding: 24px;
    }

    .section-header-title {
        font-size: 16px;
        font-weight: 700;
        color: #343a40;
        letter-spacing: -0.2px;
    }

    body[data-theme="dark"] .section-header-title {
        color: #e3ebf6;
    }

    /* Delivery Analytics Panel styling */
    .delivery-panel {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .delivery-metric-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 16px;
        background: rgba(0, 0, 0, 0.02);
        border-radius: 12px;
        border: 1px dashed var(--card-border-color);
        transition: var(--transition-base);
    }

    .delivery-metric-row:hover {
        background: rgba(0, 0, 0, 0.04);
        border-style: solid;
    }

    .delivery-metric-label {
        font-size: 13px;
        font-weight: 500;
        color: #6c757d;
    }

    .delivery-metric-value {
        font-size: 16px;
        font-weight: 700;
        color: #343a40;
    }

    body[data-theme="dark"] .delivery-metric-value {
        color: #e3ebf6;
    }
</style>
@endsection
@section('content')
<!-- Start Content-->
<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                
                </div>
                <h4 class="page-title">Dashboard Overview</h4>
            </div>
        </div>
    </div>     
    <!-- end page title --> 

    <div class="row mb-3">
        <!-- Total Orders -->
        <div class="col-md-6 col-xl-3 mb-3">
            <div class="card stat-card card-primary h-100 mb-0">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="stat-icon-wrapper bg-soft-primary text-primary">
                            <i class="fe-shopping-cart"></i>
                        </div>
                        <div class="text-end">
                            <h2 class="text-dark fw-bold mt-0 mb-1"><span data-plugin="counterup">{{$total_order}}</span></h2>
                            <p class="text-muted mb-0 text-truncate font-13 fw-semibold">Total Orders</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Today's Orders -->
        <div class="col-md-6 col-xl-3 mb-3">
            <div class="card stat-card card-success h-100 mb-0">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="stat-icon-wrapper bg-soft-success text-success">
                            <i class="fe-shopping-bag"></i>
                        </div>
                        <div class="text-end">
                            <h2 class="text-dark fw-bold mt-0 mb-1"><span data-plugin="counterup">{{$today_order}}</span></h2>
                            <p class="text-muted mb-0 text-truncate font-13 fw-semibold">Today's Orders</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products -->
        <div class="col-md-6 col-xl-3 mb-3">
            <div class="card stat-card card-info h-100 mb-0">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="stat-icon-wrapper bg-soft-info text-info">
                            <i class="fe-database"></i>
                        </div>
                        <div class="text-end">
                            <h2 class="text-dark fw-bold mt-0 mb-1"><span data-plugin="counterup">{{$total_product}}</span></h2>
                            <p class="text-muted mb-0 text-truncate font-13 fw-semibold">Products</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customers -->
        <div class="col-md-6 col-xl-3 mb-3">
            <div class="card stat-card card-purple h-100 mb-0">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="stat-icon-wrapper bg-soft-purple text-purple">
                            <i class="fe-users"></i>
                        </div>
                        <div class="text-end">
                            <h2 class="text-dark fw-bold mt-0 mb-1"><span data-plugin="counterup">{{$total_customer}}</span></h2>
                            <p class="text-muted mb-0 text-truncate font-13 fw-semibold">Customers</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end row-->

    <!-- Charts & Analytics Row -->
    <div class="row">
        <!-- Sales Analytics Chart -->
        <div class="col-xl-8">
            <div class="card dashboard-section-card">
                <div class="card-body">
                    <h4 class="header-title section-header-title mb-3">Sales Analytics (Last 30 Days)</h4>
                    <div id="sales-analytics" class="apex-charts" data-colors="#1abc9c,#4a81d4" style="min-height: 380px;"></div>
                </div>
            </div>
        </div>

        <!-- Delivery & Performance Analytics -->
        <div class="col-xl-4">
            <div class="card dashboard-section-card">
                <div class="card-body">
                    <h4 class="header-title section-header-title mb-3">Delivery Analytics</h4>
                    <div id="total-revenue" class="apex-charts mb-3" data-colors="#f1556c" style="min-height: 242px;"></div>
                    
                    <div class="delivery-panel">
                        <div class="delivery-metric-row">
                            <span class="delivery-metric-label">Today's Deliveries</span>
                            <span class="delivery-metric-value text-success font-15 fw-bold">{{$today_delivery}}</span>
                        </div>
                        <div class="delivery-metric-row">
                            <span class="delivery-metric-label">This Week's Deliveries</span>
                            <span class="delivery-metric-value text-primary font-15 fw-bold">{{$last_week}}</span>
                        </div>
                        <div class="delivery-metric-row">
                            <span class="delivery-metric-label">Last Month's Deliveries</span>
                            <span class="delivery-metric-value text-purple font-15 fw-bold">{{$last_month}}</span>
                        </div>
                        <div class="delivery-metric-row bg-soft-info border-info">
                            <span class="delivery-metric-label text-info">Total Deliveries</span>
                            <span class="delivery-metric-value text-info font-16 fw-bold">{{$total_delivery}}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->

    <div class="row">
        <!-- Latest Orders Table -->
        <div class="col-xl-6">
            <div class="card dashboard-section-card">
                <div class="card-body">
                    <h4 class="header-title section-header-title mb-3">Latest 5 Orders</h4>

                    <div class="table-responsive">
                        <table class="table table-modern table-borderless table-hover table-nowrap table-centered m-0">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Image</th>
                                    <th>Invoice</th>
                                    <th>Amount</th>
                                    <th>Customer</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($latest_order as $order)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td style="width: 36px;">
                                        <img src="{{asset($order->product && $order->product->image ? $order->product->image->image : 'public/uploads/default.png')}}" alt="product-img" class="rounded-circle avatar-sm border" />
                                    </td>
                                    <td><strong>#{{$order->invoice_id}}</strong></td>
                                    <td>৳ {{$order->amount}}</td>
                                    <td>{{$order->customer ? $order->customer->name : 'Guest'}}</td>
                                    <td>
                                        <span class="badge-modern badge-status-{{ strtolower($order->order_status) }}">{{ $order->order_status }}</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->

        <!-- Latest Customers Table -->
        <div class="col-xl-6">
            <div class="card dashboard-section-card">
                <div class="card-body">
                    <h4 class="header-title section-header-title mb-3">Latest Customers</h4>

                    <div class="table-responsive">
                        <table class="table table-modern table-borderless table-nowrap table-hover table-centered m-0">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Joined Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($latest_customer as $customer)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td><strong>{{$customer->name}}</strong></td>
                                    <td>{{$customer->phone}}</td>
                                    <td>{{$customer->created_at->format('d-m-Y')}}</td>
                                    <td>
                                        <span class="badge-modern badge-status-{{ strtolower($customer->status) }}">{{ $customer->status }}</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div> <!-- end .table-responsive-->
                </div>
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>
    <!-- end row -->
    
</div> <!-- container -->
@endsection
@section('script')
 <!-- Plugins js-->
        <script src="{{asset('public/backEnd/')}}/assets/libs/flatpickr/flatpickr.min.js"></script>
        <script src="{{asset('public/backEnd/')}}/assets/libs/apexcharts/apexcharts.min.js"></script>
        <script src="{{asset('public/backEnd/')}}/assets/libs/selectize/js/standalone/selectize.min.js"></script>

    <script>
@php
    $delivery_rate = $total_order > 0 ? round(($total_delivery / $total_order) * 100) : 0;
@endphp
    var colors = ["#f1556c"],
    dataColors = $("#total-revenue").data("colors");
    dataColors && (colors = dataColors.split(","));
    var options = {
          chart: {
             height: 242,
             type: "radialBar"
          },
          series: [{{ $delivery_rate }}],
          plotOptions: {
             radialBar: {
                hollow: {
                   size: "65%"
                }
             }
          },
          colors: colors,
          labels: ["Delivery Rate"]
       },
        chart = new ApexCharts(document.querySelector("#total-revenue"), options);
        chart.render();
        
        colors = ["#1abc9c", "#4a81d4"];
        (dataColors = $("#sales-analytics").data("colors")) && (colors = dataColors.split(","));
        options = {
           series: [{
              name: "Revenue",
              type: "column",
              data: [@foreach($monthly_sale as $sale) {{$sale->amount}}, @endforeach]
           }, {
              name: "Sales",
              type: "line",
              data: [@foreach($monthly_sale as $sale) {{$sale->amount}}, @endforeach]
           }],
           chart: {
              height: 378,
              type: "line",
              toolbar: {
                  show: false
              }
           },
           stroke: {
              width: [2, 3],
              curve: 'smooth'
           },
           plotOptions: {
              bar: {
                 columnWidth: "40%",
                 borderRadius: 4
              }
           },
           colors: colors,
           dataLabels: {
              enabled: !0,
              enabledOnSeries: [1]
           },
           labels: [@foreach($monthly_sale as $sale) '{{ date("d-m-Y", strtotime($sale->date)) }}', @endforeach],
           legend: {
              offsetY: 7
           },
           grid: {
              padding: {
                 bottom: 20
              }
           },
           fill: {
              type: "gradient",
              gradient: {
                 shade: "light",
                 type: "horizontal",
                 shadeIntensity: .25,
                 gradientToColors: void 0,
                 inverseColors: !0,
                 opacityFrom: .85,
                 opacityTo: .85,
                 stops: [0, 100]
              }
           },
           yaxis: [{
              title: {
                 text: "Net Revenue"
              }
           }]
        };
        (chart = new ApexCharts(document.querySelector("#sales-analytics"), options)).render(), $("#dash-daterange").flatpickr({
           altInput: !0,
           mode: "range",
        });
    </script>
@endsection