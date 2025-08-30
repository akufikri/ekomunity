<!DOCTYPE html>
<html lang="en" data-theme="winter">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Landing v2</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5/themes.css" rel="stylesheet" type="text/css" />
</head>

<body class="bg-grey-100">
    {{-- start: navbar --}}
    <div class="navbar bg-base-100 justify-between pe-4">
        <div class="flex items-center justify-between w-full max-w-[1080px] mx-auto">
            <div class="flex items-center">
                <div class="flex-1">
                    <a class="btn btn-ghost text-xl">Ekomuniti</a>
                </div>
                <div class="flex-none">
                    <ul class="menu menu-horizontal px-1">
                        <li><a>Laman Utama</a></li>
                        <li><a>News</a></li>
                    </ul>
                </div>
            </div>
            <div>
                <button class="btn btn-primary bg-[#1569a0] text-white border-none">Masuk</button>
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
                    Solusi Mudah untuk Penjaja dan Peniaga Kecil
                </h1>
                <p class="text-white text-sm sm:text-base opacity-90">
                    DATAPPK BIZ direka khas untuk membantu penjaja dan peniaga kecil menguruskan
                    perniagaan mereka dengan lebih mudah dan efisien.
                </p>
                <button
                    class="btn bg-yellow-500 text-white border-none shadow-lg hover:scale-105 transition-transform mx-auto md:mx-0">
                    Get started
                </button>
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
            <div class="card card-border bg-[#1569a0]">
                <div class="card-body">
                    <div class="flex justify-between w-full gap-4">
                        <div>
                            <div class="badge bg-yellow-500 border-none w-8 h-8 font-semibold text-white">
                                1
                            </div>
                        </div>
                        <div class="space-y-2">
                            <h2 class="font-bold text-white">Pengurusan Produk yang mudah</h2>
                            <p class="text-[12px] text-white">Jejak produk anda mengikut kategori bersesuaian untuk
                                pengurusan yang kemas, pastikan
                                stok sentiasa tersedia</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="relative p-6 rounded-2xl border border-pink-200 shadow-md bg-white">
                <!-- Efek bayangan 3D di kanan bawah -->
                <div class="absolute top-2 right-0 left-2 w-full h-full bg-pink-100 rounded-2xl -z-10"></div>

                <div class="flex gap-4">
                    <!-- Nomor bulat -->
                    <div>
                        <div
                            class="flex items-center justify-center w-10 h-10 rounded-full bg-pink-200 text-pink-700 font-bold text-xl">
                            2
                        </div>
                    </div>

                    <!-- Isi konten -->
                    <div class="space-y-2">
                        <h2 class="font-bold text-pink-700 text-lg">
                            Buat Transaksi dengan Cepat dan Tepat
                        </h2>
                        <p class="text-gray-600 text-sm">
                            Jana resit, sebutharga, dan invois secara teratur, menjimatkan masa dan
                            mengurangkan kesilapan
                        </p>
                    </div>
                </div>
            </div>
            <div class="relative p-6 rounded-2xl border border-pink-200 shadow-md bg-white">
                <!-- Efek bayangan 3D di kanan bawah -->
                <div class="absolute top-2 right-0 left-2 w-full h-full bg-pink-100 rounded-2xl -z-10"></div>

                <div class="flex gap-4">
                    <!-- Nomor bulat -->
                    <div>
                        <div
                            class="flex items-center justify-center w-10 h-10 rounded-full bg-pink-200 text-pink-700 font-bold text-xl">
                            3
                        </div>
                    </div>

                    <!-- Isi konten -->
                    <div class="space-y-2">
                        <h2 class="font-bold text-pink-700 text-lg">
                            Simpan Maklumat Pelanggan Sebagai Sumber Rujukan
                        </h2>
                        <p class="text-gray-600 text-sm">
                            Penyimpanan data pelanggan yang teratur, memudahkan urusan perniagaan dan penjanaan laporan
                            yang lebih telus
                        </p>
                    </div>
                </div>
            </div>
            <div class="relative p-6 rounded-2xl border border-pink-200 shadow-md bg-white">
                <!-- Efek bayangan 3D di kanan bawah -->
                <div class="absolute top-2 right-0 left-2 w-full h-full bg-pink-100 rounded-2xl -z-10"></div>

                <div class="flex gap-4">
                    <!-- Nomor bulat -->
                    <div>
                        <div
                            class="flex items-center justify-center w-10 h-10 rounded-full bg-pink-200 text-pink-700 font-bold text-xl">
                            4
                        </div>
                    </div>

                    <!-- Isi konten -->
                    <div class="space-y-2">
                        <h2 class="font-bold text-pink-700 text-lg">
                            Mari merekod transaksi Perniagaan anda
                        </h2>
                        <p class="text-gray-600 text-sm">
                            Jadi usahawan yang berjaya mengikut sasaran anda. Selamat penggunakan Aplikasi DATAPPK BIZ
                        </p>
                    </div>
                </div>
            </div>


        </div>
        <div>
            <img src="{{ asset('images/ic-lg-box.svg') }}" alt="">
        </div>
    </div>

    {{-- start: cta --}}
    <div class="lg:max-w-[1080px] mx-auto mt-[28px]">
        <div class="card card-border bg-pink-500 overflow-hidden lg:h-[50vh] h-36">
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
                        <h1 class="text-2xl font-bold text-white">Pelancaran DATAPPK.Biz</h1>
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
        <div class="mt-5 grid lg:grid-cols-3 grid-cols-2 gap-4">
            <div class="card bg-base-100 shadow-sm">
                <figure>
                    <img src="https://img.daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.webp"
                        alt="Shoes" />
                </figure>
                <div class="card-body">
                    <h2 class="card-title">
                        Card Title
                        <div class="badge badge-secondary">NEW</div>
                    </h2>
                    <p>A card component has a figure, a body part, and inside body there are title and actions parts</p>
                    <div class="card-actions justify-end">
                        <div class="badge badge-outline">Fashion</div>
                        <div class="badge badge-outline">Products</div>
                    </div>
                </div>
            </div>
            <div class="card bg-base-100 shadow-sm">
                <figure>
                    <img src="https://img.daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.webp"
                        alt="Shoes" />
                </figure>
                <div class="card-body">
                    <h2 class="card-title">
                        Card Title
                        <div class="badge badge-secondary">NEW</div>
                    </h2>
                    <p>A card component has a figure, a body part, and inside body there are title and actions parts</p>
                    <div class="card-actions justify-end">
                        <div class="badge badge-outline">Fashion</div>
                        <div class="badge badge-outline">Products</div>
                    </div>
                </div>
            </div>
            <div class="card bg-base-100 shadow-sm">
                <figure>
                    <img src="https://img.daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.webp"
                        alt="Shoes" />
                </figure>
                <div class="card-body">
                    <h2 class="card-title">
                        Card Title
                        <div class="badge badge-secondary">NEW</div>
                    </h2>
                    <p>A card component has a figure, a body part, and inside body there are title and actions parts</p>
                    <div class="card-actions justify-end">
                        <div class="badge badge-outline">Fashion</div>
                        <div class="badge badge-outline">Products</div>
                    </div>
                </div>
            </div>
            <div class="card bg-base-100 shadow-sm">
                <figure>
                    <img src="https://img.daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.webp"
                        alt="Shoes" />
                </figure>
                <div class="card-body">
                    <h2 class="card-title">
                        Card Title
                        <div class="badge badge-secondary">NEW</div>
                    </h2>
                    <p>A card component has a figure, a body part, and inside body there are title and actions parts</p>
                    <div class="card-actions justify-end">
                        <div class="badge badge-outline">Fashion</div>
                        <div class="badge badge-outline">Products</div>
                    </div>
                </div>
            </div>
            <div class="card bg-base-100 shadow-sm">
                <figure>
                    <img src="https://img.daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.webp"
                        alt="Shoes" />
                </figure>
                <div class="card-body">
                    <h2 class="card-title">
                        Card Title
                        <div class="badge badge-secondary">NEW</div>
                    </h2>
                    <p>A card component has a figure, a body part, and inside body there are title and actions parts</p>
                    <div class="card-actions justify-end">
                        <div class="badge badge-outline">Fashion</div>
                        <div class="badge badge-outline">Products</div>
                    </div>
                </div>
            </div>
            <div class="card bg-base-100 shadow-sm">
                <figure>
                    <img src="https://img.daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.webp"
                        alt="Shoes" />
                </figure>
                <div class="card-body">
                    <h2 class="card-title">
                        Card Title
                        <div class="badge badge-secondary">NEW</div>
                    </h2>
                    <p>A card component has a figure, a body part, and inside body there are title and actions parts</p>
                    <div class="card-actions justify-end">
                        <div class="badge badge-outline">Fashion</div>
                        <div class="badge badge-outline">Products</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-5 w-full flex items-center justify-center">
            <button class="btn bg-pink-500 text-white border-0">Read More</button>
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
            <div class="card border-none">
                <div class="card-body flex flex-col items-center justify-center">
                    <div class="avatar">
                        <div class="w-20 rounded-full bg-gray-200">
                            {{-- <img src="https://img.daisyui.com/images/profile/demo/yellingcat@192.webp" /> --}}
                        </div>
                    </div>
                    <div class="mt-2 text-center space-y-4">
                        <h1 class="text-base font-bold">Adakah terdapat pelan percuma, dan apa yang disertakan?</h1>
                        <p class="text-[12px]">Ya! Kami menyediakan pelan percuma dengan ciri asas seperti pengurusan
                            inventori, pengebilan, dan pemantauan pelanggan. Anda boleh menaik taraf bila-bila masa
                            untuk lebih banyak ciri.</p>
                    </div>
                </div>
            </div>
            <div class="card border-none">
                <div class="card-body flex flex-col items-center justify-center">
                    <div class="avatar">
                        <div class="w-20 rounded-full bg-gray-200">
                            {{-- <img src="https://img.daisyui.com/images/profile/demo/yellingcat@192.webp" /> --}}
                        </div>
                    </div>
                    <div class="mt-2 text-center space-y-4">
                        <h1 class="text-base font-bold">Bagaimana platform ini memudahkan pengurusan perniagaan?</h1>
                        <p class="text-[12px]">Kami menawarkan sistem mesra pengguna yang membolehkan anda mengurus
                            jualan, inventori, pemasaran, dan laporan kewangan dengan mudah, semuanya dalam satu
                            aplikasi.</p>
                    </div>
                </div>
            </div>
            <div class="card border-none">
                <div class="card-body flex flex-col items-center justify-center">
                    <div class="avatar">
                        <div class="w-20 rounded-full bg-gray-200">
                            {{-- <img src="https://img.daisyui.com/images/profile/demo/yellingcat@192.webp" /> --}}
                        </div>
                    </div>
                    <div class="mt-2 text-center space-y-4">
                        <h1 class="text-base font-bold">Apakah kelebihan menggunakan platform ini?</h1>
                        <p class="text-[12px]">Dengan harga yang rendah, anda mendapat akses kepada pelbagai alat
                            pengurusan, integrasi dengan rakan kongsi perniagaan, aplikasi mudah alih, dan sokongan
                            pelanggan yang cekap.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- start: testimoni --}}
    <div class="bg-[#1569a0] py-8">
        <div class="max-w-[1080px] w-full mx-auto gap-4 h-auto items-center flex flex-col justify-center">
            <h1 class="text-2xl font-bold text-center text-white">Partners kami</h1>
            <div class="grid grid-cols-3 gap-3 w-full">
                <div class="card border-none">
                    <div class="card-body flex flex-col items-center justify-center">
                        <div class="avatar">
                            <div class="w-20 rounded-full bg-gray-200">
                                <img src="https://img.daisyui.com/images/profile/demo/yellingcat@192.webp" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card border-none">
                    <div class="card-body flex flex-col items-center justify-center">
                        <div class="avatar">
                            <div class="w-20 rounded-full bg-gray-200">
                                <img src="https://img.daisyui.com/images/profile/demo/yellingcat@192.webp" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card border-none">
                    <div class="card-body flex flex-col items-center justify-center">
                        <div class="avatar">
                            <div class="w-20 rounded-full bg-gray-200">
                                <img src="https://img.daisyui.com/images/profile/demo/yellingcat@192.webp" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer class="mt-[28px]">
        {{-- start : footer top --}}
        <div class="flex items-center justify-center flex-col max-w-[500px] w-full mx-auto">
            <div class="flex items-center gap-4">
                <div class="avatar">
                    <div class="w-16 rounded-full bg-gray-200">
                        <img src="https://img.daisyui.com/images/profile/demo/yellingcat@192.webp" />
                    </div>
                </div>
                <span class="text-2xl font-bold">DataPPK.Biz</span>
            </div>
            <ul class="flex items-center gap-2 mt-5 font-bold text-pink-500 w-full justify-center">
                <li><a href="">Polisi Privasi</a></li>
                <li><a href="">Terma & Syarat</a></li>
                <li><a href="">Penghapusan Akaun</a></li>
            </ul>
            <div class="flex items-center justify-center gap-5 w-full mt-4">
                <a href="" class="flex gap-2 items-center text-pink-500"><i data-lucide="mail"
                        class="w-5 h-5"></i> <span>john@example.com</span></a>
                <a href="" class="flex gap-2 items-center text-pink-500"><i data-lucide="phone"
                        class="w-5 h-5"></i> <span>john@example.com</span></a>
            </div>
        </div>
        {{-- start: footer center --}}
        <div class="flex mt-5 justify-between w-full">
            <div class="card bg-[#F1739C] max-w-2xl rounded-none w-full h-20 rounded-tr-2xl">
                <div class="card-body"></div>
            </div>
            <div class="w-full max-w-sm h-full h-24">
                <ul class="flex items-center justify-center justify-center mt-5 gap-10">
                    <li class="bg-pink-500 p-3 rounded-2xl text-white">
                        <a href=""><i data-lucide="facebook"></i></a>
                    </li>
                    <li class="bg-pink-500 p-3 rounded-2xl text-white">
                        <a href=""><i data-lucide="twitter"></i></a>
                    </li>
                    <li class="bg-pink-500 p-3 rounded-2xl text-white">
                        <a href=""><i data-lucide="linkedin"></i></a>
                    </li>
                    <li class="bg-pink-500 p-3 rounded-2xl text-white">
                        <a href=""><i data-lucide="instagram"></i></a>
                    </li>
                </ul>
            </div>
            <div class="card bg-[#F1739C] max-w-2xl rounded-none w-full h-20 rounded-tl-2xl">
                <div class="card-body"></div>
            </div>
        </div>
        {{-- start : footer bottom --}}
        <div class="bg-pink-500 w-full py-10 flex items-center justify-center">
            <h1 class="text-base text-white font-semibold">©DataPPK Biz. Dimiliki oleh Idolegacy Sdn Bhd</h1>
        </div>
    </footer>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        $(document).ready(function() {
            lucide.createIcons();

            // ambil data dari API
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
