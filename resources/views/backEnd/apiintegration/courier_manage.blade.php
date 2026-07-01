@extends('backEnd.layouts.master') 
@section('title','Courier API Integrations')
@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
  /* Base Styles & Typography */
  .courier-dashboard {
    font-family: 'Outfit', sans-serif;
    color: #1e293b;
    padding-bottom: 2rem;
  }
  
  .courier-header {
    background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
    padding: 2.5rem;
    border-radius: 20px;
    margin-bottom: 2.5rem;
    box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
    position: relative;
    overflow: hidden;
  }
  
  .courier-header::after {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 300px;
    height: 300px;
    background: radial-gradient(circle, rgba(99, 102, 241, 0.15) 0%, rgba(99, 102, 241, 0) 70%);
    border-radius: 50%;
  }

  .courier-header h1 {
    font-size: 1.85rem;
    font-weight: 700;
    color: #ffffff;
    margin-bottom: 0.5rem;
  }

  .courier-header p {
    color: #94a3b8;
    font-size: 0.95rem;
    margin-bottom: 0;
  }

  /* Courier Cards */
  .courier-card {
    border: none;
    border-radius: 20px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.03), 0 1px 3px rgba(0, 0, 0, 0.01);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    overflow: hidden;
    background: #ffffff;
    height: 100%;
  }

  .courier-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 35px rgba(0, 0, 0, 0.06), 0 4px 6px rgba(0, 0, 0, 0.02);
  }

  .card-gradient-top {
    height: 6px;
    width: 100%;
  }

  .bg-steadfast {
    background: linear-gradient(90deg, #4f46e5 0%, #6366f1 100%);
  }

  .bg-pathao {
    background: linear-gradient(90deg, #dc2626 0%, #ef4444 100%);
  }

  .courier-card-body {
    padding: 2.2rem;
  }

  .courier-brand {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 2rem;
  }

  .brand-logo-wrapper {
    display: flex;
    align-items: center;
    gap: 12px;
  }

  .brand-icon-box {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #ffffff;
    font-size: 1.5rem;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
  }

  .icon-steadfast {
    background: #e0e7ff;
    color: #4f46e5;
  }

  .icon-pathao {
    background: #fee2e2;
    color: #dc2626;
  }

  .brand-name {
    font-size: 1.25rem;
    font-weight: 700;
    margin: 0;
  }

  .brand-type {
    font-size: 0.8rem;
    color: #64748b;
    font-weight: 500;
  }

  /* Form Elements */
  .form-label {
    font-size: 0.85rem;
    font-weight: 600;
    color: #475569;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 6px;
  }

  .form-label i {
    color: #94a3b8;
  }

  .form-control-custom {
    border: 1.5px solid #e2e8f0;
    border-radius: 12px;
    padding: 0.75rem 1rem;
    font-size: 0.9rem;
    font-family: inherit;
    font-weight: 450;
    color: #0f172a;
    transition: all 0.2s ease;
    background: #f8fafc;
  }

  .form-control-custom:focus {
    border-color: #6366f1;
    background: #ffffff;
    box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
    outline: none;
  }

  .pathao-focus:focus {
    border-color: #ef4444;
    box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.1);
  }

  /* Toggle Switch Styles */
  .switch-container {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: #f8fafc;
    padding: 1rem 1.25rem;
    border-radius: 12px;
    border: 1.5px solid #e2e8f0;
    margin-bottom: 1.8rem;
  }

  .switch-label-text {
    font-size: 0.9rem;
    font-weight: 600;
    color: #334155;
  }

  .switch-desc {
    font-size: 0.75rem;
    color: #64748b;
    display: block;
    margin-top: 2px;
  }

  .ios-switch {
    position: relative;
    display: inline-block;
    width: 50px;
    height: 28px;
    margin: 0;
  }

  .ios-switch input {
    opacity: 0;
    width: 0;
    height: 0;
  }

  .ios-slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #cbd5e1;
    transition: .3s;
    border-radius: 34px;
  }

  .ios-slider:before {
    position: absolute;
    content: "";
    height: 22px;
    width: 22px;
    left: 3px;
    bottom: 3px;
    background-color: white;
    transition: .3s;
    border-radius: 50%;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
  }

  .ios-switch input:checked + .ios-slider {
    background-color: #10b981;
  }

  .ios-switch input:checked + .ios-slider:before {
    transform: translateX(22px);
  }

  /* Buttons */
  .btn-premium {
    width: 100%;
    padding: 0.8rem 1.5rem;
    font-size: 0.95rem;
    font-weight: 600;
    border-radius: 12px;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    cursor: pointer;
    transition: all 0.2s ease;
    box-shadow: 0 4px 12px rgba(99, 102, 241, 0.15);
  }

  .btn-steadfast-save {
    background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
    color: #ffffff;
  }

  .btn-steadfast-save:hover {
    background: linear-gradient(135deg, #4338ca 0%, #3730a3 100%);
    transform: translateY(-2px);
    box-shadow: 0 8px 16px rgba(99, 102, 241, 0.25);
  }

  .btn-pathao-save {
    background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
    color: #ffffff;
    box-shadow: 0 4px 12px rgba(220, 38, 38, 0.15);
  }

  .btn-pathao-save:hover {
    background: linear-gradient(135deg, #b91c1c 0%, #991b1b 100%);
    transform: translateY(-2px);
    box-shadow: 0 8px 16px rgba(220, 38, 38, 0.25);
  }

  .btn-premium:active {
    transform: translateY(0);
  }

  /* Badges */
  .status-badge {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 6px;
  }

  .badge-active {
    background-color: #d1fae5;
    color: #065f46;
    border: 1px solid #a7f3d0;
  }

  .badge-inactive {
    background-color: #f1f5f9;
    color: #475569;
    border: 1px solid #e2e8f0;
  }

  .status-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
  }

  .dot-active {
    background-color: #10b981;
    box-shadow: 0 0 8px #10b981;
    animation: pulse 2s infinite;
  }

  .dot-inactive {
    background-color: #64748b;
  }

  /* Help Info */
  .help-info {
    font-size: 0.78rem;
    color: #64748b;
    margin-top: 0.4rem;
    display: block;
  }

  @keyframes pulse {
    0% {
      transform: scale(0.95);
      box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
    }
    70% {
      transform: scale(1);
      box-shadow: 0 0 0 6px rgba(16, 185, 129, 0);
    }
    100% {
      transform: scale(0.95);
      box-shadow: 0 0 0 0 rgba(16, 185, 129, 0);
    }
  }
</style>
@endsection

@section('content')
<div class="container-fluid courier-dashboard">
  
  <!-- Page Header -->
  <div class="courier-header">
    <div class="row align-items-center">
      <div class="col-md-8">
        <h1>Courier API Settings</h1>
        <p>Manage credentials and endpoints for your integrated third-party shipping solutions.</p>
      </div>
      <div class="col-md-4 text-md-end mt-3 mt-md-0">
        <span class="text-white opacity-50"><i class="fa-solid fa-gear fa-spin fa-lg"></i></span>
      </div>
    </div>
  </div>

  <div class="row">
    
    <!-- Steadfast Courier Card -->
    <div class="col-lg-6 mb-4">
      <div class="card courier-card">
        <div class="card-gradient-top bg-steadfast"></div>
        <div class="courier-card-body">
          <div class="courier-brand">
            <div class="brand-logo-wrapper">
              <div class="brand-icon-box icon-steadfast">
                <i class="fa-solid fa-truck-fast"></i>
              </div>
              <div>
                <h3 class="brand-name">Steadfast</h3>
                <span class="brand-type">Express Delivery Service</span>
              </div>
            </div>
            @if($steadfast->status == 1)
              <span class="status-badge badge-active"><span class="status-dot dot-active"></span>Active</span>
            @else
              <span class="status-badge badge-inactive"><span class="status-dot dot-inactive"></span>Inactive</span>
            @endif
          </div>

          <form action="{{route('courierapi.update')}}" method="POST" data-parsley-validate="">
            @csrf
            <input type="hidden" name="id" value="{{$steadfast->id}}">

            <div class="form-group mb-3">
              <label for="steadfast_api_key" class="form-label">
                <i class="fa-solid fa-key"></i> API Key
              </label>
              <input type="text" 
                     class="form-control form-control-custom @error('api_key') is-invalid @enderror" 
                     name="api_key" 
                     value="{{ $steadfast->api_key }}" 
                     id="steadfast_api_key" 
                     required="" 
                     placeholder="Enter Steadfast API Key" />
              <small class="help-info">Get your API key from the Steadfast Merchant panel API settings.</small>
              @error('api_key')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>

            <div class="form-group mb-3">
              <label for="steadfast_secret_key" class="form-label">
                <i class="fa-solid fa-lock"></i> Secret Key
              </label>
              <input type="text" 
                     class="form-control form-control-custom @error('secret_key') is-invalid @enderror" 
                     name="secret_key" 
                     value="{{ $steadfast->secret_key }}" 
                     id="steadfast_secret_key" 
                     required="" 
                     placeholder="Enter Steadfast Secret Key" />
              <small class="help-info">Get your Secret key from the Steadfast Merchant panel API settings.</small>
              @error('secret_key')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>

            <div class="form-group mb-4">
              <label for="steadfast_url" class="form-label">
                <i class="fa-solid fa-link"></i> Endpoint URL
              </label>
              <input type="text" 
                     class="form-control form-control-custom @error('url') is-invalid @enderror" 
                     name="url" 
                     value="{{ $steadfast->url }}" 
                     id="steadfast_url" 
                     required="" 
                     placeholder="https://nextday.steadfast.com.bd/api/v1/create_order" />
              <small class="help-info">Steadfast API endpoint URL.</small>
              @error('url')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>

            <div class="switch-container">
              <div>
                <span class="switch-label-text">Enable Steadfast</span>
                <span class="switch-desc">Toggle to activate this courier service for orders.</span>
              </div>
              <label class="ios-switch">
                <input type="checkbox" value="1" @if($steadfast->status==1)checked @endif name="status" />
                <span class="ios-slider"></span>
              </label>
            </div>

            <button type="submit" class="btn-premium btn-steadfast-save">
              <i class="fa-solid fa-floppy-disk"></i> Save Steadfast Settings
            </button>
          </form>
        </div>
      </div>
    </div>

    <!-- Pathao Courier Card -->
    <div class="col-lg-6 mb-4">
      <div class="card courier-card">
        <div class="card-gradient-top bg-pathao"></div>
        <div class="courier-card-body">
          <div class="courier-brand">
            <div class="brand-logo-wrapper">
              <div class="brand-icon-box icon-pathao">
                <i class="fa-solid fa-motorcycle"></i>
              </div>
              <div>
                <h3 class="brand-name">Pathao</h3>
                <span class="brand-type">Express Logistics Network</span>
              </div>
            </div>
            @if($pathao->status == 1)
              <span class="status-badge badge-active"><span class="status-dot dot-active"></span>Active</span>
            @else
              <span class="status-badge badge-inactive"><span class="status-dot dot-inactive"></span>Inactive</span>
            @endif
          </div>

          <form action="{{route('courierapi.update')}}" method="POST" data-parsley-validate="">
            @csrf
            <input type="hidden" name="id" value="{{$pathao->id}}">

            <div class="form-group mb-3">
              <label for="pathao_url" class="form-label">
                <i class="fa-solid fa-link"></i> Endpoint URL
              </label>
              <input type="text" 
                     class="form-control form-control-custom pathao-focus @error('url') is-invalid @enderror" 
                     name="url" 
                     value="{{ $pathao->url }}" 
                     id="pathao_url" 
                     required="" 
                     placeholder="https://api-hermes.pathao.com" />
              <small class="help-info">Hermes API endpoint base URL.</small>
              @error('url')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>

            <div class="form-group mb-4">
              <label for="pathao_token" class="form-label">
                <i class="fa-solid fa-shield-halved"></i> Access Token
              </label>
              <input type="text" 
                     class="form-control form-control-custom pathao-focus @error('token') is-invalid @enderror" 
                     name="token" 
                     value="{{ $pathao->token }}" 
                     id="pathao_token" 
                     required="" 
                     placeholder="Enter Pathao Bearer Token" />
              <small class="help-info">Long-lived Bearer access token generated from your Pathao account.</small>
              @error('token')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>

            <div class="switch-container">
              <div>
                <span class="switch-label-text">Enable Pathao</span>
                <span class="switch-desc">Toggle to activate this courier service for orders.</span>
              </div>
              <label class="ios-switch">
                <input type="checkbox" value="1" @if($pathao->status==1)checked @endif name="status" />
                <span class="ios-slider"></span>
              </label>
            </div>

            <button type="submit" class="btn-premium btn-pathao-save">
              <i class="fa-solid fa-floppy-disk"></i> Save Pathao Settings
            </button>
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
@endsection