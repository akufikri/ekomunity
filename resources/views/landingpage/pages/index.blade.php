@extends('landingpage.layout.app')
@push('style')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .dropdown-menu {
            z-index: 1055;
        }

        .section,
        .col-lg-2 {
            overflow: visible !important;
        }

        /* Styling Select2 agar lebih modern */
        .select2-container--default .select2-selection--single {
            height: 50px;
            /* tinggi minimal */
            border-radius: 10px;
            /* sudut membulat */
            border: 1px solid #d1d5db;
            /* border abu2 lembut */
            padding: 10px 14px;
            /* padding biar lega */
            font-size: 16px;
            /* teks lebih besar */
            display: flex;
            align-items: center;
            /* teks di tengah vertikal */
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            transition: all 0.2s ease;
        }

        .select2-container--default .select2-selection--single:hover {
            border-color: #3b82f6;
            /* border biru saat hover */
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 100%;
            /* panah di tengah */
            right: 10px;
        }

        /* Placeholder styling */
        .select2-container--default .select2-selection--single .select2-selection__placeholder {
            color: #9ca3af;
            font-size: 15px;
        }

        /* Dropdown styling */
        .select2-container--default .select2-results>.select2-results__options {
            max-height: 250px;
            border-radius: 8px;
            font-size: 15px;
        }

        /* Highlight option saat hover */
        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #3b82f6;
            color: #fff;
        }
    </style>
@endpush
@section('content')
    <!-- Slider Section -->
    <section id="slider" class="slider section dark-background">

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="swiper init-swiper">

                <script type="application/json" class="swiper-config">
                    {
                      "loop": true,
                      "speed": 600,
                      "autoplay": {
                        "delay": 5000
                      },
                      "slidesPerView": "auto",
                      "centeredSlides": true,
                      "pagination": {
                        "el": ".swiper-pagination",
                        "type": "bullets",
                        "clickable": true
                      },
                      "navigation": {
                        "nextEl": ".swiper-button-next",
                        "prevEl": ".swiper-button-prev"
                      }
                    }
                    </script>

                <div id="swiper-wrapper" class="swiper-wrapper">
                    <!-- Carousel slides will be dynamically populated here -->
                </div>

                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>

                <div class="swiper-pagination"></div>
            </div>

        </div>

    </section><!-- /Slider Section -->

    <!-- Time prayer -->
    <section class="section">
        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="row">
                <!-- Select untuk zona -->
                <div class="col-lg-2">
                    <div class="mb-3">
                        <select id="prayer-zone-select" class="form-select prayer-zone-select" style="width: 100%">
                        </select>
                    </div>
                </div>
                <div class="col-lg-8 col-12">
                    <div class="table-responsive">
                        <table class="table table-borderless text-center align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Imsak</th>
                                    <th>Subuh</th>
                                    <th class="d-none d-sm-table-cell">Zohor</th>
                                    <th class="d-none d-sm-table-cell">Asar</th>
                                    <th>Magrib</th>
                                    <th class="d-none d-sm-table-cell">Ishak</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- data akan diisi via JS -->
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- Time prayer -->
    <!-- Buletin sections -->
    <section id="trending-category" class="trending-category section">
        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="container" data-aos="fade-up">
                <h4 class="fw-bold">Buletin Usia</h4>
                <div class="row g-5">
                    <div class="col-lg-4">
                        <div class="post-entry lg">
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="row g-5" id="dynamic-categories">
                            <!-- Categories will be populated dynamically here -->
                        </div>
                    </div>

                </div> <!-- End .row -->
            </div>

        </div>

    </section><!-- /Buletin sections -->

    <!-- Cawangan USIA -->
    <section class="section">
        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <h5 class="fw-bold text-center">Cawangan USIA</h5>
            <div class="card border-0 shadow-sm" style="border-radius: 12px">
                <div class="card-body">
                    <iframe style="width: 100%; height:400px; border-radius:8px" frameborder="0" style="border:0"
                        src="{{ env('BASE_URL') }}view_map_cawangan" allowfullscreen=""></iframe>
                </div>
            </div>
        </div>
    </section>
    <!-- Cawangan USIA -->
    <!-- CTA -->
    <section class="section my-5">
        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="card shadow-lg border-0 text-center"
                style="background: {{ $global_brand ? $global_brand->brand_color : "" }}">
                <div class="card-body py-5">
                    <h2 class="fw-bold mb-3 text-white">{{ $global_brand ? $global_brand->cta : "" }}</h2>
                    {{-- <p class="mb-4" style="font-size: 1.1rem;">
                        Bergabunglah bersama kami dan dapatkan manfaat eksklusif untuk anggota.
                    </p> --}}
                    <a href="/register_ahli/create" class="btn btn-light btn-lg fw-bold px-4 py-2 text-success">
                        Daftar Sekarang
                    </a>
                </div>
            </div>
        </div>
    </section>
    <!-- /CTA -->
@endsection
@push('script')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        let categoriesData = []; // Global variable to store categories

        $(document).ready(function() {
            localStorage.removeItem('selectedPrayerZone');
            loadCategories(); // Load categories first
            buletinCarousel();
            fetchPrayerZones();
        });

        /**
         * Load Categories from API
         */
        const loadCategories = () => {
            $.ajax({
                url: '/category/post/getData?is_public=1',
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    console.log('Categories loaded:', response);
                    
                    // Store categories globally
                    if (response.data && Array.isArray(response.data)) {
                        categoriesData = response.data.slice(0, 2); // Get top 2 categories
                    } else if (Array.isArray(response)) {
                        categoriesData = response.slice(0, 2); // If response is direct array
                    }

                    // Generate dynamic category columns
                    generateCategoryColumns();
                    
                    // After categories are loaded, load bulletins
                    buletinWithTop();
                },
                error: function(xhr, status, error) {
                    console.error('Error loading categories:', error);
                    
                    // Fallback to default categories
                    categoriesData = [
                        { id: 1, name: 'Pengumuman' },
                        { id: 2, name: 'Acara' }
                    ];
                    
                    generateCategoryColumns();
                    buletinWithTop();
                }
            });
        };

        /**
         * Generate Category Columns Dynamically
         */
        const generateCategoryColumns = () => {
            const $categoriesContainer = $('#dynamic-categories');
            $categoriesContainer.empty();

            categoriesData.forEach((category, index) => {
                const categoryHtml = `
                    <div class="col-lg-5 border-start custom-border" data-category-id="${category.id}" data-category-name="${category.name.toLowerCase()}">
                        <div>
                            <h4 class="fw-bold">${category.name}</h4>
                        </div>
                    </div>
                `;
                $categoriesContainer.append(categoryHtml);
            });
        };

        /**
         * Carousel Buletin
         */
        const buletinCarousel = () => {
            $.ajax({
                url: '/v1/buletin',
                method: 'GET',
                dataType: 'json',
                success: function(result) {
                    if (!result.success) {
                        console.error('Failed to fetch buletin data:', result.message);
                        return;
                    }

                    const $swiperWrapper = $('#swiper-wrapper');
                    const carouselPosts = result.data.slice(0, 4); // limit 4 posts

                    $.each(carouselPosts, function(index, post) {
                        const backgroundImage = post.image_url ||
                            `assets/img/post-slide-${index + 1}.jpg`;

                        const slideHtml = `
                        <div class="swiper-slide" style="background-image: url('${backgroundImage}'); border-radius: 12px; overflow: hidden;">
                            <div class="content">
                                <h2><a href="/buletin/${post.slug}">${truncateText(post.title, 70)}</a></h2>
                                <p>${truncateText(post.content_preview, 120) || 'No preview available'}</p>
                            </div>
                        </div>
                    `;

                        $swiperWrapper.append(slideHtml);
                    });

                    // Reinit Swiper
                    const swiperConfig = JSON.parse($('.swiper-config').text());
                    new Swiper('.init-swiper', swiperConfig);
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching buletin data:', error);
                }
            });
        };

        /**
         * Truncate text to specified length
         */
        const truncateText = (text, maxLength = 100) => {
            if (!text) return '';
            if (text.length <= maxLength) return text;
            return text.substring(0, maxLength).trim() + '...';
        };

        /**
         * Buletin Featured (is_top) with Dynamic Categories
         */
        const buletinWithTop = () => {
            $.ajax({
                type: "GET",
                url: '/v1/buletin?is_top=1',
                dataType: "JSON",
                success: function(response) {
                    if (!response.success) {
                        console.error('Failed to fetch buletin data:', response.message);
                        return;
                    }

                    // Featured post
                    if (response.is_top && response.is_top.length > 0) {
                        const topPost = response.is_top[0];
                        const postDate = new Date(topPost.created_at).toLocaleDateString('en-US', {
                            month: 'short',
                            day: 'numeric',
                            year: '2-digit'
                        });

                        const featuredHtml = `
                        <a href="/buletin/${topPost.slug}">
                            <img src="${topPost.image_url || 'assets/img/post-landscape-1.jpg'}" 
                                 alt="" class="img-fluid" style="border-radius:12px">
                        </a>
                        <div class="post-meta">
                            <span class="date">${(topPost.category && topPost.category.name) || topPost.tags[0] || 'Featured'}</span>
                            <span class="mx-1">•</span>
                            <span>${postDate}</span>
                        </div>
                        <h2><a href="/buletin/${topPost.slug}">${truncateText(topPost.title, 60)}</a></h2>
                        <p class="mb-4 d-block">${truncateText(topPost.content_preview, 30)}</p>
                        <div class="d-flex align-items-center author">
                            <div class="photo">
                                <img src="assets/img/person-1.jpg" alt="" class="img-fluid">
                            </div>
                            <div class="name"><h3 class="m-0 p-0">Admin</h3></div>
                        </div>
                    `;

                        $('.col-lg-4 .post-entry.lg').html(featuredHtml);
                    }

                    // Populate dynamic categories
                    categoriesData.forEach((category, index) => {
                        const categoryName = category.name.toLowerCase();
                        const $categoryColumn = $(`[data-category-name="${categoryName}"]`);

                        // Clear existing posts
                        $categoryColumn.find('.post-entry').remove();

                        // Check if response has data for this category
                        if (response[categoryName] && response[categoryName].length > 0) {
                            $.each(response[categoryName], function(postIndex, post) {
                                const postDate = new Date(post.created_at).toLocaleDateString('en-US', {
                                    month: 'short',
                                    day: 'numeric',
                                    year: '2-digit'
                                });

                                const postHtml = `
                                <div class="post-entry">
                                    <a href="/buletin/${post.slug}">
                                        <img src="${post.image_url || `assets/img/post-landscape-${postIndex + 2}.jpg`}" 
                                             alt="" class="img-fluid" style="border-radius:12px">
                                    </a>
                                    <div class="post-meta">
                                        <span class="date">${(post.category && post.category.name) || category.name}</span>
                                        <span class="mx-1">•</span>
                                        <span>${postDate}</span>
                                    </div>
                                    <h2><a href="/buletin/${post.slug}">${truncateText(post.title, 50)}</a></h2>
                                    <p class="text-muted small">${truncateText(post.content_preview, 80)}</p>
                                </div>
                            `;

                                $categoryColumn.append(postHtml);
                            });
                        } else {
                            // No posts for this category
                            const noPostsHtml = `
                            <div class="post-entry">
                                <div class="alert alert-light" role="alert">
                                    <small class="text-muted">Belum ada ${category.name.toLowerCase()} terbaru</small>
                                </div>
                            </div>
                        `;
                            $categoryColumn.append(noPostsHtml);
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching buletin data:', error);
                }
            });
        };

        /**
         * Fetch prayer zones & init select2
         */
        const fetchPrayerZones = () => {
            $.ajax({
                type: "GET",
                url: "https://api.waktusolat.app/zones",
                dataType: "JSON",
                success: function(response) {
                    console.log("Prayer zones data:", response);

                    const $select = $('#prayer-zone-select');
                    $select.empty().append('<option value="">-- Pilih Zona --</option>');

                    // Group data by negeri
                    const groupedZones = {};
                    response.forEach(zone => {
                        if (!groupedZones[zone.negeri]) groupedZones[zone.negeri] = [];
                        groupedZones[zone.negeri].push(zone);
                    });

                    // Append optgroup
                    Object.keys(groupedZones).forEach(negeri => {
                        const $optgroup = $(`<optgroup label="${negeri}"></optgroup>`);
                        groupedZones[negeri].forEach(zone => {
                            $optgroup.append(
                                `<option value="${zone.jakimCode}">${zone.daerah}</option>`
                                );
                        });
                        $select.append($optgroup);
                    });

                    // Init select2
                    $select.select2({
                        placeholder: "Cari atau pilih zona",
                        allowClear: true,
                        width: '100%'
                    });

                    // On change
                    $select.on('change', function() {
                        const jakimCode = $(this).val();
                        if (jakimCode) {
                            const selectedZone = response.find(z => z.jakimCode === jakimCode);

                            localStorage.setItem('selectedPrayerZone', JSON.stringify(
                            selectedZone));
                            getPrayerTimeByZone(jakimCode);

                            console.log(
                                `Zona dipilih: ${selectedZone.negeri} - ${selectedZone.daerah}`);
                        }
                    });

                    // Auto-select saved or default zone
                    const savedZone = localStorage.getItem('selectedPrayerZone');
                    if (savedZone) {
                        const zone = JSON.parse(savedZone);
                        $select.val(zone.jakimCode).trigger('change');
                    } else {
                        const defaultZone = response.find(z => z.jakimCode === "SBH07"); // DEFAULT
                        if (defaultZone) {
                            $select.val(defaultZone.jakimCode).trigger('change');
                            localStorage.setItem('selectedPrayerZone', JSON.stringify(defaultZone));
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching prayer zones:", error);
                    $('#prayer-zone-select').html('<option value="">Gagal memuat data zona</option>');
                }
            });
        };

        /**
         * Fetch prayer times by zone
         */
        const getPrayerTimeByZone = (jakimCode) => {
            const currentYear = new Date().getFullYear();
            const currentMonth = new Date().getMonth() + 1;

            const url = `{{ env('BASE_URL_WAKTU_SHALAT') }}${jakimCode}?year=${currentYear}&month=${currentMonth}`;

            $.ajax({
                type: "GET",
                url: url,
                dataType: "JSON",
                success: function(res) {
                    const today = new Date().getDate();
                    const dataToday = res.prayers.find(p => p.day === today);

                    if (!dataToday) {
                        console.log("Data not found for today");
                        return;
                    }

                    // Format waktu
                    const formatTime = (unix) => {
                        const date = new Date(unix * 1000);
                        let hours = date.getHours();
                        const minutes = date.getMinutes().toString().padStart(2, '0');
                        const ampm = hours >= 12 ? "PM" : "AM";
                        hours = hours % 12 || 12;
                        return `${hours}:${minutes} <strong>${ampm}</strong>`;
                    };

                    // Mapping jadwal
                    const row = `
                    <tr>
                        <td class="text-success">${formatTime(dataToday.fajr - 600)}</td>
                        <td class="text-success">${formatTime(dataToday.fajr)}</td>
                        <td class="text-success">${formatTime(dataToday.dhuhr)}</td>
                        <td class="text-success">${formatTime(dataToday.asr)}</td>
                        <td class="text-success">${formatTime(dataToday.maghrib)}</td>
                        <td class="text-success">${formatTime(dataToday.isha)}</td>
                    </tr>
                `;

                    $("table tbody").html(row);

                    // Feedback visual
                    $("table").addClass('table-updated');
                    setTimeout(() => $("table").removeClass('table-updated'), 1000);
                },
                error: function(err) {
                    console.error("Error fetching prayer times for zone:", jakimCode, err);
                }
            });
        };
    </script>
@endpush