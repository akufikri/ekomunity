  <header id="header" class="header d-flex align-items-center sticky-top shadow"
      style="background:{{ $global_brand ? $global_brand->brand_color : '' }}">
      <div class="container position-relative d-flex align-items-center justify-content-between">

          @if ($global_brand)
              <a href="/" class="logo d-flex align-items-center me-auto me-xl-0">
                  <img src="{{ $global_brand->logo_url }}" alt="{{ $global_brand->name_brand }}"
                      style="height: 50px; width: auto;">
                  <div class="ms-2 d-flex flex-column justify-content-center">
                      <h6 class="sitename text-white fw-bold mb-0">{{ $global_brand->name_brand }}</h6>
                      <p class="text-white mb-0" style="font-size: 12px; line-height: 1.2;">
                          {{ $global_brand->description }}
                      </p>
                  </div>
              </a>
          @else
              <a href="/" class="logo d-flex align-items-center me-auto me-xl-0">
                  <img src="{{ asset('landingpage/images/logo/logo-ekomuniti.png') }}" alt=""
                      style="height: 50px; width: auto;">
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
                          {{ __('menu.home') }}
                      </a>
                  </li>
                  <li>
                      <a href="/buletin" class="{{ request()->is('buletin') ? 'fw-bold' : '' }}" style="color: white;">
                          {{ __('menu.news') }}
                      </a>
                  </li>
                  <li>
                      <a href="/direktori" class="{{ request()->is('direktori') ? 'fw-bold' : '' }}"
                          style="color: white;">
                          {{ __('menu.employee') }}
                      </a>
                  </li>
                  <li>
                      <select id="lang-switcher" class="form-control" style="height: 40px">
                          <option value="my" {{ app()->getLocale() === 'my' ? 'selected' : '' }}>🇲🇾 MY</option>
                          <option value="en" {{ app()->getLocale() === 'en' ? 'selected' : '' }}>🇺🇸 ENG</option>
                      </select>
                  </li>
              </ul>
              <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
              <!-- Inline CSS untuk responsive -->
              <style>
                  @media (max-width: 991.98px) {
                      #navmenu ul li a {
                          color: inherit !important;
                      }
                  }
              </style>
          </nav>

      </div>
  </header>
  <script>
      document.getElementById('lang-switcher').addEventListener('change', function() {
          const lang = this.value;
          window.location.href = `/locale/${lang}`;
      });
  </script>
