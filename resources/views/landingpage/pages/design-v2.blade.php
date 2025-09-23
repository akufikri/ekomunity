<!DOCTYPE html>
<html lang="en" data-theme="winter">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>eKomuniti - Satu platform, Semua komuniti</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5/themes.css" rel="stylesheet" type="text/css" />
</head>

<body class="bg-grey-100">
    {{-- start: navbar --}}
    <div class="navbar bg-base-100 justify-between pe-4">
        <div class="flex items-center justify-between w-full max-w-[1080px] mx-auto">
            <div class="flex items-center">
                <div class="flex-1">
                    <a href="/" class="btn btn-ghost text-xl w-14 h-14 overflow-hidden rounded-2xl shadow-sm p-0">
                        <img src="{{ asset('landingpage/images/logo/logo-ekomuniti.png') }}"
                            alt="Satu platform, Semua komuniti" class="w-full h-full object-contain" />

                    </a>
                </div>
                <div class="flex-none">
                    <ul class="menu menu-horizontal px-1">
                        <li><a>Laman Utama</a></li>
                        <li><a>News</a></li>
                    </ul>
                </div>
            </div>
            <div>
                <a href="/register_company/select_package"
                    class="btn btn-primary bg-[#1569a0] text-white border-none">Masuk</a>
            </div>
        </div>
    </div>

    {{-- start: hero section --}}
    <div
        class="w-full h-[60vh] md:h-[70vh] from-[#1569a0] via-[#1569a0]/90 to-transparent bg-gradient-to-r px-4 py-8 md:py-12">
        <div class="flex items-center justify-between h-full max-w-[1080px] mx-auto gap-8">
            <!-- Konten Teks -->
            <div class="max-w-lg md:max-w-2xl space-y-6 text-center md:text-left">
                <h1 class="text-white font-bold text-3xl sm:text-4xl md:text-5xl leading-tight">
                    Urus Keahlian Lebih Mudah, Semua Dalam Satu Platform
                </h1>
                <p class="text-white text-sm sm:text-base opacity-90">
                    Satu platform digital untuk persatuan & komuniti mengurus ahli, aktiviti, dan komunikasi dengan
                    lebih teratur.
                </p>
                <a href="/register_company/select_package"
                    class="btn bg-yellow-500 text-white border-none shadow-lg hover:scale-105 transition-transform mx-auto md:mx-0">
                    Bina komuniti anda sekarang
                </a>
            </div>

            <!-- Tempat untuk ilustrasi (opsional, bisa diaktifkan nanti) -->
            <!--
    <div class="hidden md:block flex-1">
      <img src="{{ asset('images/hero-illustration.svg') }}" alt="Hero Illustration" class="w-full h-auto max-w-xs ml-auto">
    </div>
    -->
        </div>
    </div>

    {{-- start : feature --}}
    <div class="max-w-[1080px] w-full mx-auto flex lg:flex-row flex-col items-center justify-between gap-8 pt-[28px]">
        <div class="grid lg:grid-cols-2 w-full gap-3 max-w-xl">
            <!-- 1 -->
            <div class="card card-border bg-[#1569a0]">
                <div class="card-body">
                    <div class="flex justify-between w-full gap-4">
                        <div>
                            <div class="badge bg-yellow-500 border-none w-8 h-8 font-semibold text-white">
                                1
                            </div>
                        </div>
                        <div class="space-y-2">
                            <h2 class="font-bold text-white">Pengurusan Keahlian yang Mudah</h2>
                            <p class="text-[12px] text-white">
                                Jejak dan urus ahli persatuan/komuniti dengan sistem teratur. Daftar, semak status &
                                maklumat ahli dalam satu tempat.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2 -->
            <div class="relative p-6 rounded-2xl border border-[#1569a0] shadow-md bg-white">
                <div class="absolute top-2 right-0 left-2 w-full h-full bg-blue-50 rounded-2xl -z-10"></div>
                <div class="flex gap-4">
                    <div>
                        <div
                            class="flex items-center justify-center w-10 h-10 rounded-full bg-[#1569a0] text-white font-bold text-xl">
                            2
                        </div>
                    </div>
                    <div class="space-y-2">
                        <h2 class="font-bold text-[#1569a0] text-lg">
                            Bayaran Yuran & Sumbangan Lebih Lancar
                        </h2>
                        <p class="text-gray-600 text-sm">
                            Sokongan pembayaran digital untuk yuran ahli, derma & tabungan komuniti – lebih cepat,
                            selamat dan telus.
                        </p>
                    </div>
                </div>
            </div>

            <!-- 3 -->
            <div class="relative p-6 rounded-2xl border border-[#1569a0] shadow-md bg-white">
                <div class="absolute top-2 right-0 left-2 w-full h-full bg-blue-50 rounded-2xl -z-10"></div>
                <div class="flex gap-4">
                    <div>
                        <div
                            class="flex items-center justify-center w-10 h-10 rounded-full bg-[#1569a0] text-white font-bold text-xl">
                            3
                        </div>
                    </div>
                    <div class="space-y-2">
                        <h2 class="font-bold text-[#1569a0] text-lg">
                            Komunikasi & Pengumuman Pantas
                        </h2>
                        <p class="text-gray-600 text-sm">
                            Sampaikan berita, notis & aktiviti terus kepada ahli tanpa perlu group WhatsApp berselerak.
                        </p>
                    </div>
                </div>
            </div>

            <!-- 4 -->
            <div class="relative p-6 rounded-2xl border border-[#1569a0] shadow-md bg-white">
                <div class="absolute top-2 right-0 left-2 w-full h-full bg-blue-50 rounded-2xl -z-10"></div>
                <div class="flex gap-4">
                    <div>
                        <div
                            class="flex items-center justify-center w-10 h-10 rounded-full bg-[#1569a0] text-white font-bold text-xl">
                            4
                        </div>
                    </div>
                    <div class="space-y-2">
                        <h2 class="font-bold text-[#1569a0] text-lg">
                            Rekod Aktiviti & Laporan Automatik
                        </h2>
                        <p class="text-gray-600 text-sm">
                            Rekod mesyuarat, acara & laporan persatuan disimpan secara digital – mudah dicapai bila
                            diperlukan.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <img src="{{ asset('images/ic-lg-box.png') }}" alt="">
        </div>
    </div>
    {{-- end : feature --}}

    {{-- start: cta --}}
    <div class="lg:max-w-[1080px] mx-auto mt-[28px]">
        <div class="card card-border bg-[#1569a0] overflow-hidden lg:h-[50vh] h-36">
            <div class="card-body lg:overflow-hidden">
                <div class="lg:grid hidden grid-cols-3 gap-10">
                    <div class="grid grid-cols-1 gap-4 rotate-10 -translate-x-40 -translate-y-72">
                        <div class="card rounded-none bg-white opacity-40 border-0 h-[340px] w-[290px]">
                            <div class="card-body"></div>
                        </div>
                        <div class="card rounded-none bg-white opacity-40 border-0 h-[340px] w-[290px]">
                            <div class="card-body"></div>
                        </div>
                        <div class="card rounded-none bg-white opacity-40 border-0 h-[340px] w-[290px]">
                            <div class="card-body"></div>
                        </div>
                        <div class="card rounded-none bg-white opacity-40 border-0 h-[340px] w-[290px]">
                            <div class="card-body"></div>
                        </div>
                        <div class="card rounded-none bg-white opacity-40 border-0 h-[340px] w-[290px]">
                            <div class="card-body"></div>
                        </div>
                        <div class="card rounded-none bg-white opacity-40 border-0 h-[340px] w-[290px]">
                            <div class="card-body"></div>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 gap-4 rotate-10 -translate-x-40 -translate-y-80">
                        <div class="card rounded-none bg-white opacity-40 border-0 h-[340px] w-[290px]">
                            <div class="card-body"></div>
                        </div>
                        <div class="card rounded-none bg-white opacity-40 border-0 h-[340px] w-[290px]">
                            <div class="card-body"></div>
                        </div>
                        <div class="card rounded-none bg-white opacity-40 border-0 h-[340px] w-[290px]">
                            <div class="card-body"></div>
                        </div>
                        <div class="card rounded-none bg-white opacity-40 border-0 h-[340px] w-[290px]">
                            <div class="card-body"></div>
                        </div>
                        <div class="card rounded-none bg-white opacity-40 border-0 h-[340px] w-[290px]">
                            <div class="card-body"></div>
                        </div>
                        <div class="card rounded-none bg-white opacity-40 border-0 h-[340px] w-[290px]">
                            <div class="card-body"></div>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 gap-4 rotate-10 -translate-x-40 -translate-y-64">
                        <div class="card rounded-none bg-white opacity-40 border-0 h-[340px] w-[290px]">
                            <div class="card-body"></div>
                        </div>
                        <div class="card rounded-none bg-white opacity-40 border-0 h-[340px] w-[290px]">
                            <div class="card-body"></div>
                        </div>
                        <div class="card rounded-none bg-white opacity-40 border-0 h-[340px] w-[290px]">
                            <div class="card-body"></div>
                        </div>
                        <div class="card rounded-none bg-white opacity-40 border-0 h-[340px] w-[290px]">
                            <div class="card-body"></div>
                        </div>
                        <div class="card rounded-none bg-white opacity-40 border-0 h-[340px] w-[290px]">
                            <div class="card-body"></div>
                        </div>
                        <div class="card rounded-none bg-white opacity-40 border-0 h-[340px] w-[290px]">
                            <div class="card-body"></div>
                        </div>
                    </div>
                </div>
                {{-- content --}}
                <div class="lg:absolute z-10 w-full h-full">
                    <div class="text-center flex items-center justify-center h-full flex-col gap-4">
                        <h1 class="text-2xl font-bold text-white">Pelancaran Ekomunity</h1>
                        <div class="btn bg-[#1569a0] border-0 text-white shadow-lg hover:scale-110 transition-all">
                            Gabung sekarang</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- start : blog --}}
    <div class="lg:max-w-[1080px] mx-auto mt-[28px]">
        <h1 class="text-2xl font-bold text-center">Berita terbaru</h1>
        <div id="blog-container" class="mt-5 grid lg:grid-cols-3 grid-cols-2 gap-4">
            <!-- Blog posts akan dimasukkan disini melalui JavaScript -->
        </div>
        <div class="mt-5 w-full flex items-center justify-center">
            <button class="btn bg-[#1569a0] text-white border-0">Read More</button>
        </div>


    </div>
    {{-- start: price --}}
    <div class="bg-[#1569a0]">
        <div
            class="lg:max-w-[1080px] w-full mx-auto gap-4 h-auto items-center flex flex-col justify-center mt-[28px] h-[50vh] p-5">
            <h1 class="font-bold text-2xl text-white">Bergabung dengan kami secara Percuma!</h1>

            <div id="packages-container" class="flex lg:flex-row flex-col items-center gap-10 w-full h-full relative">
                <!-- Card akan diinject disini -->
            </div>
        </div>
    </div>

    {{-- start : about us --}}
    <div class="max-w-[1080px] w-full mx-auto gap-4 h-auto items-center flex flex-col justify-center mt-12">
        <h1 class="text-2xl font-bold text-center">Kenapa harus kami? (FAQ)</h1>
        <div class="grid lg:grid-cols-3 md:grid-cols-2 gap-3 w-full">

            <!-- Card 1 -->
            <div class="card border-none">
                <div class="card-body flex flex-col items-center justify-center">
                    <div class="flex items-center justify-center w-20 h-20 rounded-full bg-blue-100">
                        <i data-lucide="users" class="w-10 h-10 text-blue-600"></i>
                    </div>
                    <div class="mt-2 text-center space-y-4">
                        <h1 class="text-base font-bold">Adakah platform ini sesuai untuk semua jenis persatuan &
                            komuniti?</h1>
                        <p class="text-[12px]">
                            Ya, <a href="https://ekomuniti.my" class="underline font-bold">ekomuniti.my</a>
                            direka fleksibel untuk pelbagai jenis komuniti – sama ada persatuan, NGO, koperasi,
                            kelab sukan, alumni atau komuniti kejiranan.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="card border-none">
                <div class="card-body flex flex-col items-center justify-center">
                    <div class="flex items-center justify-center w-20 h-20 rounded-full bg-green-100">
                        <i data-lucide="layers" class="w-10 h-10 text-green-600"></i>
                    </div>
                    <div class="mt-2 text-center space-y-4">
                        <h1 class="text-base font-bold">
                            Apa kelebihan utama menggunakan <a href="https://ekomuniti.my"
                                class="underline">ekomuniti.my</a>?
                        </h1>
                        <p class="text-[12px]">
                            Semua urusan keahlian, bayaran yuran, pengumuman & rekod aktiviti boleh diurus
                            dalam satu platform. Lebih mudah, telus, dan profesional.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="card border-none">
                <div class="card-body flex flex-col items-center justify-center">
                    <div class="flex items-center justify-center w-20 h-20 rounded-full bg-blue-50">
                        <i data-lucide="credit-card" class="w-10 h-10 text-blue-600"></i>
                    </div>
                    <div class="mt-2 text-center space-y-4">
                        <h1 class="text-base font-bold">Bolehkah ahli membuat bayaran yuran secara online?</h1>
                        <p class="text-[12px]">
                            Boleh. Sistem kami menyokong pembayaran digital supaya ahli boleh membayar
                            yuran atau sumbangan terus melalui platform dengan selamat menggunakan tetapan
                            gerbang pembayaran anda.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
    {{-- end : about us --}}

    {{-- start: testimoni --}}
    <div class="bg-[#1569a0] py-8">
        <div class="max-w-[1080px] w-full mx-auto gap-4 h-auto items-center flex flex-col justify-center">
            <h1 class="text-2xl font-bold text-center text-white">Rakan Strategik</h1>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 w-full">
                <!-- Logo 1 -->
                <div class="card border-none">
                    <div class="card-body flex flex-col items-center justify-center">
                        <div class="w-32 h-20 flex items-center justify-center">
                            <img src="https://datappk.com/assets/images/logo/g3pns.png" alt="G3PNS"
                                class="max-w-full max-h-full object-contain" />
                        </div>
                        <h1 class="font-semibold text-white text-[16px]">G3PNS</h1>
                    </div>
                </div>

                <!-- Logo 2 -->
                <div class="card border-none">
                    <div class="card-body flex flex-col items-center justify-center">
                        <div class="w-32 h-20 flex items-center justify-center">
                            <img src="https://datappk.com/assets/images/logo/coedev.png" alt="Coedev"
                                class="max-w-full max-h-full object-contain" />
                        </div>
                        <h1 class="font-semibold text-white text-[16px]">Coedev Technology</h1>
                    </div>
                </div>

                <!-- Logo 3 -->
                <div class="card border-none">
                    <div class="card-body flex flex-col items-center justify-center">
                        <div class="w-32 h-20 flex items-center justify-center">
                            <img src="https://amalprihatinsabah.com/assets/icon-paks/logo-aps.png"
                                alt="Amal Prihatin Sabah" class="max-w-full max-h-full object-contain" />
                        </div>
                        <h1 class="font-semibold text-white text-[16px]">Amalprihatin Sabah</h1>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <footer class="mt-[28px]">
        {{-- start : footer top --}}
        <div class="flex items-center justify-center flex-col max-w-[500px] w-full mx-auto">
            <div class="flex items-center justify-center gap-4">
                <div class="avatar">
                    <div class="w-24 rounded-full bg-gray-200 flex items-center justify-center">
                        <img src="{{ asset('landingpage/images/logo/logo-ekomuniti.png') }}"
                            class="w-full h-full object-contain rounded-full" />
                    </div>
                </div>
                <span class="text-2xl font-bold">Ekomuniti</span>
            </div>
            <ul class="flex items-center gap-2 mt-5 font-bold text-[#1569a0] w-full justify-center">
                <li><a href="">Polisi Privasi</a></li>
                <li><a href="">Terma & Syarat</a></li>
                <li><a href="">Penghapusan Akaun</a></li>
            </ul>
            <div class="flex items-center justify-center gap-5 w-full mt-4">
                <a href="" class="flex gap-2 items-center text-[#1569a0]"><i data-lucide="mail"
                        class="w-5 h-5"></i> <span>john@example.com</span></a>
                <a href="" class="flex gap-2 items-center text-[#1569a0]"><i data-lucide="phone"
                        class="w-5 h-5"></i> <span>john@example.com</span></a>
            </div>
        </div>
        {{-- start: footer center --}}
        <div class="flex mt-5 justify-between w-full">
            <div class="card bg-[#1569a0] max-w-2xl rounded-none w-full h-20 rounded-tr-2xl">
                <div class="card-body"></div>
            </div>
            <div class="w-full max-w-sm h-full h-24">
                <ul class="flex items-center justify-center justify-center mt-5 gap-10">
                    <li class="bg-[#1569a0] p-3 rounded-2xl text-white">
                        <a href=""><i data-lucide="facebook"></i></a>
                    </li>
                    <li class="bg-[#1569a0] p-3 rounded-2xl text-white">
                        <a href=""><i data-lucide="twitter"></i></a>
                    </li>
                    <li class="bg-[#1569a0] p-3 rounded-2xl text-white">
                        <a href=""><i data-lucide="linkedin"></i></a>
                    </li>
                    <li class="bg-[#1569a0] p-3 rounded-2xl text-white">
                        <a href=""><i data-lucide="instagram"></i></a>
                    </li>
                </ul>
            </div>
            <div class="card bg-[#1569a0] max-w-2xl rounded-none w-full h-20 rounded-tl-2xl">
                <div class="card-body"></div>
            </div>
        </div>
        {{-- start : footer bottom --}}
        <div class="bg-[#1569a0] w-full py-10 flex items-center justify-center">
            <h1 class="text-base text-white font-semibold">©Ekomuniti. Dimiliki oleh Coedev Technology Sdn Bhd</h1>
        </div>
    </footer>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        $(document).ready(function() {
            lucide.createIcons();
            const baseUrl = "https://coedevtechnology.com/api/public/blogpost?brand_name=ekomuniti&page=1";

            // fetch blog posts
            $.ajax({
                type: "GET",
                url: baseUrl,
                dataType: "JSON",
                success: function(response) {
                    if (response.success && response.data && response.data.length > 0) {
                        let posts = response.data.slice(0, 6); // limit to 6 posts
                        let blogHtml = '';

                        posts.forEach(post => {
                            // extract text content from HTML
                            let textContent = $('<div>').html(post.post_content).text();
                            let excerpt = textContent.length > 100 ? textContent.substring(0,
                                100) + '...' : textContent;

                            // format date
                            let publishedDate = new Date(post.published_at).toLocaleDateString(
                                'ms-MY', {
                                    year: 'numeric',
                                    month: 'long',
                                    day: 'numeric'
                                });

                            blogHtml += `
                                <div class="card bg-base-100 shadow-sm">
                                    <figure>
                                        <img src="${post.thumbnail}" alt="${post.post_title}"
                                             class="w-full h-48 object-cover" />
                                    </figure>
                                    <div class="card-body">
                                        <h2 class="card-title">
                                            ${post.post_title}
                                            <div class="badge badge-secondary">NEW</div>
                                        </h2>
                                        <p class="text-sm text-gray-600">${excerpt}</p>
                                        <div class="card-actions justify-between items-center mt-3">
                                            <div class="badge badge-outline">${post.category.category_name}</div>
                                            <div class="text-xs text-gray-500">${publishedDate}</div>
                                        </div>
                                    </div>
                                </div>
                            `;
                        });

                        $("#blog-container").html(blogHtml);
                    } else {
                        // show no data message
                        $("#blog-container").html(`
                            <div class="col-span-full">
                                <div class="card bg-white shadow border border-gray-100 mt-5">
                                    <div class="card-body items-center space-y-2">
                                        <div class="flex items-center justify-center w-20 h-20 rounded-full bg-blue-100">
                                            <i data-lucide="newspaper" class="w-10 h-10 text-blue-600"></i>
                                        </div>
                                        <h1 class="card-title text-center">Opss! News Not Found</h1>
                                    </div>
                                </div>
                            </div>
                        `);
                        lucide.createIcons();
                    }
                },
                error: function() {
                    // show error message
                    $("#blog-container").html(`
                        <div class="col-span-full">
                            <div class="card bg-white shadow border border-gray-100 mt-5">
                                <div class="card-body items-center space-y-2">
                                    <div class="flex items-center justify-center w-20 h-20 rounded-full bg-blue-100">
                                        <i data-lucide="newspaper" class="w-10 h-10 text-blue-600"></i>
                                    </div>
                                    <h1 class="card-title text-center">Opss! News Not Found</h1>
                                </div>
                            </div>
                        </div>
                    `);
                    lucide.createIcons();
                }
            });

            // ambil data dari API packages
            $.ajax({
                type: "GET",
                url: "/packages/getData",
                dataType: "JSON",
                success: function(res) {
                    if (res.success) {
                        let packages = res.data;
                        let html = '';

                        packages.forEach((pkg, index) => {
                            // format harga
                            let priceText = pkg.price == 0 ? "FREE!" : `RM ${pkg.price}`;

                            // render benefit
                            let benefitHtml = '';
                            pkg.benefit.forEach(b => {
                                benefitHtml += `
                                <li class="flex items-center gap-2">
                                    <i data-lucide="${b.is_include ? 'circle-check' : 'circle-x'}" 
                                       class="w-5 h-5 ${b.is_include ? 'text-green-500' : 'text-red-500'}"></i>
                                    <span class="font-semibold text-base">${b.name}</span>
                                </li>
                            `;
                            });

                            // render card
                            html += `
                            <div class="card card-border bg-white max-w-[513px] w-full h-[402px] transition-all duration-500 ease-in-out ${index === 0 ? 'card-left' : (index === 1 ? 'card-center' : 'card-right')}">
                                <div class="card-body">
                                    <span class="font-semibold">${pkg.title}</span>
                                    <h1 class="card-title text-4xl">${priceText}</h1>
                                    <ul class="space-y-1 pt-1">
                                        ${benefitHtml}
                                    </ul>
                                </div>
                                <div class="card-footer px-5 justify-start items-center flex py-4">
                                    <button class="btn bg-[#1569a0] text-white text-base shadow">
                                        ${pkg.is_premium ? 'Upgrade Sekarang' : 'Gabung Sekarang'}
                                    </button>
                                </div>
                            </div>
                        `;
                        });

                        $("#packages-container").html(html);

                        // re-init icon
                        lucide.createIcons();

                        // logic animasi card (kiri, tengah, kanan)
                        const $left = $('.card-left');
                        const $center = $('.card-center');
                        const $right = $('.card-right');

                        function updateCards() {
                            $left.removeClass('opacity-80 mt-10').addClass('opacity-80 mt-10');
                            $center.removeClass('opacity-80 mt-10');
                            $right.removeClass('opacity-80 mt-10').addClass('opacity-80 mt-10');

                            $left.css('order', 0);
                            $center.css('order', 1);
                            $right.css('order', 2);
                        }
                        updateCards();

                        $left.on('click', function() {
                            $left.css('order', 1);
                            $center.css('order', 0);
                            $right.css('order', 2);

                            $left.removeClass('opacity-80 mt-10');
                            $center.addClass('opacity-80 mt-10');
                            $right.addClass('opacity-80 mt-10');
                        });

                        $right.on('click', function() {
                            $right.css('order', 1);
                            $center.css('order', 2);
                            $left.css('order', 0);

                            $right.removeClass('opacity-80 mt-10');
                            $center.addClass('opacity-80 mt-10');
                            $left.addClass('opacity-80 mt-10');
                        });

                        $center.on('click', function() {
                            updateCards();
                        });
                    }
                }
            });
        });
    </script>
</body>

</html>
