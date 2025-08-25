@extends('landingpage.layout.app')
@push('style')
    <style>
        .post-img img {
            width: 100%;
            height: 250px;
            object-fit: cover;
        }

        /* Pagination Styles */
        #blog-pagination ul {
            display: flex;
            list-style: none;
            padding: 0;
            margin: 0;
            gap: 5px;
        }

        #blog-pagination ul li a {
            display: block;
            padding: 10px 15px;
            text-decoration: none;
            color: #333;
            border: 1px solid #ddd;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        #blog-pagination ul li a:hover {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
        }

        #blog-pagination ul li a.active {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
        }

        #blog-pagination ul li a.disabled {
            color: #6c757d;
            pointer-events: none;
            background-color: #f8f9fa;
            border-color: #dee2e6;
        }
    </style>
@endpush
@section('content')
    <div class="container">
        {{-- top content --}}
        <div class="blog-posts section" id="top-news-section">
            <article class="position-relative h-100">
                <div class="post-img position-relative overflow-hidden">
                    <img id="top-news-image" src="{{ asset('temp/assets/img/blog/blog-1.jpg') }}" class="img-fluid" alt="">
                    <span id="top-news-date" class="post-date">Loading...</span>
                </div>
            </article>
        </div>
        {{-- top content --}}
        <div class="row">
            <div class="col-lg-12">
                <!-- Blog Posts Section -->
                <section id="blog-posts" class="blog-posts section">
                    <div class="container">
                        <div class="row gy-4" id="buletin-container">
                            <!-- Konten dari Ajax -->
                        </div>
                    </div>
                </section>
                <section id="blog-pagination" class="blog-pagination section">
                    <div class="container">
                        <div class="d-flex justify-content-center">
                            <ul id="pagination-container">
                                <!-- Pagination akan diisi via JavaScript -->
                            </ul>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            let currentPage = 1;
            let totalPages = 1;
            const itemsPerPage = 6; // Sesuaikan dengan kebutuhan

            // Fungsi untuk format tanggal
            function formatDate(dateString, format = 'full') {
                const date = new Date(dateString);
                
                if (format === 'short') {
                    // Format untuk top news (Desember 12)
                    const options = { 
                        month: 'long', 
                        day: 'numeric' 
                    };
                    return date.toLocaleDateString('id-ID', options);
                } else {
                    // Format lengkap untuk artikel list
                    const options = {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    };
                    return date.toLocaleDateString('id-ID', options);
                }
            }

            // Fungsi untuk update top news
            function updateTopNews(topArticle) {
                if (topArticle) {
                    $('#top-news-image').attr('src', topArticle.image_url);
                    $('#top-news-image').attr('alt', topArticle.title);
                    $('#top-news-date').text(formatDate(topArticle.created_at, 'short'));
                    
                    // Make top news clickable
                    $('#top-news-section article').css('cursor', 'pointer');
                    $('#top-news-section article').off('click').on('click', function() {
                        window.location.href = `/buletin/${topArticle.slug}`;
                    });
                } else {
                    // Hide top news section if no data
                    $('#top-news-section').hide();
                }
            }

            // Fungsi untuk load data buletin
            function loadBuletin(page = 1) {
                $.ajax({
                    type: "GET",
                    url: `/v1/buletin?page=${page}&per_page=${itemsPerPage}`,
                    dataType: "JSON",
                    beforeSend: function() {
                        $('#buletin-container').html(
                            '<div class="text-center"><p>Loading...</p></div>');
                    },
                    success: function(response) {
                        if (response.success && response.data.length > 0) {
                            // Update top news dengan artikel pertama (hanya di halaman pertama)
                            if (page === 1) {
                                updateTopNews(response.data[0]);
                            }

                            let html = '';
                            // Skip artikel pertama di halaman pertama karena sudah ditampilkan di top news
                            const startIndex = (page === 1) ? 1 : 0;
                            
                            for (let i = startIndex; i < response.data.length; i++) {
                                const item = response.data[i];
                                let dateFormatted = formatDate(item.created_at);

                                // Buat HTML tag list
                                let tagsHtml = '';
                                if (item.tags && item.tags.length > 0) {
                                    item.tags.forEach(function(tag, index) {
                                        tagsHtml += `
                                            <div class="d-flex align-items-center">
                                                <span class="ps-1"># ${tag}</span>
                                            </div>
                                        `;
                                        if (index < item.tags.length - 1) {
                                            tagsHtml +=
                                                `<span class="px-1 text-black-50">/</span>`;
                                        }
                                    });
                                }

                                html += `
                                    <div class="col-lg-6">
                                        <article class="position-relative h-100">
                                            <div class="post-img position-relative overflow-hidden">
                                                <img src="${item.image_url}" class="img-fluid" alt="${item.title}">
                                                <span class="post-date">${dateFormatted}</span>
                                            </div>
                                            <div class="post-content d-flex flex-column">
                                                <h3 class="post-title">${item.title}</h3>
                                                <p>${item.content_preview}</p>
                                                <div class="meta d-flex align-items-center">
                                                    ${tagsHtml}
                                                </div>
                                                <hr>
                                                <a href="/buletin/${item.slug}" class="readmore stretched-link">
                                                    <span>Baca Selengkapnya</span><i class="bi bi-arrow-right"></i>
                                                </a>
                                            </div>
                                        </article>
                                    </div>
                                `;
                            }
                            
                            $('#buletin-container').html(html);

                            // Update pagination info
                            currentPage = response.current_page || page;
                            totalPages = response.total_pages || Math.ceil(response.total / itemsPerPage);

                            // Generate pagination
                            generatePagination();

                        } else {
                            $('#buletin-container').html(
                                '<div class="col-12"><p class="text-center">Tidak ada buletin tersedia.</p></div>'
                            );
                            $('#pagination-container').html('');
                            $('#top-news-section').hide();
                        }
                    },
                    error: function() {
                        $('#buletin-container').html(
                            '<div class="col-12"><p class="text-center text-danger">Gagal memuat data buletin.</p></div>'
                        );
                        $('#pagination-container').html('');
                        $('#top-news-section').hide();
                    }
                });
            }

            // Fungsi untuk generate pagination
            function generatePagination() {
                if (totalPages <= 1) {
                    $('#pagination-container').html('');
                    return;
                }

                let paginationHtml = '';

                // Previous button
                if (currentPage > 1) {
                    paginationHtml +=
                        `<li><a href="#" data-page="${currentPage - 1}"><i class="bi bi-chevron-left"></i></a></li>`;
                } else {
                    paginationHtml +=
                        `<li><a href="#" class="disabled"><i class="bi bi-chevron-left"></i></a></li>`;
                }

                // Page numbers
                let startPage = Math.max(1, currentPage - 2);
                let endPage = Math.min(totalPages, currentPage + 2);

                // Show first page if not in range
                if (startPage > 1) {
                    paginationHtml += `<li><a href="#" data-page="1">1</a></li>`;
                    if (startPage > 2) {
                        paginationHtml += `<li><a href="#" class="disabled">...</a></li>`;
                    }
                }

                // Page number links
                for (let i = startPage; i <= endPage; i++) {
                    if (i === currentPage) {
                        paginationHtml += `<li><a href="#" class="active" data-page="${i}">${i}</a></li>`;
                    } else {
                        paginationHtml += `<li><a href="#" data-page="${i}">${i}</a></li>`;
                    }
                }

                // Show last page if not in range
                if (endPage < totalPages) {
                    if (endPage < totalPages - 1) {
                        paginationHtml += `<li><a href="#" class="disabled">...</a></li>`;
                    }
                    paginationHtml += `<li><a href="#" data-page="${totalPages}">${totalPages}</a></li>`;
                }

                // Next button
                if (currentPage < totalPages) {
                    paginationHtml +=
                        `<li><a href="#" data-page="${currentPage + 1}"><i class="bi bi-chevron-right"></i></a></li>`;
                } else {
                    paginationHtml +=
                        `<li><a href="#" class="disabled"><i class="bi bi-chevron-right"></i></a></li>`;
                }

                $('#pagination-container').html(paginationHtml);
            }

            // Event handler untuk pagination
            $(document).on('click', '#pagination-container a', function(e) {
                e.preventDefault();

                if ($(this).hasClass('disabled') || $(this).hasClass('active')) {
                    return;
                }

                const page = $(this).data('page');
                if (page) {
                    loadBuletin(page);

                    // Scroll to top of blog section
                    $('html, body').animate({
                        scrollTop: $('#blog-posts').offset().top - 100
                    }, 500);
                }
            });

            // Load data pertama kali
            loadBuletin(1);
        });
    </script>
@endpush