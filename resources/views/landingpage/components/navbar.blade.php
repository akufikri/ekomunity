  <header id="header" class="header d-flex align-items-center sticky-top shadow">
      <div class="container position-relative d-flex align-items-center justify-content-between">

          @if ($global_brand)
              <a href="/" class="logo d-flex align-items-center me-auto me-xl-0">
              <img src="{{ $global_brand->logo_url }}" alt="{{ $global_brand->name_brand }}" style="height: 50px; width: auto;">
              <div class="ms-2 d-flex flex-column justify-content-center">
                  <h6 class="sitename text-white fw-bold mb-0">{{ $global_brand->name_brand }}</h6>
                  <p class="text-white mb-0" style="font-size: 12px; line-height: 1.2;">
                      {{ $global_brand->description }}
                  </p>
              </div>
          </a>
          @else
          <a href="/" class="logo d-flex align-items-center me-auto me-xl-0">
              <img src="{{ asset('images/coedev-logo.png') }}" alt="" style="height: 50px; width: auto;">
              <div class="ms-2 d-flex flex-column justify-content-center">
                  <h6 class="sitename text-white fw-bold mb-0">Coedev</h6>
                  <p class="text-white mb-0" style="font-size: 12px; line-height: 1.2;">
                      formerly known as Idolegacy Sdn Bhd
                  </p>
              </div>
          </a>
          @endif

          <nav id="navmenu" class="navmenu">
              <ul>
                  <li>
                      <a href="/" class="{{ request()->is('/') ? 'fw-bold' : '' }}" style="color: white;">
                          Laman Utama
                      </a>
                  </li>
                  <li>
                      <a href="/buletin" class="{{ request()->is('buletin') ? 'fw-bold' : '' }}" style="color: white;">
                          Buletin Usia
                      </a>
                  </li>
                  <li>
                      <a href="/direktori" class="{{ request()->is('direktori') ? 'fw-bold' : '' }}"
                          style="color: white;">
                          Direktori
                      </a>
                  </li>
              </ul>
              <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>

              <!-- Inline CSS untuk responsive -->
              <style>
                  @media (max-width: 991.98px) {

                      /* untuk mobile/tablet */
                      #navmenu ul li a {
                          color: inherit !important;
                          /* hapus warna putih di mobile */
                      }
                  }
              </style>
          </nav>


          <div class="header-social-links">
              <a href="#" class="facebook text-white"><i class="bi bi-facebook"></i></a>
              <a href="#" class="instagram text-white"><i class="bi bi-instagram"></i></a>>
          </div>

      </div>
  </header>
