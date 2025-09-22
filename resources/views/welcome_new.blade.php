<!DOCTYPE html>
<!-- saved from url=(0022)https://ogse.coedev.my/ -->
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>G3PNS</title>

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" href="{{ asset('landingpage_new/') }}/OGSE_files/inter.css">
    <link rel="stylesheet" href="{{ asset('landingpage_new/') }}/OGSE_files/tailwind.min.css">
    <link rel="icon" type="image/png" sizes="16x16"
        href="{{ asset('landingpage/images/logo/logo-ekomuniti.png') }}">
    <script src="{{ asset('landingpage_new') }}/OGSE_files/main.js.download"></script>
</head>

<body class="antialiased bg-body text-body font-body">
    <div class="">
        <!--<section class="xl:bg-contain bg-top bg-no-repeat" style="background-image: url(&#39;{{ asset('landingpage_new/shuffle/public') }}/metis-assets/backgrounds/intersect.svg&#39;);">-->
        <section class="xl:bg-contain bg-top bg-no-repeat"
            style=" background-image:url({{ asset('landingpage/') }}/images/main-slider/new_bg1.png);">
            <div class="container px-4 mx-auto">
                <nav class="flex justify-between items-center py-6">
                    <a class="text-3xl font-semibold leading-none" href="/"><img class="h-12"
                            src="{{ asset('landingpage_new/') }}/OGSE_files/logo.png" alt="" width="auto"></a>
                    <div class="lg:hidden">
                        <button
                            class="navbar-burger flex items-center py-2 px-3 text-red-700 hover:text-red-800 rounded border border-red-300 hover:border-red-400">
                            <svg class="fill-current h-4 w-4" viewBox="0 0 20 20" xmlns="https://www.w3.org/2000/svg">
                                <title>Mobile menu</title>
                                <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"></path>
                            </svg>
                        </button>
                    </div>
                    <ul class="hidden lg:flex lg:items-center lg:w-auto lg:space-x-12">
                        <!--<li><a class="text-sm text-red-1000 hover:text-red-600" href="https://ogse.coedev.my/">Home</a></li>-->
                        <!--<li><a class="text-sm text-red-1000 hover:text-red-600" href="https://ogse.sabahloka.com/about">About</a></li>-->
                        <!--<li><a class="text-sm text-red-1000 hover:text-red-600" href="https://ogse.sabahloka.com/contact-us">Contact Us</a></li>-->
                    </ul>
                    <div class="hidden lg:block">
                        <!--============-->
                        @if (Route::has('login'))
                            @auth
                                <!--<li>-->

                                <?php
                                $user = Auth::user();
                                
                                ?>
                                @if ($user->id_level === '1')
                                    <a class="inline-block px-4 py-3 text-xs font-semibold leading-none bg-red-700 hover:bg-red-800 text-white rounded"
                                        href="{{ url('/home') }}">Dashboard Admin</a>
                                    <!--<a href="{{ url('/home') }}" class="site-button" style="color: white !important;"><i class="fa fa-lock"></i> Dashboard</a>-->
                                @endif
                                @if ($user->id_level === '2')
                                    <a class="inline-block px-4 py-3 text-xs font-semibold leading-none bg-red-700 hover:bg-red-800 text-white rounded"
                                        href="{{ url('/homeCompany') }}">Dashboard Company</a>
                                    <!--<a href="{{ url('/homeCompany') }}" class="site-button" style="color: white !important;"><i class="fa fa-lock"></i> Dashboard</a>-->
                                @endif
                                @if ($user->id_level === '3')
                                    <a class="inline-block px-4 py-3 text-xs font-semibold leading-none bg-red-700 hover:bg-red-800 text-white rounded"
                                        href="{{ url('/homeManPower') }}">Dashboard Manpower</a>
                                    <!--<a href="{{ url('/homeManPower') }}" class="site-button" style="color: white !important;"><i class="fa fa-lock"></i> Dashboard</a>-->
                                @endif

                                <!--</li>-->
                            @else
                                <!--<li>-->
                                <a class="inline-block px-4 py-3 text-xs font-semibold leading-none bg-red-700 hover:bg-red-800 text-white rounded"
                                    href="{{ route('login') }}">Log In</a>
                                <!--<a href="{{ route('login') }}" class="site-button" style="color: white !important;"><i class="fa fa-lock"></i> &nbsp;&nbsp;&nbsp;&nbsp;Login</a>-->
                                <!--</li>-->
                            @endauth
                        @endif
                        </ul>
                        <!--====================-->
                        <!--<a class="inline-block px-4 py-3 text-xs font-semibold leading-none bg-red-700 hover:bg-red-800 text-white rounded" href="https://ogse.sabahloka.com/login">Log In</a>-->
                    </div>
                </nav>
                <div class="pt-12 text-center">
                    <div class="max-w-3xl mx-auto mb-8">
                        <h2 class="text-3xl md:text-4xl mb-4 font-bold font-heading">
                            <span>Action Creates </span> <span class="text-red-700">Energy</span><br>
                            <span>We Create </span> <span class="text-red-700">Action</span> <br>
                            <span>Be Part of </span> <span class="text-red-700">The Action Today</span>
                        </h2>
                        <p class="text-grey-800 leading-relaxed">The secret of change is to focus all of your energy not
                            on fighting the old, but on building the new.</p>
                    </div>
                    <div>
                        <p class="text-red-800 my-5 text-xl md:text-2xl mb-4 font-bold">Register with us NOW:</p>
                        <a class="block sm:inline-block py-4 px-8 mb-4 sm:mb-0 sm:mr-3 text-xs text-white text-center font-semibold leading-none bg-red-700 hover:bg-red-800 rounded"
                            href="https://ogse.sabahloka.com/register_manpower/create">Manpower</a><a
                            class="block sm:inline-block py-4 px-8 mb-4 sm:mb-0 sm:mr-3 text-xs text-white text-center font-semibold leading-none bg-red-700 hover:bg-red-800 rounded"
                            href="https://ogse.sabahloka.com/register_company/create">Company</a>
                    </div>
                </div>
            </div>
            <div class="relative max-w-6xl mt-16 md:mt-8 mb-8 mx-auto">
                <img src="{{ asset('landingpage_new/') }}/OGSE_files/pattern.png" alt="">
                <div class="absolute" style="top: 9%; left: 14%; width: 72%; height: 66%;"><img class="rounded w-full"
                        src="{{ asset('landingpage_new/') }}/OGSE_files/future-factory-plant-energy-industry-concept_31965-6730.jpg"
                        alt=""></div>
            </div>
            <div class="hidden navbar-menu relative z-50">
                <div class="navbar-backdrop fixed inset-0 bg-gray-900 opacity-75"></div>
                <nav
                    class="fixed top-0 left-0 bottom-0 flex flex-col w-5/6 max-w-sm py-6 px-6 bg-white border-r overflow-y-auto">
                    <div class="flex items-center mb-8">
                        <a class="mr-auto text-3xl font-semibold leading-none" href="https://ogse.coedev.my/"><img
                                class="h-12" src="{{ asset('landingpage_new/') }}/OGSE_files/logo.png" alt=""
                                width="auto"></a>
                        <button class="navbar-close">
                            <svg class="h-6 w-6 text-red-1000 cursor-pointer hover:text-red-600"
                                xmlns="https://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <div>
                        <ul>
                            <li class="mb-1"><a
                                    class="block p-4 text-sm text-red-600 hover:bg-red-100 hover:text-red-700"
                                    href="https://ogse.coedev.my/">Home</a></li>
                            <li class="mb-1"><a
                                    class="block p-4 text-sm text-red-600 hover:bg-red-100 hover:text-red-700"
                                    href="https://ogse.sabahloka.com/about">About</a></li>
                            <li class="mb-1"><a
                                    class="block p-4 text-sm text-red-600 hover:bg-red-100 hover:text-red-700"
                                    href="https://ogse.sabahloka.com/contact-us">Contact Us</a></li>
                        </ul>
                        <div class="mt-4 pt-6 border-t border-red-200"><a
                                class="block px-4 py-3 mb-3 text-xs text-center font-semibold leading-none bg-red-700 hover:bg-red-800 text-white rounded"
                                href="https://ogse.sabahloka.com/login">Log In</a></div>
                    </div>
                </nav>
            </div>
        </section>

        <section class="py-20">
            <div class="container px-4 mx-auto">
                <div class="flex flex-wrap -mx-3">
                    <div class="w-full md:w-1/2 px-3 order-1 md:order-0">
                        <div class="max-w-md">
                            <h2 class="mb-2 text-3xl md:text-4xl font-bold font-heading">Our Purpose</h2>
                            <ul>
                                <li class="py-2">
                                    <span
                                        class="inline-block py-2 px-3 mr-4 text-xs font-semibold bg-blue-100 text-blue-600 rounded">1</span>
                                    <span>To ensure local participation in the industry</span>
                                </li>
                                <li class="py-2">
                                    <span
                                        class="inline-block py-2 px-3 mr-4 text-xs font-semibold bg-blue-100 text-blue-600 rounded">2</span>
                                    <span>To protect State Government interests</span>
                                </li>
                                <li class="py-2">
                                    <span
                                        class="inline-block py-2 px-3 mr-4 text-xs font-semibold bg-blue-100 text-blue-600 rounded">3</span>
                                    <span>Directory/Database for Sabah O&amp;G Downstream, Upstream, and
                                        Midstream</span>
                                </li>
                                <li class="py-2">
                                    <span
                                        class="inline-block py-2 px-3 mr-4 text-xs font-semibold bg-blue-100 text-blue-600 rounded">4</span>
                                    <span>To Protect the local OGSE Companies</span>
                                </li>
                                <li class="py-2">
                                    <span
                                        class="inline-block py-2 px-3 mr-4 text-xs font-semibold bg-blue-100 text-blue-600 rounded">5</span>
                                    <span>To advice on OGSE competency, building competitiveness &amp; local
                                        participation</span>
                                </li>
                                <li class="py-2">
                                    <span
                                        class="inline-block py-2 px-3 mr-4 text-xs font-semibold bg-blue-100 text-blue-600 rounded">6</span>
                                    <span>To advance the local OGSE industry</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="w-full md:w-1/2 px-3 order-0 md:order-1 mb-12 md:mb-0"><img
                            class="sm:max-w-sm lg:max-w-full mx-auto rounded"
                            src="{{ asset('landingpage_new/') }}/OGSE_files/panoramic-shot-oil-rigs-sea-with-beautiful-sunset_181624-20797.jpg"
                            alt=""></div>
                </div>
            </div>
        </section>

        <section class="py-20">
            <div class="container px-4 mx-auto">
                <div class="flex flex-wrap -mx-8">

                    <div class="mb-12 lg:mb-0 pb-12 lg:pb-0 border-b lg:border-b-0">
                        <h2 class="mb-4 text-3xl lg:text-4xl font-bold font-heading">What fuels us</h2>
                        <p class="mb-8 leading-loose text-red-1000">SOGID is committed to monitor, manage, and advise
                            the State of the GLC’s common challenges and solutions for the Downstream, Upstream, and
                            Mistream, but not limited to the followings .</p>
                    </div>
                    <div class="w-full lg:w-1/2 px-8">
                        <ul class="space-y-12">
                            <li class="flex -mx-4">
                                <div class="px-4">
                                    <span
                                        class="flex w-12 h-12 mx-auto items-center justify-center text-xl font-bold font-heading rounded-full bg-red-100 text-red-700">1</span>
                                </div>
                                <div class="px-4">
                                    <p class="text-red-1000 leading-loose">Provide an ‘United Voice’ on behalf of the
                                        State to PETRONAS &amp; External Stakeholders. Also to align GLCs strategy &amp;
                                        approach.</p>
                                </div>
                            </li>
                            <li class="flex -mx-4">
                                <div class="px-4">
                                    <span
                                        class="flex w-12 h-12 mx-auto items-center justify-center text-xl font-bold font-heading rounded-full bg-red-100 text-red-700">2</span>
                                </div>
                                <div class="px-4">
                                    <p class="text-red-1000 leading-loose">Establish Industry database/directory and
                                        provide One-Stop Information Centre for all local O&amp;G players.</p>
                                </div>
                            </li>
                            <li class="flex -mx-4">
                                <div class="px-4">
                                    <span
                                        class="flex w-12 h-12 mx-auto items-center justify-center text-xl font-bold font-heading rounded-full bg-red-100 text-red-700">3</span>
                                </div>
                                <div class="px-4">
                                    <p class="text-red-1000 leading-loose">Focus and work on Human Capital Development
                                        further for Downstream, Upstream, and Midstream specifically and advice on its
                                        enriched programs.</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="w-full lg:w-1/2 px-8">
                        <ul class="space-y-6">
                            <li class="flex -mx-4">
                                <div class="px-4">
                                    <span
                                        class="flex w-12 h-12 mx-auto items-center justify-center text-xl font-bold font-heading rounded-full bg-red-100 text-red-700">4</span>
                                </div>
                                <div class="px-4">
                                    <p class="text-red-1000 leading-loose">Review and advise on local About privilege
                                        to assist local companies</p>
                                </div>
                            </li>
                            <li class="flex -mx-4">
                                <div class="px-4">
                                    <span
                                        class="flex w-12 h-12 mx-auto items-center justify-center text-xl font-bold font-heading rounded-full bg-red-100 text-red-700">5</span>
                                </div>
                                <div class="px-4">
                                    <p class="text-red-1000 leading-loose">Monitor all O&amp;G operators progress and
                                        development in Sabah. Manage Sabah O&amp;G Industry delivery</p>
                                </div>
                            </li>
                            <li class="flex -mx-4">
                                <div class="px-4">
                                    <span
                                        class="flex w-12 h-12 mx-auto items-center justify-center text-xl font-bold font-heading rounded-full bg-red-100 text-red-700">6</span>
                                </div>
                                <div class="px-4">
                                    <p class="text-red-1000 leading-loose">Maximize the value creation for the State
                                        from the O&amp;G sector across the value chain (e.g Tax revenue, job creation,
                                        economic spin-offs)</p>
                                </div>
                            </li>
                            <li class="flex -mx-4">
                                <div class="px-4">
                                    <span
                                        class="flex w-12 h-12 mx-auto items-center justify-center text-xl font-bold font-heading rounded-full bg-red-100 text-red-700">7</span>
                                </div>
                                <div class="px-4">
                                    <p class="text-red-1000 leading-loose">Develop vendor development program</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="container px-4 pt-10 mx-auto">
                <div class="flex flex-wrap -mx-8">
                    <div class="w-full px-8">
                        <div class="mb-12 lg:mb-0 pb-12 lg:pb-0 border-b lg:border-b-0">
                            <p class="mb-8 leading-loose text-red-1000">As a Government-Linked About that works for the
                                people, we will consider equality and diversity in everything we do, and to play an
                                important part in working towards the life chances and opportunities for all local
                                people.</p>
                            <p class="mb-8 leading-loose text-red-1000">We aim to provide local people with the
                                opportunity to succeed, and to reach the highest. SOGID is committed to taking positive
                                action that will open up the services and opportunities to everyone, ensure that
                                difference and diversity is embraced, and that people are always treated fairly and with
                                respect.</p>
                            <p class="mb-8 leading-loose text-red-1000">This Policy sets out the key principles of
                                equality that will guide the way in which we make decisions, provide services; work with
                                other organizations; and involve local people. SOGID is committed to ensuring equality,
                                fairness, inclusion and good relations are at the heart of everything we do, for the
                                benefits of our local manpower.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container px-4 mx-auto">
                <div class="flex flex-wrap -mx-3">
                    <div class="w-full md:w-1/2 px-3 order-1 md:order-0">
                        <div class="max-w-md">
                            <p class="mb-6 leading-loose text-red-1000">Our commitment to promoting equality is
                                reflected in the va lues that guide the way in which we plan and deliver services:</p>
                            <ul>
                                <li class="py-4">
                                    <span
                                        class="inline-block py-2 px-3 mr-4 text-xs font-semibold bg-blue-100 text-blue-600 rounded">1</span>
                                    <span>Openness, fairness and accountability</span>
                                </li>
                                <li class="py-4">
                                    <span
                                        class="inline-block py-2 px-3 mr-4 text-xs font-semibold bg-blue-100 text-blue-600 rounded">2</span>
                                    <span>Involving and listening to our citizens</span>
                                </li>
                                <li class="py-4">
                                    <span
                                        class="inline-block py-2 px-3 mr-4 text-xs font-semibold bg-blue-100 text-blue-600 rounded">3</span>
                                    <span>Valuing our people</span>
                                </li>
                                <li class="py-4">
                                    <span
                                        class="inline-block py-2 px-3 mr-4 text-xs font-semibold bg-blue-100 text-blue-600 rounded">4</span>
                                    <span>Continuous Improvement</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="w-full md:w-1/2 px-3 order-0 md:order-1 mb-12 md:mb-0"><img
                            class="sm:max-w-sm lg:max-w-full mx-auto rounded"
                            src="{{ asset('landingpage_new/') }}/OGSE_files/closeup-view-cylindrical-grinder-industrial-concept_181624-17731.jpg"
                            alt=""></div>
                </div>
            </div>
        </section>

        <footer class="bg-gray-100">
            <div class="container mx-auto px-8">
                <div class="w-full flex flex-col md:flex-row py-6">
                    <div class="flex-1 mb-6 text-black">
                        <a class="text-pink-600 no-underline hover:no-underline font-bold text-2xl lg:text-4xl"
                            href="https://ogse.coedev.my/#">
                            <img class="h-20" src="{{ asset('landingpage_new/') }}/OGSE_files/logo.png"
                                alt="" width="auto">
                        </a>
                    </div>
                    <div class="flex-1">
                        <p class="uppercase text-gray-500 md:mb-6">Legal</p>
                        <ul class="list-reset mb-6">
                            <li class="mt-2 inline-block mr-2 md:block md:mr-0">
                                <a href="https://ogse.coedev.my/#"
                                    class="no-underline hover:underline text-gray-800 hover:text-red-500">Terms</a>
                            </li>
                            <li class="mt-2 inline-block mr-2 md:block md:mr-0">
                                <a href="https://ogse.coedev.my/#"
                                    class="no-underline hover:underline text-gray-800 hover:text-red-500">Privacy</a>
                            </li>
                        </ul>
                    </div>
                    <div class="flex-1">
                        <p class="uppercase text-gray-500 md:mb-6">Social</p>
                        <ul class="list-reset mb-6">
                            <li class="mt-2 inline-block mr-2 md:block md:mr-0">
                                <a href="https://ogse.coedev.my/#"
                                    class="no-underline hover:underline text-gray-800 hover:text-red-500">Facebook</a>
                            </li>
                            <li class="mt-2 inline-block mr-2 md:block md:mr-0">
                                <a href="https://ogse.coedev.my/#"
                                    class="no-underline hover:underline text-gray-800 hover:text-red-500">Linkedin</a>
                            </li>
                            <li class="mt-2 inline-block mr-2 md:block md:mr-0">
                                <a href="https://ogse.coedev.my/#"
                                    class="no-underline hover:underline text-gray-800 hover:text-red-500">Twitter</a>
                            </li>
                        </ul>
                    </div>
                    <div class="flex-1">
                        <p class="uppercase text-gray-500 md:mb-6">About</p>
                        <ul class="list-reset mb-6">
                            <li class="mt-2 inline-block mr-2 md:block md:mr-0">
                                <a href="https://ogse.coedev.my/#"
                                    class="no-underline hover:underline text-gray-800 hover:text-red-500">Official
                                    Blog</a>
                            </li>
                            <li class="mt-2 inline-block mr-2 md:block md:mr-0">
                                <a href="https://ogse.coedev.my/#"
                                    class="no-underline hover:underline text-gray-800 hover:text-red-500">Contact
                                    Us</a>
                            </li>
                            <li class="mt-2 inline-block mr-2 md:block md:mr-0">
                                <a href="https://ogse.coedev.my/#"
                                    class="no-underline hover:underline text-gray-800 hover:text-red-500">Contact</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <center>
                <a href="https://www.freepik.com/free-photos-vectors/background" class="text-gray-500">Under
                    Construction By Idolegacy Sdn Bhd</a>
            </center>
        </footer>
    </div>



</body>

</html>
