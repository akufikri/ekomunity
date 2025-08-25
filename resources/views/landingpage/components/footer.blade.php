

<footer id="footer" class="footer dark-background" style="background: #323448">

    <div class="container footer-top">
      <div class="row gy-4">
        <div class="col-lg-4 col-md-6 footer-about">
          <a href="/" class="logo d-flex align-items-center">
            @if ($global_brand)
            <img src="{{ $global_brand->logo_url }}" alt="{{ $global_brand->name_brand }}">
            <span class="sitename">{{ $global_brand->name_brand }} - {{ $global_brand->description }}</span>
            @else
                <img src="{{ asset('landingpage/images/logo-usia.png') }}" alt="">
                <span class="sitename">USIA - Pertumbuhan Islam Seluruh Sabah</span>
            @endif
          </a>
          <div class="footer-contact pt-3">
            <p>Taman Sempelang</p>
            <p>88100 Kota Kinabalu, Sabah</p>
            <p class="mt-3"><strong>Phone:</strong> <span>+08993984</span></p>
            <p><strong>Email:</strong> <span>info@usia.com.my</span></p>
          </div>
        </div>
        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Useful Links</h4>
          <ul>
            <li><a href="/">Home</a></li>
            <li><a href="/mengenai">Mengenai Usia</a></li>
            <li><a href="/buletin">Buletin Usia</a></li>
            <li><a href="/direktori">Direktori</a></li>
          </ul>
        </div>
      </div>
    </div>

  
    <div class="container copyright text-center mt-4">
      <p>© <span>Pertubuhan Islam Seluruh Sabah. Hasil kerjasama Coedev Technology Sdn Bhd</span></p>
    </div>

  </footer>