<!-- Page Sidebar Start -->
<div class="sidebar-wrapper" sidebar-layout="stroke-svg">
    <div>
        <div class="logo-wrapper"><a href="{{ route('admin.dashboard') }}"><img class="img-fluid for-light" style="width:75%" src="{{ asset('assets/images/logo/logo.png') }}" alt=""><img class="img-fluid for-dark" style="width:75%" src="{{ asset('assets/images/logo/logo-white.png') }}" alt=""></a>
            <div class="back-btn"><i class="fa fa-angle-left"></i></div>
            <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid"> </i></div>
        </div>
        <div class="logo-icon-wrapper" style="text-align:left; padding:20px 0px 25px 25px;">
            <a href="{{ route('admin.dashboard') }}"><img class="img-fluid" style="width:50%" src="{{ asset('assets/images/logo/logo-icon.png') }}" alt=""></a>
        </div>
        <nav class="sidebar-main">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="sidebar-menu">
            <ul class="sidebar-links" id="simple-bar">
                <li class="back-btn"><a href="{{ route('admin.dashboard') }}"><img class="img-fluid" src="{{ asset('assets/images/logo/logo-icon.png') }}" alt=""></a>
                    <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2" aria-hidden="true"></i></div>
                </li>
                <li class="pin-title sidebar-main-title">
                    <div> 
                        <h6>{{ __('navigation.admin.pinned') }}</h6>
                    </div>
                </li>
                <li class="sidebar-main-title">
                    <div>
                        <h6 class="lan-1">{{ __('navigation.admin.general') }}</h6>
                    </div>
                </li>
                <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title link-nav" href="{{ route('admin.dashboard') }}">
                <svg class="stroke-icon">
                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                </svg>
                <svg class="fill-icon">
                    <use href="{{ asset('assets/svg/icon-sprite.svg#fill-home') }}"></use>
                </svg><span>{{ __('navigation.admin.dashboard') }}</span></a>
                </li>
                <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title" href="#">
                    <svg class="stroke-icon">
                        <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-gallery') }}"></use>
                    </svg>
                    <svg class="fill-icon">
                        <use href="{{ asset('assets/svg/icon-sprite.svg#fill-gallery') }}"></use>
                    </svg><span>{{ __('navigation.admin.slider.nav') }}</span></a>
                    <ul class="sidebar-submenu">
                      <li><a href="{{ route('admin.slider') }}">{{ __('navigation.admin.slider.index') }}</a></li>
                      <li><a href="{{ route('admin.slider.create') }}">{{ __('navigation.admin.slider.create') }}</a></li>
                    </ul>
                </li>
                <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title" href="#">
                    <svg class="stroke-icon">
                        <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-user') }}"></use>
                    </svg>
                    <svg class="fill-icon">
                        <use href="{{ asset('assets/svg/icon-sprite.svg#fill-user') }}"></use>
                    </svg><span>{{ __('navigation.admin.testimonial.nav') }}</span></a>
                    <ul class="sidebar-submenu">
                      <li><a href="{{ route('admin.testimonial') }}">{{ __('navigation.admin.testimonial.index') }}</a></li>
                      <li><a href="{{ route('admin.testimonial.create') }}">{{ __('navigation.admin.testimonial.create') }}</a></li>
                    </ul>
                </li>
                <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title" href="#">
                    <svg class="stroke-icon">
                        <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-landing-page') }}"></use>
                    </svg>
                    <svg class="fill-icon">
                        <use href="{{ asset('assets/svg/icon-sprite.svg#fill-landing-page') }}"></use>
                    </svg><span>{{ __('navigation.admin.plan.nav') }}</span></a>
                    <ul class="sidebar-submenu">
                      <li><a href="{{ route('admin.plan') }}">{{ __('navigation.admin.plan.index') }}</a></li>
                      <li><a href="{{ route('admin.plan.create') }}">{{ __('navigation.admin.plan.create') }}</a></li>
                    </ul>
                </li>                             
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </nav>
    </div>
</div>
<!-- Page Sidebar Ends-->