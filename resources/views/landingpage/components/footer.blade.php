<footer id="footer" class="footer dark-background" style="background: {{ $global_brand ? $global_brand->brand_color : "#323448" }}">

    <div class="container footer-top">
        <div class="row gy-4">
            <div class="col-lg-4 col-md-6 footer-about">
                <a href="/" class="logo d-flex align-items-center">
                    @if ($global_brand)
                        <img src="{{ $global_brand->logo_url }}" alt="{{ $global_brand->name_brand }}">
                        <span class="sitename" style="font-size: 14px">{{ $global_brand->name_brand }}</span>
                    @else
                        <img src="{{ asset('landingpage/images/logo-usia.png') }}" alt="">
                        <span class="sitename" style="font-size: 14px">USIA - Pertumbuhan Islam Seluruh Sabah</span>
                    @endif
                </a>
                <div class="footer-contact pt-3">
                    <p>Taman Sempelang</p>
                    <p>88100 Kota Kinabalu, Sabah</p>
                    <p class="mt-3"><strong>{{ __('menu.phone') }}:</strong> <span>+08993984</span></p>
                    <p><strong>{{ __('menu.email') }}:</strong> <span>info@usia.com.my</span></p>
                </div>
            </div>
            <div class="col-lg-2 col-md-3 footer-links">
                <h4>{{ __('menu.useful_link') }}</h4>
                <ul>
                    <li><a href="/">{{ __('menu.home') }}</a></li>
                    <li><a href="/buletin">{{ __('menu.news') }}</a></li>
                    <li><a href="/direktori">{{ __('menu.employee') }}</a></li>
                </ul>
            </div>
        </div>
    </div>


    <div class="container copyright text-center mt-4">
        <p>© <span>Pertubuhan Islam Seluruh Sabah. Hasil kerjasama Coedev Technology Sdn Bhd</span></p>
    </div>

</footer>
