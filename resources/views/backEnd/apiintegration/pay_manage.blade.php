@extends('backEnd.layouts.master') 
@section('title','Payment Gateway')
@section('css')
<link href="{{asset('public/backEnd')}}/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<link href="{{asset('public/backEnd')}}/assets/css/switchery.min.css" rel="stylesheet" type="text/css" />
<style>
  .gateway-card {
    border: none;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
    background: #ffffff;
    margin-bottom: 30px;
    transition: all 0.3s ease;
  }
  .gateway-card:hover {
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.05);
  }
  .gateway-card .card-header {
    background-color: #ffffff;
    border-bottom: 1px solid #f1f3f5;
    padding: 20px 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
  }
  .gateway-card .card-header h4 {
    margin: 0;
    font-weight: 700;
    font-size: 18px;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .gateway-bkash {
    border-top: 4px solid #e2136e;
  }
  .gateway-bkash .card-header h4 {
    color: #e2136e;
  }
  .gateway-shurjopay {
    border-top: 4px solid #0284c7;
  }
  .gateway-shurjopay .card-header h4 {
    color: #0284c7;
  }
  .gateway-card .card-body {
    padding: 24px;
  }
  .form-label-premium {
    font-weight: 600;
    color: #475569;
    margin-bottom: 8px;
    font-size: 13px;
  }
  .form-control-premium {
    border-radius: 8px;
    border: 1px solid #cbd5e1;
    padding: 10px 14px;
    font-size: 13px;
    color: #1e293b;
    transition: all 0.3s ease;
    background: #f8fafc;
  }
  .form-control-premium:focus {
    border-color: #fe5200;
    box-shadow: 0 0 0 3px rgba(254, 82, 0, 0.1);
    outline: none;
    background: #ffffff;
  }
  .btn-submit-premium {
    font-weight: 700;
    padding: 10px 24px;
    border-radius: 8px;
    border: none;
    transition: all 0.3s ease;
    font-size: 14px;
  }
  .btn-bkash {
    background-color: #e2136e;
    color: #ffffff;
    box-shadow: 0 4px 12px rgba(226, 19, 110, 0.2);
  }
  .btn-bkash:hover {
    background-color: #c00e5b;
    color: #ffffff;
    box-shadow: 0 6px 18px rgba(226, 19, 110, 0.3);
  }
  .btn-shurjopay {
    background-color: #0284c7;
    color: #ffffff;
    box-shadow: 0 4px 12px rgba(2, 132, 199, 0.2);
  }
  .btn-shurjopay:hover {
    background-color: #0369a1;
    color: #ffffff;
    box-shadow: 0 6px 18px rgba(2, 132, 199, 0.3);
  }
  .switch-container {
    display: flex;
    align-items: center;
    gap: 10px;
  }
  .switch-container .form-label-premium {
    margin-bottom: 0;
  }
</style>
@endsection 

@section('content')
<div class="container-fluid">
  <!-- start page title -->
  <div class="row">
    <div class="col-12">
      <div class="page-title-box">
        <h4 class="page-title">Payment Gateways Settings</h4>
      </div>
    </div>
  </div>
  <!-- end page title -->

  <div class="row">
    <!-- bKash Configuration Column -->
    <div class="col-lg-6">
      <div class="card gateway-card gateway-bkash">
        <div class="card-header">
          <h4><i class="fa-solid fa-wallet"></i> bKash API Settings</h4>
          <span class="badge {{ $bkash->status == 1 ? 'bg-soft-success text-success' : 'bg-soft-danger text-danger' }} rounded-pill">
            {{ $bkash->status == 1 ? 'Active' : 'Inactive' }}
          </span>
        </div>
        <div class="card-body">
          <form action="{{route('paymentgeteway.update')}}" method="POST" class="row" data-parsley-validate="" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{$bkash->id}}">
            
            <div class="col-sm-12 mb-3">
              <label for="username_bkash" class="form-label-premium">User Name *</label>
              <input type="text" class="form-control form-control-premium @error('username') is-invalid @enderror" name="username" value="{{ $bkash->username}}" id="username_bkash" required="" />
              @error('username')
              <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
              @enderror
            </div>

            <div class="col-sm-12 mb-3">
              <label for="app_key" class="form-label-premium">App Key *</label>
              <input type="text" class="form-control form-control-premium @error('app_key') is-invalid @enderror" name="app_key" value="{{ $bkash->app_key }}" id="app_key" required="" />
              @error('app_key')
              <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
              @enderror
            </div>
            
            <div class="col-sm-12 mb-3">
              <label for="app_secret" class="form-label-premium">App Secret *</label>
              <input type="text" class="form-control form-control-premium @error('app_secret') is-invalid @enderror" name="app_secret" value="{{ $bkash->app_secret }}" id="app_secret" required="" />
              @error('app_secret')
              <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
              @enderror
            </div>

            <div class="col-sm-12 mb-3">
              <label for="base_url_bkash" class="form-label-premium">Base Url *</label>
              <input type="text" class="form-control form-control-premium @error('base_url') is-invalid @enderror" name="base_url" value="{{ $bkash->base_url }}" id="base_url_bkash" required="" />
              @error('base_url')
              <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
              @enderror
            </div>

            <div class="col-sm-12 mb-4">
              <label for="password_bkash" class="form-label-premium">Password *</label>
              <input type="text" class="form-control form-control-premium @error('password') is-invalid @enderror" name="password" value="{{ $bkash->password }}" id="password_bkash" required="" />
              @error('password')
              <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
              @enderror
            </div>

            <div class="col-12 d-flex align-items-center justify-content-between mt-2">
              <div class="switch-container">
                <label for="status_bkash" class="form-label-premium">Gateway Status</label>
                <input type="checkbox" value="1" class="js-switch" @if($bkash->status==1)checked @endif name="status" id="status_bkash" />
              </div>
              <button type="submit" class="btn btn-submit-premium btn-bkash">Save Configuration</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Shurjopay Configuration Column -->
    <div class="col-lg-6">
      <div class="card gateway-card gateway-shurjopay">
        <div class="card-header">
          <h4><i class="fa-solid fa-credit-card"></i> Shurjopay Settings</h4>
          <span class="badge {{ $shurjopay->status == 1 ? 'bg-soft-success text-success' : 'bg-soft-danger text-danger' }} rounded-pill">
            {{ $shurjopay->status == 1 ? 'Active' : 'Inactive' }}
          </span>
        </div>
        <div class="card-body">
          <form action="{{route('paymentgeteway.update')}}" method="POST" class="row" data-parsley-validate="" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{ $shurjopay->id}}">
            
            <div class="col-sm-6 mb-3">
              <label for="username_shurjo" class="form-label-premium">User Name *</label>
              <input type="text" class="form-control form-control-premium @error('username') is-invalid @enderror" name="username" value="{{ $shurjopay->username}}" id="username_shurjo" required="" />
              @error('username')
              <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
              @enderror
            </div>

            <div class="col-sm-6 mb-3">
              <label for="prefix" class="form-label-premium">Prefix *</label>
              <input type="text" class="form-control form-control-premium @error('prefix') is-invalid @enderror" name="prefix" value="{{ $shurjopay->prefix}}" id="prefix" required="" />
              @error('prefix')
              <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
              @enderror
            </div>
            
            <div class="col-sm-12 mb-3">
              <label for="success_url" class="form-label-premium">Success Url *</label>
              <input type="text" class="form-control form-control-premium @error('success_url') is-invalid @enderror" name="success_url" value="{{ $shurjopay->success_url}}" id="success_url" required="" />
              @error('success_url')
              <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
              @enderror
            </div>

            <div class="col-sm-12 mb-3">
              <label for="return_url" class="form-label-premium">Return Url *</label>
              <input type="text" class="form-control form-control-premium @error('return_url') is-invalid @enderror" name="return_url" value="{{ $shurjopay->return_url}}" id="return_url" required="" />
              @error('return_url')
              <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
              @enderror
            </div>

            <div class="col-sm-12 mb-3">
              <label for="base_url_shurjo" class="form-label-premium">Base Url *</label>
              <input type="text" class="form-control form-control-premium @error('base_url') is-invalid @enderror" name="base_url" value="{{ $shurjopay->base_url}}" id="base_url_shurjo" required="" />
              @error('base_url')
              <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
              @enderror
            </div>

            <div class="col-sm-12 mb-4">
              <label for="password_shurjo" class="form-label-premium">Password *</label>
              <input type="text" class="form-control form-control-premium @error('password') is-invalid @enderror" name="password" value="{{ $shurjopay->password}}" id="password_shurjo" required="" />
              @error('password')
              <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
              @enderror
            </div>

            <div class="col-12 d-flex align-items-center justify-content-between mt-2">
              <div class="switch-container">
                <label for="status_shurjo" class="form-label-premium">Gateway Status</label>
                <input type="checkbox" value="1" class="js-switch" @if($shurjopay->status==1)checked @endif name="status" id="status_shurjo" />
              </div>
              <button type="submit" class="btn btn-submit-premium btn-shurjopay">Save Configuration</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection 

@section('script')
<script src="{{asset('public/backEnd/')}}/assets/libs/parsleyjs/parsley.min.js"></script>
<script src="{{asset('public/backEnd/')}}/assets/js/pages/form-validation.init.js"></script>
<script src="{{asset('public/backEnd/')}}/assets/libs/select2/js/select2.min.js"></script>
<script src="{{asset('public/backEnd/')}}/assets/js/pages/form-advanced.init.js"></script>
<script src="{{asset('public/backEnd/')}}/assets/js/switchery.min.js"></script>
<script>
  $(document).ready(function(){
      var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
      elems.forEach(function(html) {
          var switchery = new Switchery(html, { size: 'small' });
      });
  });
</script>
@endsection