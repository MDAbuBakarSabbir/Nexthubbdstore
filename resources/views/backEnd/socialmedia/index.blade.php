@extends('backEnd.layouts.master')
@section('title','Social Media Manage')

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
  /* Base Styles & Typography */
  .social-dashboard {
    font-family: 'Outfit', sans-serif;
    color: #1e293b;
    padding-bottom: 2rem;
  }
  
  .social-hero {
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
    border-radius: 20px;
    padding: 2.5rem;
    margin-bottom: 2.5rem;
    box-shadow: 0 10px 30px rgba(15, 23, 42, 0.05);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1.5rem;
    position: relative;
    overflow: hidden;
  }

  .social-hero::after {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 250px;
    height: 250px;
    background: radial-gradient(circle, rgba(99, 102, 241, 0.15) 0%, rgba(99, 102, 241, 0) 70%);
    border-radius: 50%;
  }

  .social-hero-text h1 {
    color: #ffffff;
    font-size: 1.8rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
  }

  .social-hero-text p {
    color: #94a3b8;
    font-size: 0.95rem;
    margin-bottom: 0;
  }

  .btn-create-premium {
    background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
    color: #ffffff !important;
    font-weight: 600;
    font-size: 0.9rem;
    padding: 0.75rem 1.8rem;
    border-radius: 30px;
    box-shadow: 0 4px 14px rgba(99, 102, 241, 0.35);
    border: none;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    display: inline-flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
    z-index: 2;
  }

  .btn-create-premium:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 22px rgba(99, 102, 241, 0.45);
  }

  /* Social Grid Cards */
  .social-card {
    border: none;
    border-radius: 20px;
    background: #ffffff;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.02), 0 1px 3px rgba(0, 0, 0, 0.01);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    height: 100%;
    overflow: hidden;
    position: relative;
  }

  .social-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 35px rgba(0, 0, 0, 0.06), 0 4px 6px rgba(0, 0, 0, 0.02);
  }

  .social-card-body {
    padding: 2rem;
    display: flex;
    flex-direction: column;
    height: 100%;
  }

  .social-card-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.8rem;
  }

  .social-icon-wrapper {
    width: 52px;
    height: 52px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
  }

  .social-card-title {
    font-size: 1.25rem;
    font-weight: 700;
    margin: 0;
    color: #0f172a;
  }

  .social-card-link-box {
    background: #f8fafc;
    border: 1.5px solid #e2e8f0;
    border-radius: 12px;
    padding: 0.7rem 0.9rem;
    font-size: 0.85rem;
    color: #475569;
    word-break: break-all;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
    margin-bottom: 1.8rem;
  }

  .social-card-link {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    flex-grow: 1;
    text-decoration: none;
    color: #475569;
    font-weight: 500;
  }

  .social-card-link:hover {
    color: #6366f1;
  }

  .btn-copy-link {
    border: none;
    background: transparent;
    color: #94a3b8;
    cursor: pointer;
    transition: color 0.15s ease;
    padding: 2px;
  }

  .btn-copy-link:hover {
    color: #475569;
  }

  /* Custom IOS Button Toggle Switch */
  .switch-container {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.8rem;
    background: #f8fafc;
    padding: 0.8rem 1rem;
    border-radius: 12px;
    border: 1.5px solid #e2e8f0;
    margin-top: auto;
  }

  .switch-status-label {
    font-size: 0.85rem;
    font-weight: 600;
  }

  .status-active-txt {
    color: #10b981;
  }

  .status-inactive-txt {
    color: #64748b;
  }

  .ios-switch-btn {
    position: relative;
    display: inline-block;
    width: 46px;
    height: 26px;
    background-color: #cbd5e1;
    border-radius: 26px;
    border: none;
    cursor: pointer;
    transition: background-color 0.25s ease;
    padding: 0;
  }

  .ios-switch-btn.active {
    background-color: #10b981;
  }

  .ios-slider-knob {
    position: absolute;
    top: 3px;
    left: 3px;
    width: 20px;
    height: 20px;
    background-color: #ffffff;
    border-radius: 50%;
    transition: transform 0.25s ease;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.15);
  }

  .ios-switch-btn.active .ios-slider-knob {
    transform: translateX(20px);
  }

  /* Action Buttons */
  .social-actions {
    display: flex;
    gap: 8px;
    margin-top: auto;
  }

  .btn-action-premium {
    flex: 1;
    padding: 0.65rem;
    border-radius: 12px;
    font-size: 0.85rem;
    font-weight: 600;
    border: none;
    cursor: pointer;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    text-decoration: none;
  }

  .btn-action-edit {
    background-color: #f1f5f9;
    color: #475569;
  }

  .btn-action-edit:hover {
    background-color: #e2e8f0;
    color: #0f172a;
  }

  .btn-action-delete {
    background-color: #fee2e2;
    color: #ef4444;
  }

  .btn-action-delete:hover {
    background-color: #fecaca;
    color: #b91c1c;
  }
</style>
@endsection

@section('content')
<div class="container-fluid social-dashboard">
    
    <!-- Page Hero -->
    <div class="social-hero mt-4">
        <div class="social-hero-text">
            <h1>Social Media Channels</h1>
            <p>Manage, toggle, and configure your active business social media profiles and links.</p>
        </div>
        <div>
            <a href="{{route('socialmedias.create')}}" class="btn-create-premium">
                <i class="fa-solid fa-plus"></i> Create Link
            </a>
        </div>
    </div>       

    <!-- Cards Grid -->
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @foreach($show_data as $key=>$value)
        <div class="col">
            <div class="card social-card" style="border-top: 5px solid {{ $value->color }};">
                <div class="social-card-body">
                    
                    <div class="social-card-top">
                        <div>
                            <h3 class="social-card-title">{{ $value->title }}</h3>
                        </div>
                        <div class="social-icon-wrapper" style="background: {{ $value->color }}12;">
                            <i class="{{ $value->icon }} fa-lg" style="color: {{ $value->color }};"></i>
                        </div>
                    </div>

                    <div class="social-card-link-box">
                        <a href="{{ $value->link }}" target="_blank" class="social-card-link">{{ $value->link }}</a>
                        <button class="btn-copy-link" onclick="copyLink('{{ $value->link }}', this)" title="Copy Link">
                            <i class="fa-regular fa-copy"></i>
                        </button>
                    </div>

                    <!-- Status Toggle (Linked to Admin Confirmation script) -->
                    <div class="switch-container">
                        @if($value->status == 1)
                            <span class="switch-status-label status-active-txt">Active</span>
                            <form method="post" action="{{route('socialmedias.inactive')}}" class="d-inline"> 
                                @csrf
                                <input type="hidden" value="{{$value->id}}" name="hidden_id">
                                <button type="button" class="ios-switch-btn active change-confirm" title="Toggle to Inactive">
                                    <span class="ios-slider-knob"></span>
                                </button>
                            </form>
                        @else
                            <span class="switch-status-label status-inactive-txt">Inactive</span>
                            <form method="post" action="{{route('socialmedias.active')}}" class="d-inline">
                                @csrf
                                <input type="hidden" value="{{$value->id}}" name="hidden_id">
                                <button type="button" class="ios-switch-btn change-confirm" title="Toggle to Active">
                                    <span class="ios-slider-knob"></span>
                                </button>
                            </form>
                        @endif
                    </div>

                    <!-- Actions -->
                    <div class="social-actions">
                        <a href="{{route('socialmedias.edit',$value->id)}}" class="btn-action-premium btn-action-edit">
                            <i class="fa-regular fa-pen-to-square"></i> Edit
                        </a>

                        <form method="post" action="{{route('socialmedias.destroy')}}" class="d-inline flex-grow-1">        
                            @csrf
                            <input type="hidden" value="{{$value->id}}" name="hidden_id">
                            <button type="button" class="btn-action-premium btn-action-delete w-100 delete-confirm">
                                <i class="fa-regular fa-trash-can"></i> Delete
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

@section('script')
<script>
    // ===== Copy Link Clipboard Helper =====
    function copyLink(text, button) {
        navigator.clipboard.writeText(text).then(function() {
            var originalIcon = button.innerHTML;
            button.innerHTML = '<i class="fa-solid fa-check" style="color: #10b981;"></i>';
            setTimeout(function() {
                button.innerHTML = originalIcon;
            }, 2000);
        }, function(err) {
            console.error('Could not copy link: ', err);
        });
    }
</script>
@endsection