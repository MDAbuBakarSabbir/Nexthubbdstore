@extends('backEnd.layouts.master')
@section('title',$order_status->name.' Order')

@section('css')
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
  /* Base Styles & Typography */
  .orders-dashboard {
    font-family: 'Outfit', sans-serif;
    color: #1e293b;
    padding-bottom: 3rem;
  }

  /* Page Hero Header */
  .orders-hero {
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
    border-radius: 20px;
    padding: 2.2rem 2.5rem;
    margin-bottom: 2rem;
    box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1.5rem;
    position: relative;
    overflow: hidden;
  }

  .orders-hero::after {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 280px;
    height: 280px;
    background: radial-gradient(circle, rgba(245, 158, 11, 0.15) 0%, rgba(245, 158, 11, 0) 70%);
    border-radius: 50%;
  }

  .orders-hero-title {
    display: flex;
    align-items: center;
    gap: 14px;
    z-index: 2;
  }

  .orders-hero-title h1 {
    color: #ffffff;
    font-size: 1.85rem;
    font-weight: 700;
    margin: 0;
  }

  .orders-count-badge {
    background: rgba(245, 158, 11, 0.25);
    border: 1px solid rgba(245, 158, 11, 0.4);
    color: #fcd34d;
    font-size: 0.85rem;
    font-weight: 700;
    padding: 0.35rem 0.9rem;
    border-radius: 20px;
  }

  .btn-hero-add {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: #ffffff !important;
    font-weight: 600;
    font-size: 0.9rem;
    padding: 0.75rem 1.6rem;
    border-radius: 30px;
    box-shadow: 0 4px 14px rgba(239, 68, 68, 0.35);
    border: none;
    transition: all 0.25s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
    z-index: 2;
  }

  .btn-hero-add:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(239, 68, 68, 0.45);
  }

  /* Control Toolbar Card */
  .toolbar-card {
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02), 0 1px 3px rgba(0, 0, 0, 0.01);
    padding: 1.25rem 1.5rem;
    margin-bottom: 1.5rem;
    border: 1px solid #f1f5f9;
  }

  .toolbar-list {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    list-style: none;
    padding: 0;
    margin: 0;
    align-items: center;
  }

  .btn-toolbar-item {
    font-size: 0.84rem;
    font-weight: 600;
    padding: 0.55rem 1.15rem;
    border-radius: 10px;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all 0.2s ease;
    border: none;
    text-decoration: none;
  }

  .btn-toolbar-primary { background: #e0e7ff; color: #3730a3; }
  .btn-toolbar-primary:hover { background: #c7d2fe; color: #312e81; transform: translateY(-1px); }

  .btn-toolbar-danger { background: #fee2e2; color: #991b1b; }
  .btn-toolbar-danger:hover { background: #fecaca; color: #7f1d1d; transform: translateY(-1px); }

  /* Search Input */
  .search-form-wrap {
    display: flex;
    gap: 8px;
  }

  .search-input-custom {
    border: 1.5px solid #e2e8f0;
    border-radius: 10px;
    padding: 0.55rem 1rem;
    font-size: 0.88rem;
    color: #0f172a;
    background: #f8fafc;
    transition: all 0.2s ease;
    flex-grow: 1;
  }

  .search-input-custom:focus {
    border-color: #6366f1;
    background: #ffffff;
    outline: none;
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
  }

  .btn-search-custom {
    background: #0f172a;
    color: #ffffff;
    font-weight: 600;
    font-size: 0.88rem;
    padding: 0.55rem 1.25rem;
    border-radius: 10px;
    border: none;
    transition: background 0.2s ease;
  }

  .btn-search-custom:hover { background: #334155; }

  /* Table Card */
  .table-card {
    background: #ffffff;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03), 0 1px 3px rgba(0, 0, 0, 0.01);
    overflow: hidden;
    border: 1px solid #f1f5f9;
  }

  .table-custom {
    margin-bottom: 0;
  }

  .table-custom thead th {
    background: #f8fafc;
    color: #475569;
    font-size: 0.78rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.6px;
    padding: 1.1rem 1rem;
    border-bottom: 1px solid #e2e8f0;
  }

  .table-custom tbody td {
    padding: 1.1rem 1rem;
    vertical-align: middle;
    font-size: 0.88rem;
    color: #334155;
    border-bottom: 1px solid #f1f5f9;
  }

  .table-custom tbody tr:hover {
    background-color: #f8fafc;
  }

  /* Invoice ID Badge */
  .invoice-tag {
    font-weight: 700;
    color: #d97706;
    background: #fef3c7;
    padding: 4px 10px;
    border-radius: 8px;
    font-size: 0.82rem;
    display: inline-block;
  }

  /* Action Buttons */
  .action-btn-delete {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #ef4444;
    background: #fee2e2;
    transition: all 0.15s ease;
    border: none;
  }

  .action-btn-delete:hover { background: #fecaca; color: #b91c1c; transform: scale(1.05); }

  /* Cart Items List */
  .cart-items-pill-list {
    display: flex;
    flex-direction: column;
    gap: 6px;
  }

  .cart-item-pill {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    padding: 6px 10px;
    border-radius: 8px;
    font-size: 0.82rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  /* Fraud Check Badge */
  .fraud-check-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 0.75rem;
    font-weight: 700;
    padding: 5px 12px;
    border-radius: 20px;
    border: 1px solid #cbd5e1;
    background: #ffffff;
    color: #475569;
    cursor: pointer;
    transition: all 0.2s ease;
  }

  .fraud-check-badge:hover {
    background: #4f46e5;
    color: #ffffff;
    border-color: #4f46e5;
    box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25);
  }

  .fraud-result-pill {
    padding: 8px 12px;
    border-radius: 10px;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-left: 4px solid #64748b;
    cursor: pointer;
    transition: all 0.2s ease;
  }

  .fraud-result-pill:hover {
    background: #ffffff;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
  }

  /* Status Badge */
  .status-badge-warning {
    font-weight: 600;
    font-size: 0.78rem;
    padding: 5px 12px;
    border-radius: 20px;
    background: #fffbeb;
    color: #b45309;
    border: 1px solid #fde68a;
    display: inline-block;
  }

  /* Custom Pagination Box */
  .pagination-container {
    padding: 1.5rem;
    display: flex;
    justify-content: flex-end;
  }

  /* Modals Custom Styling */
  .modal-content-custom {
    border: none;
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    overflow: hidden;
  }

  .modal-header-custom {
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
    padding: 1.25rem 1.75rem;
  }

  .modal-title-custom {
    font-weight: 700;
    font-size: 1.15rem;
    color: #0f172a;
    margin: 0;
  }

  .modal-body-custom {
    padding: 1.75rem;
  }
</style>
@endsection

@section('content')
<div class="container-fluid orders-dashboard">

    <!-- Page Hero -->
    <div class="orders-hero mt-4">
        <div class="orders-hero-title">
            <h1>{{$order_status->name}} Orders</h1>
            <span class="orders-count-badge">{{$order_status->orders_count}} Total</span>
        </div>
        <div>
            <a href="{{route('admin.order.create')}}" class="btn-hero-add">
                <i class="fa-solid fa-cart-plus"></i> Add New Order
            </a>
        </div>
    </div>

    <!-- Control Toolbar Card -->
    <div class="toolbar-card">
        <div class="row align-items-center gy-3">
            <div class="col-lg-8">
                <ul class="toolbar-list">
                    <li>
                        <a class="btn-toolbar-item btn-toolbar-primary btn-change-status-trigger" href="javascript:void(0);">
                            <i class="fa-solid fa-list-check"></i> Change Status
                        </a>
                    </li>
                    <li>
                        <a href="{{route('admin.incomplete_orders.bulk_destroy')}}" class="btn-toolbar-item btn-toolbar-danger order_delete">
                            <i class="fa-regular fa-trash-can"></i> Delete All
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col-lg-4">
                <form class="custom_form" method="GET">
                    <div class="search-form-wrap">
                        <input type="text" name="keyword" class="search-input-custom" placeholder="Search by name, phone or ID..." value="{{ request('keyword') }}">
                        <button type="submit" class="btn-search-custom">Search</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Orders Table Card -->
    <div class="table-card">
        <div class="table-responsive">
            <table class="table table-custom w-100">
                <thead>
                    <tr>
                        <th style="width:3%; text-align:center;">
                            <input type="checkbox" class="form-check-input checkall">
                        </th>
                        <th style="width:3%;">SL</th>
                        <th style="width:7%;">Action</th>
                        <th style="width:8%;">ID</th>
                        <th style="width:12%;">Date & Time</th>
                        <th style="width:18%;">Customer Info</th>
                        <th style="width:16%;">Phone & Fraud Verification</th>
                        <th style="width:23%;">Products Selected</th>
                        <th style="width:10%;">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($show_data as $key=>$value)
                    <tr>
                        <td style="text-align:center;">
                            <input type="checkbox" class="form-check-input checkbox" value="{{$value->id}}">
                        </td>
                        <td><span class="text-muted font-weight-bold">{{$loop->iteration}}</span></td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <form method="post" action="{{route('admin.incomplete_orders.destroy')}}" class="d-inline">
                                @csrf
                                <input type="hidden" value="{{$value->id}}" name="id">
                                <button type="submit" title="Delete Order" class="action-btn-delete delete-confirm">
                                    <i class="fa-regular fa-trash-can"></i>
                                </button>
                            </form>
                            <a href="{{route('admin.order.create', ['incom_id' => $value->id])}}" title="Convert to Order" class="action-btn-delete" style="color: #059669; background: #d1fae5;">
                                <i class="fa-solid fa-cart-plus"></i>
                            </a>
                            </div>
                        </td>
                        <td>
                            <span class="invoice-tag">#{{$value->id}}</span>
                        </td>
                        <td>
                            <div style="font-weight:600; color:#1e293b;">{{date('d M, Y', strtotime($value->updated_at))}}</div>
                            <small class="text-muted">{{date('h:i:s A', strtotime($value->updated_at))}}</small>
                        </td>
                        <td>
                            <div style="font-weight:700; color:#0f172a; margin-bottom:2px;">{{$value->name ? $value->name : 'No Name'}}</div>
                            <small class="text-muted" style="line-height:1.4; display:block;">{{$value->address ? $value->address : 'Address not entered'}}</small>
                        </td>
                        <td>
                            <div style="font-weight:700; color:#1e293b; font-size:0.95rem;">{{$value->phone ? $value->phone : 'N/A'}}</div>
                            @if($value->phone)
                            <button type="button" class="fraud-check-badge fraud-check-btn mt-2"
                                    data-phone="{{ $value->phone }}" data-id="{{ $value->id }}">
                                <i class="fa-solid fa-shield-halved"></i>
                                <span class="btn-text">Fraud Check</span>
                                <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                            </button>
                            <div class="fraud-result-container mt-1"></div>
                            @endif
                        </td>
                        <td>
                            @php
                                $cart_items = json_decode($value->cart_details);
                            @endphp
                            @if($cart_items && (is_array($cart_items) || is_object($cart_items)))
                                <div class="cart-items-pill-list">
                                @foreach($cart_items as $item)
                                    <div class="cart-item-pill">
                                        <span style="font-weight:600; color:#334155;">{{ $item->name ?? 'Product' }} <span class="badge bg-secondary ms-1">{{ $item->qty ?? 1 }}x</span></span>
                                        <span style="font-weight:700; color:#0f172a;">৳{{ $item->price ?? 0 }}</span>
                                    </div>
                                @endforeach
                                </div>
                            @else
                                <em class="text-muted small">No cart details recorded</em>
                            @endif
                        </td>
                        <td>
                            <div style="font-weight:800; color:#0f172a; font-size:0.95rem;">৳{{number_format($value->amount)}}</div>
                            <span class="status-badge-warning mt-1">{{$value->status}}</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="pagination-container">
            {{$show_data->links('pagination::bootstrap-4')}}
        </div>
    </div>
</div>

<!-- Change Status Modal -->
<div class="modal fade" id="changeStatus" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content modal-content-custom">
      <div class="modal-header modal-header-custom">
        <h5 class="modal-title-custom"><i class="fa-solid fa-list-check me-2 text-primary"></i>Change Incomplete Order Status</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" data-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{route('admin.incomplete_orders.status')}}" id="order_status_form">
      <div class="modal-body modal-body-custom">
        <div class="form-group">
            <label class="form-label font-weight-bold mb-2">Select Target Status</label>
            <select name="order_status" id="order_status" class="form-select">
                <option value="">Select Status...</option>
                @foreach($orderstatus as $key=>$value)
                <option value="{{$value->id}}">{{$value->name}}</option>
                @endforeach
            </select>
        </div>
      </div>
      <div class="modal-footer bg-light px-4 py-3">
        <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary rounded-pill px-4">Update Status</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- Courier Details Breakdown Modal (Fraud Check Details) -->
<div class="modal fade" id="courierDetailModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content modal-content-custom">
      <div class="modal-header modal-header-custom">
        <h5 class="modal-title-custom"><i class="fa-solid fa-shield-halved me-2 text-primary"></i>Courier Delivery History Breakdown</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" data-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body modal-body-custom" id="courier_detail_content">
        <div class="text-center py-4"><span class="spinner-border text-primary"></span></div>
      </div>
      <div class="modal-footer bg-light px-4 py-3">
        <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal" data-dismiss="modal">Close Details</button>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
let lastCourierData = {};

$(document).ready(function(){
    $(".checkall").on('change',function(){
      $(".checkbox").prop('checked',$(this).is(":checked"));
    });

    // Open Change Status modal only if at least one order is selected
    $(document).on('click', '.btn-change-status-trigger', function(e) {
        e.preventDefault();
        var checkedCount = $('input.checkbox:checked').length;
        if (checkedCount === 0) {
            toastr.error('Please select at least one order using the checkboxes first!');
            return;
        }
        $('#changeStatus').modal('show');
    });

    // order status change
    $(document).on('submit', 'form#order_status_form', function(e){
        e.preventDefault();
        var url = $(this).attr('action');
        let order_status = $(document).find('select#order_status').val();

        var order = $('input.checkbox:checked').map(function(){
          return $(this).val();
        });
        var order_ids = order.get();

        if(order_ids.length == 0){
            toastr.error('Please Select An Order First!');
            return;
        }

        $.ajax({
           type:'POST',
           url:url,
           data:{
               _token: "{{ csrf_token() }}",
               order_status: order_status,
               order_ids: order_ids
           },
           success:function(res){
               if(res.status=='success'){
                toastr.success(res.message);
                window.location.reload();
            }else{
                toastr.error('Failed or something went wrong');
            }
           }
        });
    });

    // order delete
    $(document).on('click', '.order_delete', function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        var order = $('input.checkbox:checked').map(function(){
          return $(this).val();
        });
        var order_ids = order.get();

        if(order_ids.length == 0){
            toastr.error('Please Select An Order First!');
            return;
        }

        if(!confirm('Are you sure you want to delete selected incomplete orders?')) return;

        $.ajax({
           type:'GET',
           url:url,
           data:{order_ids},
           success:function(res){
               if(res.status=='success'){
                toastr.success(res.message);
                window.location.reload();
            }else{
                toastr.error('Failed or something went wrong');
            }
           }
        });
    });
});

// Real-time Fraud Check Button Handler
$(document).on('click', '.fraud-check-btn', function(e) {
    e.preventDefault();
    let btn = $(this);
    let phone = btn.data('phone');
    let incomId = btn.data('id');
    let resultContainer = btn.siblings('.fraud-result-container');
    let btnText = btn.find('.btn-text');
    let spinner = btn.find('.spinner-border');

    btn.prop('disabled', true);
    btnText.text('Checking...');
    spinner.removeClass('d-none');

    $.ajax({
        url: "{{ route('fraud.check') }}",
        method: "POST",
        data: {
            phone: phone,
            _token: "{{ csrf_token() }}"
        },
        success: function(response) {
            if (response.status === "success" && response.courierData) {
                lastCourierData[incomId] = response.courierData;
                let summary = response.courierData.summary;

                let html = `
                <div class="fraud-result-pill open-detail mt-1" data-id="${incomId}" style="border-left-color: ${summary.success_ratio > 70 ? '#10b981' : (summary.success_ratio > 40 ? '#f59e0b' : '#ef4444')};">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span style="font-weight: 700; color: #1e293b;">Success: ${summary.success_ratio}%</span>
                        <span class="text-primary" style="font-size: 0.75rem; font-weight: 700;">Details <i class="fa-solid fa-angle-right ms-1"></i></span>
                    </div>
                    <div class="text-muted small">Total: ${summary.total_parcel} | Returns: ${summary.cancelled_parcel}</div>
                </div>`;
                resultContainer.html(html);
            } else {
                resultContainer.html('<small class="text-muted d-block mt-1"><i class="fa-solid fa-circle-minus me-1"></i>No history records found</small>');
            }
        },
        error: function(xhr) {
            resultContainer.html('<small class="text-danger d-block mt-1"><i class="fa-solid fa-circle-exclamation me-1"></i>Fetch failed</small>');
        },
        complete: function() {
            btn.prop('disabled', false);
            btnText.text('Fraud Check');
            spinner.addClass('d-none');
        }
    });
});

// Open Courier Detail Modal
$(document).on('click', '.open-detail', function(e) {
    e.preventDefault();
    let id = $(this).data('id');
    let fullData = lastCourierData[id];
    let html = '';

    if (fullData) {
        const courierKeys = ['pathao', 'redx', 'steadfast', 'paperfly', 'parceldex'];
        courierKeys.forEach(function(key) {
            let courier = fullData[key];
            if (courier && courier.name) {
                html += `
                <div class="d-flex align-items-center mb-3 p-3 bg-light rounded-3" style="border: 1px solid #e2e8f0; gap: 14px;">
                    <img src="${courier.logo}" style="width: 44px; height: 44px; object-fit: contain; border-radius: 8px; background: white; padding: 4px; border: 1px solid #e2e8f0;">
                    <div class="flex-grow-1">
                        <h6 class="mb-1 text-dark" style="font-weight: 700; font-size: 0.95rem;">${courier.name}</h6>
                        <small class="text-muted">Total: ${courier.total_parcel} | Success: <span class="text-success font-weight-bold">${courier.success_parcel}</span> | Failed: <span class="text-danger font-weight-bold">${courier.cancelled_parcel}</span></small>
                    </div>
                    <span class="badge font-weight-bold px-3 py-2" style="font-size: 0.85rem; background-color: #e0e7ff; color: #4338ca; border-radius: 8px;">${courier.success_ratio}%</span>
                </div>`;
            }
        });

        if (!html) {
            html = '<p class="text-muted text-center py-4">No individual courier breakdown available for this customer.</p>';
        }

        $('#courier_detail_content').html(html);
        $('#courierDetailModal').modal('show');
    }
});
</script>
@endsection
