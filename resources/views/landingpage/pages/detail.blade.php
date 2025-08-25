@extends('landingpage.layout.app')
@push('style')
@endpush
@section('content')
   <div>
       <!-- Page Title -->
            <div class="page-title">
                <div class="container d-lg-flex justify-content-between align-items-center">
                    <h1 class="mb-2 mb-lg-0" style="cursor: pointer" onclick="window.location.href='/buletin'">Back</h1>
                    <nav class="breadcrumbs">
                        <ol>
                            <li><a href="/">Home</a></li>
                            <li class="current" id="breadcrumb-title">Single Post</li>
                        </ol>
                    </nav>
                </div>
            </div><!-- End Page Title -->

            <div class="container">
                <div class="row">

                    <div class="col-lg-8">

                        <!-- Blog Details Section -->
                        <section id="blog-details" class="blog-details section">
                            <div class="container">

                                <article class="article">

                                    <div class="post-img">
                                        <img id="blog-image" src="assets/img/blog/blog-1.jpg" alt="" class="img-fluid">
                                    </div>

                                    <h2 id="blog-title" class="title">Loading...</h2>

                                    <div class="meta-top">
                                        <ul>
                                            <li class="d-flex align-items-center">
                                                <i class="bi bi-clock"></i> 
                                                <a href="#"><time id="blog-date" datetime="">Loading...</time></a>
                                            </li>
                                        </ul>
                                    </div><!-- End meta top -->

                                    <div class="content">
                                        <div id="blog-content">
                                            <p>Loading content...</p>
                                        </div>
                                    </div><!-- End post content -->

                                </article>

                            </div>
                        </section><!-- /Blog Details Section -->

                    </div>

                    <div class="col-lg-4 sidebar">

                        <div class="widgets-container">
                            <!-- Tags Widget -->
                            <div class="tags-widget widget-item">

                                <h3 class="widget-title">Tags</h3>
                                <ul id="blog-tags">
                                    <li>Loading tags...</li>
                                </ul>

                            </div><!--/Tags Widget -->

                        </div>

                    </div>

                </div>
            </div>
   </div>
@endsection

@push('script')
<script>
    $(document).ready(function () {
        // Fungsi untuk mengambil slug dari URL
        function getSlugFromURL() {
            const currentURL = window.location.pathname;
            const segments = currentURL.split('/');
            // Mengambil segment terakhir sebagai slug
            return segments[segments.length - 1];
        }

        // Fungsi untuk mengkonversi content JSON ke HTML
        function convertQuillDeltaToHTML(deltaString) {
            try {
                const delta = JSON.parse(deltaString);
                let html = '';
                
                if (delta.ops) {
                    delta.ops.forEach(op => {
                        if (typeof op.insert === 'string') {
                            let text = op.insert;
                            
                            // Handle line breaks
                            text = text.replace(/\n/g, '<br>');
                            
                            // Handle formatting attributes
                            if (op.attributes) {
                                if (op.attributes.bold) {
                                    text = `<strong>${text}</strong>`;
                                }
                                if (op.attributes.italic) {
                                    text = `<em>${text}</em>`;
                                }
                                if (op.attributes.underline) {
                                    text = `<u>${text}</u>`;
                                }
                            }
                            
                            html += text;
                        }
                    });
                }
                
                // Wrap in paragraph tags and clean up
                html = '<p>' + html.replace(/<br><br>/g, '</p><p>').replace(/<br>/g, ' ') + '</p>';
                
                return html;
            } catch (e) {
                console.error('Error parsing content:', e);
                return '<p>Error loading content</p>';
            }
        }

        // Fungsi untuk memformat tanggal
        function formatDate(dateString) {
            const date = new Date(dateString);
            const options = { 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric' 
            };
            return date.toLocaleDateString('id-ID', options);
        }

        // Fungsi untuk truncate title
        function truncateTitle(title, maxLength = 50) {
            if (title.length <= maxLength) {
                return title;
            }
            return title.substring(0, maxLength).trim() + '...';
        }

        // Ambil slug dari URL
        const slug = getSlugFromURL();
        
        if (slug) {
            // AJAX request untuk mengambil data
            $.ajax({
                type: "GET",
                url: `/v1/buletin?slug=${slug}`,
                dataType: "JSON",
                success: function (response) {
                    console.log('API Response:', response);
                    
                    if (response.success && response.data) {
                        // Handle both array and object response
                        const blogData = Array.isArray(response.data) ? response.data[0] : response.data;
                        
                        // Update title
                        $('#blog-title').text(blogData.title);
                        document.title = blogData.title; // Update page title
                        
                        // Update breadcrumb with truncated title
                        const truncatedTitle = truncateTitle(blogData.title, 50);
                        $('#breadcrumb-title').text(truncatedTitle);
                        
                        // Update image
                        $('#blog-image').attr('src', blogData.image_url);
                        $('#blog-image').attr('alt', blogData.title);
                        
                        // Update date
                        const formattedDate = formatDate(blogData.created_at);
                        $('#blog-date').text(formattedDate);
                        $('#blog-date').attr('datetime', blogData.created_at);
                        
                        // Update content
                        const htmlContent = convertQuillDeltaToHTML(blogData.content);
                        $('#blog-content').html(htmlContent);
                        
                        // Update tags
                        let tagsHTML = '';
                        blogData.tags.forEach(tag => {
                            tagsHTML += `<li><a href="/buletin?tag=${encodeURIComponent(tag)}">${tag}</a></li>`;
                        });
                        $('#blog-tags').html(tagsHTML);
                        
                    } else {
                        // Handle case when no data found
                        $('#blog-title').text('Artikel Tidak Ditemukan');
                        $('#blog-content').html('<p>Maaf, artikel yang Anda cari tidak ditemukan.</p>');
                        $('#blog-tags').html('<li>No tags available</li>');
                    }
                },
                error: function (xhr, status, error) {
                    console.error('AJAX Error:', error);
                    console.error('Status:', status);
                    console.error('Response:', xhr.responseText);
                    
                    // Handle error
                    $('#blog-title').text('Error Loading Article');
                    $('#blog-content').html('<p>Terjadi kesalahan saat memuat artikel. Silakan coba lagi nanti.</p>');
                    $('#blog-tags').html('<li>Error loading tags</li>');
                },
                beforeSend: function() {
                    // Optional: Show loading indicator
                    console.log('Loading article...');
                },
                complete: function() {
                    // Optional: Hide loading indicator
                    console.log('Request completed');
                }
            });
        } else {
            // Handle case when slug is not found in URL
            $('#blog-title').text('URL Tidak Valid');
            $('#blog-content').html('<p>URL artikel tidak valid.</p>');
            $('#blog-tags').html('<li>No tags available</li>');
        }
    });
</script>
@endpush