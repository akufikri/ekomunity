<style>
    /*.button-md {*/
    /*padding: 10px 18px;*/
    /*font-size: 16px;*/
    /*font-weight: 500;*/
    /*}*/
</style>
<div class="sticky-header main-bar-wraper navbar-expand-lg">
    <div class="main-bar clearfix">
        <div class="container clearfix">
            <!-- website logo -->
            <div class="logo-header mostion">
                <!--<a href="/" class="navbar-brand" style="color">OG<b>SE</b></a>  -->
                @if ($global_brand)
                    <a href="/"><img src="{{ $global_brand->logo_url }}" class="logo" alt=""
                            style="height: 50px !important;"></a>
                @else
                    <a href="/"><img src="{{ asset('landingpage/images/logo/logo-ekomuniti.png') }}"
                            class="logo" alt="" style="height: 50px !important;"></a>
                @endif
            </div>
            <!-- nav toggle button -->
            <!-- nav toggle button -->
            <button class="navbar-toggler collapsed navicon justify-content-end" type="button" data-toggle="collapse"
                data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false"
                aria-label="Toggle navigation">
                <span></span>
                <span></span>
                <span></span>
            </button>
            <!-- extra nav -->
            <!--<div class="extra-nav">-->
            <!--    <div class="extra-cell">-->
            <!--    @if (Route::has('login'))-->
            <!--            @auth-->
                <!--                <a href="{{ url('/home') }}" class="site-button"><i class="fa fa-lock"></i> Dashboard</a>-->
            <!--            @else-->
                <!--                <a href="{{ route('login') }}" class="site-button"><i class="fa fa-lock"></i> Login</a>-->
                <!--            @if (Route::has('register'))
    -->
                <!--                <a href="{{ url('register_manpower/create') }}" class="site-button"><i class="fa fa-user"></i> Sign Up</a>-->
                <!--                <a href="{{ url('register_company/create') }}" class="site-button"><i class="fa fa-user"></i> For Company</a>-->
                <!--
    @endif-->
            <!--        @endauth-->
            <!--    @endif-->
            <!--    </div>-->
            <!--</div>-->
            <!-- Quik search -->
            <div class="dez-quik-search bg-primary">
                <form action="#">
                    <input name="search" value="" type="text" class="form-control"
                        placeholder="Type to search">
                    <span id="quik-search-remove"><i class="flaticon-close"></i></span>
                </form>
            </div>
            <!-- main nav -->
            <div class="header-nav navbar-collapse collapse" id="navbarNavDropdown">

                <ul class="nav navbar-nav">
                    <!--<li class="nav-link {{ request()->is('/') ? 'active' : '' }}">-->
                    <!--	<a href="/">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Home&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-chevron"></i></a>-->
                    <!--</li>-->
                    <!--               <li class="nav-link {{ request()->is('about') ? 'active' : '' }}">-->
                    <!--	<a href="/about">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;About&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-chevron"></i></a>-->
                    <!--</li>-->
                    <!--               <li class="nav-link {{ request()->is('contact-us') ? 'active' : '' }}">-->
                    <!--	<a href="/contact-us">Contact Us<i class="fa fa-chevron"></i></a>-->
                    <!--</li>-->
                </ul>
                <ul class="nav navbar-nav ml-auto">

                    <li>
                        <?php
                        $user = Auth::user();
                        ?>
                        @auth
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                class="btn btn-md" style="color: white !important; background-color: #b91c1c; "><i
                                    class="fa fa-lock"></i>
                                Logout</a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>

                            @if ($user->id_level == '1')
                                {{-- <a href="{{ url('/home') }}" class="site-button btn btn-md" style="color: white !important; background-color: #b91c1c; "><i class="fa fa-lock"></i> Dashboard</a> --}}
                            @elseif($user->id_level == '2')
                                {{-- <a href="{{ url('/homeCompany') }}" class="site-button btn btn-md" style="color: white !important; background-color: #b91c1c; "><i class="fa fa-lock"></i> Dashboard</a> --}}
                            @elseif($user->id_level == '3')
                                {{-- <a href="{{ url('/homeManPower') }}" class="site-button btn btn-md" style="color: white !important; background-color: #b91c1c; "><i class="fa fa-lock"></i> Dashboard</a> --}}
                            @else
                                <a href="{{ route('login') }}" class="btn btn-md"
                                    style="color: white !important; background-color: #b91c1c; "><i class="fa fa-lock"></i>
                                    &nbsp;&nbsp;&nbsp;&nbsp;LOGIN</a>
                            @endif
                        @endauth
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
