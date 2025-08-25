<style>
    p {
        font-size: 14px;
    }

    /* Aktif link pada sidebar light */
    [class*=sidebar-light-] .nav-sidebar>.nav-item>.nav-link.active,
    [class*=sidebar-light-] .nav-sidebar>.nav-item>.nav-link.active:hover,
    [class*=sidebar-light-] .nav-treeview>.nav-item>.nav-link.active,
    [class*=sidebar-light-] .nav-treeview>.nav-item>.nav-link.active:hover {
        background-color: #383444;
        color: #ffffff;
    }

    /* Aktif link pada sidebar dark */
    [class*=sidebar-dark-] .nav-sidebar>.nav-item>.nav-link.active,
    [class*=sidebar-dark-] .nav-sidebar>.nav-item>.nav-link.active:hover,
    [class*=sidebar-dark-] .nav-treeview>.nav-item>.nav-link.active,
    [class*=sidebar-dark-] .nav-treeview>.nav-item>.nav-link.active:hover {
        background-color: #383444;
        color: #ffffff;
    }

    /* Untuk komponen lain seperti nav-pills (jika dipakai) */
    .nav-pills .nav-link.active,
    .nav-pills .show>.nav-link {
        background-color: #383444;
        color: #ffffff;
    }
</style>

<div class="sidebar" style="overflow:scroll">
    <?php
    
    $level = \Auth::user()->id_level;
    $sub_company = \Auth::user()->sub_company;
    $status_approval = \Auth::user()->status_approval;
    ?>

    <nav class="mt-2">
        <!--SUPER ADMIN-->
        @if ($level == 1 || $level == 7)

            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="true">
                <li class="nav-item">
                    <a href="/home" class="nav-link {{ request()->is('home') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file-contract"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/statistic" class="nav-link {{ request()->is('statistic') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-chart-bar"></i>
                        <p>
                            Statistik
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="/admin/blog-post" class="nav-link {{ request()->is('admin/blog-post') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-newspaper"></i>
                        <p>
                            Buletin
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/admin/direktori" class="nav-link {{ request()->is('admin/direktori') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Direktori
                        </p>
                    </a>
                </li>


                {{-- <li class="nav-item {{ request()->is('senaraiPersatuan') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon far fa-building"></i>
                        <p>
                            Senarai Cawangan
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview offset-md-1">
                        <li class="nav-item">
                            <a href="/senaraiPersatuan?status=Overall"
                                class="nav-link {{ request()->is('senaraiPersatuan') && request()->status == 'Overall' ? 'active' : '' }}">
                                <i class="fas fa-check-circle nav-icon"></i>
                                <p>Overall</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/senaraiPersatuan?status=Active"
                                class="nav-link {{ request()->is('senaraiPersatuan') && request()->status == 'Active' ? 'active' : '' }}">
                                <i class="fas fa-check-circle nav-icon"></i>
                                <p>Active</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="/senaraiPersatuan?status=Suspend"
                                class="nav-link {{ request()->is('senaraiPersatuan') && request()->status == 'Suspend' ? 'active' : '' }}">
                                <i class="fas fa-exclamation-circle nav-icon"></i>
                                <p>Suspend</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="/senaraiPersatuan?status=Banned"
                                class="nav-link {{ request()->is('senaraiPersatuan') && request()->status == 'Banned' ? 'active' : '' }}">
                                <i class="fas fa-times-circle nav-icon"></i>
                                <p>Ban</p>
                            </a>
                        </li>

                    </ul>
                </li> --}}
                <!--"nav-item {{ Route::currentRouteNamed('home', 'company.active.index') ? '' : 'menu-open' }}"-->
                <li
                    class="nav-item {{ request()->is('senaraiAhli') || request()->is('companyCard') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user-tie"></i>
                        <p>
                            Senarai Ahli
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview offset-md-1">
                        <li class="nav-item">
                            <a href="/senaraiAhli?status=Unfiltered"
                                class="nav-link {{ request()->is('senaraiAhli') && request()->status == 'Unfiltered' ? 'active' : '' }}">
                                <i class="fas fa-check-circle nav-icon"></i>
                                <p>Overall Registration</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/senaraiAhli?status=Overall"
                                class="nav-link {{ request()->is('senaraiAhli') && request()->status == 'Overall' ? 'active' : '' }}">
                                <i class="fas fa-check-circle nav-icon"></i>
                                <p>Complete Registration</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/senaraiAhli?status=Active"
                                class="nav-link {{ request()->is('senaraiAhli') && request()->status == 'Active' ? 'active' : '' }}">
                                <i class="fas fa-check-circle nav-icon"></i>
                                <p>Active</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="/senaraiAhli?status=Suspend"
                                class="nav-link {{ request()->is('senaraiAhli') && request()->status == 'Suspend' ? 'active' : '' }}">
                                <i class="fas fa-exclamation-circle nav-icon"></i>
                                <p>Suspend</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="/senaraiAhli?status=Banned"
                                class="nav-link {{ request()->is('senaraiAhli') && request()->status == 'Banned' ? 'active' : '' }}">
                                <i class="fas fa-times-circle nav-icon"></i>
                                <p>Ban</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="/senaraiAhli?license=No"
                                class="nav-link {{ request()->is('senaraiAhli') && request()->license == 'No' ? 'active' : '' }}">
                                <i class="fas fa-check-circle nav-icon"></i>
                                <p>No License</p>
                            </a>
                        </li>


                        <li class="nav-item">
                            <a href="/senaraiAhli?status=Expired"
                                class="nav-link {{ request()->is('senaraiAhli') && request()->status == 'Expired' ? 'active' : '' }}">
                                <i class="fas fa-check-circle nav-icon"></i>
                                <p>Expired</p>
                            </a>
                        </li>

                    </ul>
                </li>

                {{-- <li class="nav-item">
                    <a href="{{ URL::to('senaraiProduk') }}"
                        class="nav-link {{ request()->is('senaraiProduk') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-shopping-bag"></i>
                        <p>
                            Senarai Produk
                        </p>
                    </a>
                </li> --}}

                <li
                    class="nav-item has-treeview {{ request()->is('logPayment') || request()->is('log-pembayaran-keahlian') ? 'menu-open' : '' }} ">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-file-contract"></i>
                        <p>
                            Log Pembayaran
                            <i class="right fa fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview offset-md-1" style="">
                        {{-- <li class="nav-item">
                            <!--{{ URL::to('/list_company') }}-->
                            <a href="/logPayment?status=Waiting"
                                class="nav-link {{ request()->is('logPayment') && request()->status == 'Waiting' ? 'active' : '' }}">
                                <i class="far fa-hand-paper nav-icon"></i>
                                <p class="">Waiting</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="/logPayment?status=Approved"
                                class="nav-link {{ request()->is('logPayment') && request()->status == 'Approved' ? 'active' : '' }}">
                                <i class="far fa-thumbs-up nav-icon"></i>
                                <p class="">Approve</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="/logPayment?status=Rejected"
                                class="nav-link {{ request()->is('logPayment') && request()->status == 'Rejected' ? 'active' : '' }}">
                                <i class="far fa-thumbs-down nav-icon"></i>
                                <p class="">Reject</p>
                            </a>
                        </li> --}}

                        <li class="nav-item">
                            <a href="{{ URL::to('/log-pembayaran-keahlian?type=register') }}"
                                class="nav-link {{ request()->fullUrl() === URL::to('/log-pembayaran-keahlian?type=register') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-history"></i>
                                <p>Pendaftaran</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ URL::to('/log-pembayaran-keahlian?type=renewal') }}"
                                class="nav-link {{ request()->fullUrl() === URL::to('/log-pembayaran-keahlian?type=renewal') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-history"></i>
                                <p>Renewal</p>
                            </a>
                        </li>

                    </ul>
                </li>
                <li class="nav-item has-treeview {{ request()->is('logCertificate') ? 'menu-open' : '' }} ">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-file-contract"></i>
                        <p>
                            Status Log
                            <i class="right fa fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview offset-md-1" style="">
                        <li class="nav-item">
                            <!--{{ URL::to('/list_company') }}-->
                            <a href="/logCertificate?status=Waiting"
                                class="nav-link {{ request()->is('logCertificate') && request()->status == 'Waiting' ? 'active' : '' }}">
                                <i class="far fa-hand-paper nav-icon"></i>
                                <p class="">Waiting</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="/logCertificate?status=Approved"
                                class="nav-link {{ request()->is('logCertificate') && request()->status == 'Approved' ? 'active' : '' }}">
                                <i class="far fa-thumbs-up nav-icon"></i>
                                <p class="">Approve</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="/logCertificate?status=Rejected"
                                class="nav-link {{ request()->is('logCertificate') && request()->status == 'Rejected' ? 'active' : '' }}">
                                <i class="far fa-thumbs-down nav-icon"></i>
                                <p class="">Reject</p>
                            </a>
                        </li>

                    </ul>
                </li>
                <li class="nav-item has-treeview {{ request()->is('requestUpdateCompany') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-file-contract"></i>
                        <p>
                            Perubahan Data
                            <i class="right fa fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview offset-md-1" style="">
                        <li class="nav-item">
                            <!--{{ URL::to('/list_company') }}-->
                            <a href="/requestUpdateCompany?status=Waiting"
                                class="nav-link {{ request()->is('requestUpdateCompany') && request()->status == 'Waiting' ? 'active' : '' }}">
                                <i class="far fa-hand-paper nav-icon"></i>
                                <p class="">Waiting</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="/requestUpdateCompany?status=Approved"
                                class="nav-link {{ request()->is('requestUpdateCompany') && request()->status == 'Approved' ? 'active' : '' }}">
                                <i class="far fa-thumbs-up nav-icon"></i>
                                <p class="">Approve</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="/requestUpdateCompany?status=Rejected"
                                class="nav-link {{ request()->is('requestUpdateCompany') && request()->status == 'Rejected' ? 'active' : '' }}">
                                <i class="far fa-thumbs-down nav-icon"></i>
                                <p class="">Reject</p>
                            </a>
                        </li>

                    </ul>
                </li>
                <li class="nav-item">
                    <a href="/users?id_level=4"
                        class="nav-link {{ request()->is('users') && request()->id_level == '4' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-tie"></i>
                        <p>
                            Ketua bahagian
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/users?id_level=2"
                        class="nav-link {{ request()->is('users') && request()->id_level == '2' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-tie"></i>
                        <p>
                            Senarai Cawangan
                        </p>
                    </a>
                </li>
                {{-- <li class="nav-item">
                    <a href="/users?id_level=6"
                        class="nav-link {{ request()->is('users') && request()->id_level == '6' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-tie"></i>
                        <p>
                           Preview
                        </p>
                    </a>
                </li> --}}
                {{-- <li class="nav-item">
                    <a href="/users?id_level=4"
                        class="nav-link {{ request()->is('users') && request()->id_level == '4' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-tie"></i>
                        <p>
                            Pihak Berkuasa Tempatan
                        </p>
                    </a>
                </li> --}}
                @php
                    $settingsRoutes = [
                        'list_setting_country',
                        'gerbang_pembayaran',
                        'list_position',
                        'list_setting_state',
                        'list_setting_city',
                        'list_setting_religion',
                        'list_settings_nation',
                        'list_settings_status_native',
                        'list_settings_gender',
                        'list_marital_status',
                        'list_settings_status_education',
                        'list_settings_study',
                        'list_settings_business_type',
                        'list_settings_business_activity',
                        'list_settings_sub_business_activity',
                        'list_settings_category_product',
                        'list_settings_term',
                        'list_setting_certificate',
                        'list_setting_parliament',
                        'list_setting_dun',
                        'list_setting_village_guests',
                        'list_setting_yuran',
                        'admin/user/activities',
                        'category/post',
                        'setting-brand'
                    ];
                @endphp
                <li
                    class="nav-item has-treeview {{ in_array(request()->path(), $settingsRoutes) ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>
                            Settings
                            <i class="right fa fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview offset-md-1" style="">
                        <li class="nav-item">
                            <a href="{{ URL::to('/list_setting_parliament') }}"
                                class="nav-link {{ request()->is('list_setting_parliament') ? 'active' : '' }}">
                                <i class="fas fa-archway nav-icon"></i>
                                <p class="">Parlimen</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ URL::to('/list_setting_dun') }}"
                                class="nav-link {{ request()->is('list_setting_dun') ? 'active' : '' }}">
                                <i class="fas fa-archway nav-icon"></i>
                                <p class="">DUN</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ URL::to('/list_setting_village_guests') }}"
                                class="nav-link {{ request()->is('list_setting_village_guests') ? 'active' : '' }}">
                                <i class="fas fa-archway nav-icon"></i>
                                <p class="">Tamu Desa</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <!--{{ URL::to('/list_company') }}-->
                            <a href="{{ URL::to('/list_position') }}"
                                class="nav-link {{ request()->is('list_position') ? 'active' : '' }}">
                                <i class="fa fa-industry nav-icon"></i>
                                <p class="">Jawatan</p>
                            </a>
                        </li>


                        <li class="nav-item">
                            <a href="{{ URL::to('/list_setting_country') }}"
                                class="nav-link {{ request()->is('list_setting_country') ? 'active' : '' }}">
                                <i class="fas fa-globe-asia nav-icon"></i>
                                <p class="">Country</p>
                            </a>
                        </li>


                        <li class="nav-item">
                            <a href="{{ URL::to('/list_setting_state') }}"
                                class="nav-link {{ request()->is('list_setting_state') ? 'active' : '' }}">
                                <i class="fas fa-landmark nav-icon"></i>
                                <p class="">State</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ URL::to('/list_setting_data_bahagian') }}"
                                class="nav-link {{ request()->is('list_setting_data_bahagian') ? 'active' : '' }}">
                                <i class="fas fa-city nav-icon"></i>
                                <p class="">Data Bahagian</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ URL::to('/list_setting_religion') }}"
                                class="nav-link {{ request()->is('list_setting_religion') ? 'active' : '' }}">
                                <i class="fas fa-star-and-crescent nav-icon"></i>
                                <p class="">Religion</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ URL::to('/list_settings_nation') }}"
                                class="nav-link {{ request()->is('list_settings_nation') ? 'active' : '' }}">
                                <i class="fas fa-archway nav-icon"></i>
                                <p class="">Bangsa</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ URL::to('/list_settings_status_native') }}"
                                class="nav-link {{ request()->is('list_settings_status_native') ? 'active' : '' }}">
                                <i class="fas fa-address-card nav-icon"></i>
                                <p class="">Status Bumiputera</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ URL::to('/list_settings_gender') }}"
                                class="nav-link {{ request()->is('list_settings_gender') ? 'active' : '' }}">
                                <i class="fas fa-transgender nav-icon"></i>
                                <p class="">Jantina</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ URL::to('/list_marital_status') }}"
                                class="nav-link {{ request()->is('list_marital_status') ? 'active' : '' }}">
                                <i class="fas fa-transgender nav-icon"></i>
                                <p class="">Status</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ URL::to('/list_settings_status_education') }}"
                                class="nav-link {{ request()->is('list_settings_status_education') ? 'active' : '' }}">
                                <i class="fas fa-user-graduate nav-icon"></i>
                                <p class="">Taraf Pendidikan</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ URL::to('/list_settings_study') }}"
                                class="nav-link {{ request()->is('list_settings_study') ? 'active' : '' }}">
                                <i class="fas fa-graduation-cap nav-icon"></i>
                                <p class="">Bidang Pendidikan</p>
                            </a>
                        </li>
                        {{--
                        <li class="nav-item">
                            <a href="{{ URL::to('/list_settings_business_type') }}"
                                class="nav-link {{ request()->is('list_settings_business_type') ? 'active' : '' }}">
                                <i class="fas fa-shopping-bag nav-icon"></i>
                                <p class="">Jenis Pendaftaran Perniagaan</p>
                            </a>
                        </li> --}}

                        {{-- <li class="nav-item">
                            <a href="{{ URL::to('/list_settings_business_activity') }}"
                                class="nav-link {{ request()->is('list_settings_business_activity') ? 'active' : '' }}">
                                <i class="fas fa-store nav-icon"></i>
                                <p class="">Aktiviti Perniagaan</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ URL::to('/list_settings_sub_business_activity') }}"
                                class="nav-link {{ request()->is('list_settings_sub_business_activity') ? 'active' : '' }}">
                                <i class="fas fa-store nav-icon"></i>
                                <p class="">Jenis Kategori Perniagaan</p>
                            </a>
                        </li> --}}

                        {{-- <li class="nav-item">
                            <a href="{{ URL::to('/list_settings_category_product') }}"
                                class="nav-link {{ request()->is('list_settings_category_product') ? 'active' : '' }}">
                                <i class="fas fa-store nav-icon"></i>
                                <p class="">Kategori Produk</p>
                            </a>
                        </li> --}}

                        <li class="nav-item">
                            <a href="{{ URL::to('/list_settings_term') }}"
                                class="nav-link {{ request()->is('list_settings_term') ? 'active' : '' }}">
                                <i class="fas fa-highlighter nav-icon"></i>
                                <p class="">Terma & Syarat</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ URL::to('/list_setting_certificate') }}"
                                class="nav-link {{ Route::currentRouteNamed('settings_certificate.index') ? 'active' : '' }}">
                                <i class="fas fa-certificate nav-icon"></i>
                                <p class="">Certificate</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ URL::to('/gerbang_pembayaran') }}"
                                class="nav-link {{ request()->is('gerbang_pembayaran') ? 'active' : '' }}">
                                <i class="fas fa-credit-card nav-icon"></i>
                                <p class="">Gerbang Pembayaran</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ URL::to('/admin/user/activities') }}"
                                class="nav-link {{ request()->is('admin/user/activities') ? 'active' : '' }}">
                                <i class="fas fa-users nav-icon"></i>
                                <p class="">User Activities</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ URL::to('/category/post') }}"
                                class="nav-link {{ request()->is('category/post') ? 'active' : '' }}">
                                <i class="fas fa-tag nav-icon"></i>
                                <p class="">Kategori Postingan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ URL::to('/setting-brand') }}"
                                class="nav-link {{ request()->is('setting-brand') ? 'active' : '' }}">
                                <i class="fas fa-cogs nav-icon"></i>
                                <p class="">Setting Brand</p>
                            </a>
                        </li>
                        {{-- 
                        <li class="nav-item">
                            <a href="{{ URL::to('/gerbang-pembayaran') }}"
                                class="nav-link {{ Route::currentRouteNamed('gerbang.pembayaran') ? 'active' : '' }}">
                                <i class="fas fa-credit-card nav-icon"></i>
                                <p>Gerbang Pembayaran</p>
                            </a>
                        </li> --}}

                        {{-- <li class="nav-item">
                            <a href="{{ URL::to('/log-pembayaran-keahlian') }}"
                                class="nav-link {{ Route::currentRouteNamed('log.pembayaran.keahlian') ? 'active' : '' }}">
                                <i class="fas fa-receipt nav-icon"></i>
                                <p>Log Pembayaran Keahlian</p>
                            </a>
                        </li> --}}
                        {{-- <li class="nav-item">
                            <a href="{{URL::to('/list_qualification')}}" class="nav-link {{ Route::currentRouteNamed('settings_qualification.index') ? 'active' : '' }}">
                                <i class="fa fa-check-square nav-icon"></i>
                                <p class="">Qualification</p>
                            </a>
                        </li>
						 <li class="nav-item">
                            <a href="{{URL::to('/list_setting_schoolType')}}" class="nav-link {{ Route::currentRouteNamed('settings_schooltype.index') ? 'active' : '' }}">
                                <i class="fas fa-school nav-icon"></i>
                                <p class="">School Type</p>
                            </a>
                        </li>
						<li class="nav-item">
                            <a href="{{URL::to('/list_setting_school')}}" class="nav-link {{ Route::currentRouteNamed('settings_school.index') ? 'active' : '' }}">
                                <i class="fa fa-graduation-cap nav-icon"></i>
                                <p class="">School</p>
                            </a>
                        </li>


                        <li class="nav-item">
                            <a href="{{URL::to('/list_settings_vendor')}}" class="nav-link">
                                <i class="fas fa-signature nav-icon"></i>
                                <p class="">Vendor's Licenses</p>
                            </a>
                        </li> --}}
                    </ul>
                </li>


            </ul>
        @elseif($level == 5)
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="true">
                <li class="nav-item">
                    <a href="/home" class="nav-link {{ request()->is('home') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file-contract"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item {{ request()->is('senaraiPersatuan') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon far fa-building"></i>
                        <p>
                            Senarai Persatuan
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview offset-md-1">

                        <li class="nav-item">
                            <a href="/senaraiPersatuan?status=Active"
                                class="nav-link {{ request()->is('senaraiPersatuan') && request()->status == 'Active' ? 'active' : '' }}">
                                <i class="fas fa-check-circle nav-icon"></i>
                                <p>Active</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!--"nav-item {{ Route::currentRouteNamed('home', 'company.active.index') ? '' : 'menu-open' }}"-->
                <li
                    class="nav-item {{ request()->is('senaraiAhli') || request()->is('companyCard') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user-tie"></i>
                        <p>
                            Senarai Ahli
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>


                    <ul class="nav nav-treeview offset-md-1">

                        <li class="nav-item">
                            <a href="/senaraiAhli?status=Active"
                                class="nav-link {{ request()->is('senaraiAhli') && request()->status == 'Active' ? 'active' : '' }}">
                                <i class="fas fa-check-circle nav-icon"></i>
                                <p>Active</p>
                            </a>
                        </li>

                    </ul>
                </li>

                <li class="nav-item">
                    <a href="/users" class="nav-link {{ request()->is('users') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-tie"></i>
                        <p>
                            Pihak Berkuasa Tempatan
                        </p>
                    </a>
                </li>
            </ul>
        @elseif($level == 6)
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="true">
                <li class="nav-item">
                    <a href="/home" class="nav-link {{ request()->is('home') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file-contract"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/statistic" class="nav-link {{ request()->is('statistic') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-chart-bar"></i>
                        <p>Statistik</p>
                    </a>
                </li>
                <li
                    class="nav-item {{ request()->is('pembayaran-cawangan') || request()->is('pembayaran-ketua-bahagian') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-money-bill-wave"></i>
                        <p>
                            Pembayaran
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview offset-md-1">
                        <li class="nav-item">
                            <a href="/pembayaran-cawangan"
                                class="nav-link {{ request()->is('pembayaran-cawangan') ? 'active' : '' }}">
                                <i class="fas fa-money-bill-wave nav-icon"></i>
                                <p>Cawangan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/pembayaran-ketua-bahagian"
                                class="nav-link {{ request()->is('pembayaran-ketua-bahagian') ? 'active' : '' }}">
                                <i class="fas fa-money-bill-wave nav-icon"></i>
                                <p>Ketua Bahagian</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item {{ request()->is('senaraiPersatuan') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon far fa-building"></i>
                        <p>
                            Senarai Cawangan
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview offset-md-1">
                        <li class="nav-item">
                            <a href="/senaraiPersatuan?status=Active"
                                class="nav-link {{ request()->is('senaraiPersatuan') && request()->status == 'Active' ? 'active' : '' }}">
                                <i class="fas fa-check-circle nav-icon"></i>
                                <p>Active</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li
                    class="nav-item {{ request()->is('senaraiAhli') || request()->is('companyCard') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user-tie"></i>
                        <p>
                            Senarai Ahli
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview offset-md-1">
                        <li class="nav-item">
                            <a href="/senaraiAhli?status=Active"
                                class="nav-link {{ request()->is('senaraiAhli') && request()->status == 'Active' ? 'active' : '' }}">
                                <i class="fas fa-check-circle nav-icon"></i>
                                <p>Active</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="/users?id_level=4"
                        class="nav-link {{ request()->is('users') && request()->id_level == '4' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-tie"></i>
                        <p>Ketua Bahagian</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/users?id_level=2"
                        class="nav-link {{ request()->is('users') && request()->id_level == '2' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-tie"></i>
                        <p>Cawangan</p>
                    </a>
                </li>
                {{-- <li class="nav-item">
                    <a href="/pengesahan-keahlian"
                        class="nav-link {{ request()->is('pengesahan-keahlian') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-shield"></i>
                        <p>Pengesahan Keahlian</p>
                    </a>
                </li> --}}
                <li
                    class="nav-item {{ request()->is('list_setting_country') || request()->is('list_position') || request()->is('list_setting_state') || request()->is('list_setting_city') || request()->is('list_setting_religion') || request()->is('list_settings_nation') || request()->is('list_settings_status_native') || request()->is('list_settings_gender') || request()->is('list_marital_status') || request()->is('list_settings_status_education') || request()->is('list_settings_study') || request()->is('list_settings_business_type') || request()->is('list_settings_business_activity') || request()->is('list_settings_sub_business_activity') || request()->is('list_settings_category_product') || request()->is('list_settings_term') || request()->is('list_setting_certificate') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>
                            Settings
                            <i class="right fa fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview offset-md-1">
                        <li class="nav-item">
                            <a href="/list_setting_certificate"
                                class="nav-link {{ Route::currentRouteNamed('settings_certificate.index') ? 'active' : '' }}">
                                <i class="fas fa-certificate nav-icon"></i>
                                <p>Certificate</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/wallet" class="nav-link {{ request()->is('wallet') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-wallet"></i>
                                <p>Payment Gateway</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        @elseif($level == 4)
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="true">
                <li class="nav-item">
                    <a href="/home" class="nav-link {{ request()->is('home') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file-contract"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/pembayaran-ketua-bahagian"
                        class="nav-link {{ request()->is('pembayaran-ketua-bahagian') ? 'active' : '' }}">
                        <i class="fas fa-money-bill-wave nav-icon"></i>
                        <p>Ketua Bahagian</p>
                    </a>
                </li>
                <li class="nav-item {{ request()->is('senaraiPersatuan') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon far fa-building"></i>
                        <p>
                            Senarai Persatuan
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview offset-md-1">
                        <li class="nav-item">
                            <a href="/senaraiPersatuan?status=Overall"
                                class="nav-link {{ request()->is('senaraiPersatuan') && request()->status == 'Overall' ? 'active' : '' }}">
                                <i class="fas fa-check-circle nav-icon"></i>
                                <p>Overall</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/senaraiPersatuan?status=Active"
                                class="nav-link {{ request()->is('senaraiPersatuan') && request()->status == 'Active' ? 'active' : '' }}">
                                <i class="fas fa-check-circle nav-icon"></i>
                                <p>Active</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="/senaraiPersatuan?status=Suspend"
                                class="nav-link {{ request()->is('senaraiPersatuan') && request()->status == 'Suspend' ? 'active' : '' }}">
                                <i class="fas fa-exclamation-circle nav-icon"></i>
                                <p>Suspend</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="/senaraiPersatuan?status=Banned"
                                class="nav-link {{ request()->is('senaraiPersatuan') && request()->status == 'Banned' ? 'active' : '' }}">
                                <i class="fas fa-times-circle nav-icon"></i>
                                <p>Ban</p>
                            </a>
                        </li>

                    </ul>
                </li>


                <!--"nav-item {{ Route::currentRouteNamed('home', 'company.active.index') ? '' : 'menu-open' }}"-->
                <li class="nav-item {{ request()->is('senaraiAhli') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user-tie"></i>
                        <p>
                            Senarai Ahli
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>


                    <ul class="nav nav-treeview offset-md-1">
                        <li class="nav-item">
                            <a href="/senaraiAhli?status=Unfiltered"
                                class="nav-link {{ request()->is('senaraiAhli') && request()->status == 'Unfiltered' ? 'active' : '' }}">
                                <i class="fas fa-check-circle nav-icon"></i>
                                <p>Overall Registration</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/senaraiAhli?status=Overall"
                                class="nav-link {{ request()->is('senaraiAhli') && request()->status == 'Overall' ? 'active' : '' }}">
                                <i class="fas fa-check-circle nav-icon"></i>
                                <p>Complete Registration</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/senaraiAhli?status=Active"
                                class="nav-link {{ request()->is('senaraiAhli') && request()->status == 'Active' ? 'active' : '' }}">
                                <i class="fas fa-check-circle nav-icon"></i>
                                <p>Active</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="/senaraiAhli?status=Suspend"
                                class="nav-link {{ request()->is('senaraiAhli') && request()->status == 'Suspend' ? 'active' : '' }}">
                                <i class="fas fa-exclamation-circle nav-icon"></i>
                                <p>Suspend</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="/senaraiAhli?status=Banned"
                                class="nav-link {{ request()->is('senaraiAhli') && request()->status == 'Banned' ? 'active' : '' }}">
                                <i class="fas fa-times-circle nav-icon"></i>
                                <p>Ban</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="/senaraiAhli?license=No"
                                class="nav-link {{ request()->is('senaraiAhli') && request()->license == 'No' ? 'active' : '' }}">
                                <i class="fas fa-check-circle nav-icon"></i>
                                <p>No License</p>
                            </a>
                        </li>
                    </ul>
                </li>
                {{-- <li class="nav-item">
                    <a href="/pengesahan-keahlian"
                        class="nav-link {{ request()->is('pengesahan-keahlian') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-shield"></i>
                        <p>
                            Pengesahan Keahlian
                        </p>
                    </a>
                </li> --}}
                <li class="nav-item">
                    <a href="/users?id_level=2"
                        class="nav-link {{ request()->is('users') && request()->id_level == '2' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-tie"></i>
                        <p>
                            Cawangan
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/wallet" class="nav-link {{ request()->is('wallet') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-wallet"></i>
                        <p>
                            Payment Gateway
                        </p>
                    </a>
                </li>
            </ul>
            <!--COMPANY-->
        @elseif($level == 2)
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="true">
                <li class="nav-item">
                    <a href="{{ URL::to('homeCompany') }}"
                        class="nav-link {{ request()->is('homeCompany') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            Utama
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/pembayaran-cawangan"
                        class="nav-link {{ request()->is('pembayaran-cawangan') ? 'active' : '' }}">
                        <i class="fas fa-money-bill-wave nav-icon"></i>
                        <p>Pembayaran Cawangan</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ URL::to('companyDetail/' . Auth::user()->id) }}"
                        class="nav-link {{ request()->is('companyDetail/' . Auth::user()->id) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-building"></i>
                        <p>
                            Maklumat Cawangan
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ URL::to('maklumatJawatanKuasa') }}"
                        class="nav-link {{ request()->is('maklumatJawatanKuasa') ? 'active' : '' }}">
                        <!--<a href="{{ URL::to('/companyEquityBreakdownList') }}" class="nav-link">-->
                        <i class="nav-icon fas fa-file-invoice-dollar"></i>
                        <p>
                            Maklumat Jawatankuasa
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/senaraiAhli" class="nav-link {{ request()->is('senaraiAhli') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            Senarai Ahli
                        </p>
                    </a>
                </li>
                {{-- <li class="nav-item">
                    <a href="/pengesahan-keahlian"
                        class="nav-link {{ request()->is('pengesahan-keahlian') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-shield"></i>
                        <p>
                            Pengesahan Keahlian
                        </p>
                    </a>
                </li> --}}
                <li class="nav-item">
                    <a href="{{ URL::to('/setViewCertificate/1') }}" target="_blank"
                        class="nav-link {{ Route::currentRouteNamed('company.viewWorkers') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-certificate"></i>
                        <p>
                            Sijil Usia
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ URL::to('/profilDigitalCompany') }}"
                        class="nav-link {{ request()->is('profilDigitalCompany') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-qrcode"></i>
                        <p>
                            QR Jemputan
                        </p>
                    </a>
                </li>
                {{-- <li class="nav-item">
                    <a href="{{URL::to('/setViewCertificate/1')}}" target="_blank" class="nav-link {{ Route::currentRouteNamed('company.viewWorkers') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-certificate"></i>
                        <p>
                            Senarai Semak Keahlian
                        </p>
                    </a>
                </li> --}}

                @if ($sub_company == null)
                    <li
                        class="nav-item {{ request()->is('logCertificate') || request()->is('log_pembayaran_ahli') || request()->is('log_pendaftar_persatuan') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link">
                            <i class="nav-icon far fa-building"></i>
                            <p>
                                Log
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview offset-md-1">
                            <li class="nav-item">
                                <a href="{{ URL::to('/logCertificate') }}"
                                    class="nav-link {{ request()->is('logCertificate') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-history"></i>
                                    <p>
                                        Status Log
                                    </p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ URL::to('/log_pendaftar_persatuan') }}"
                                    class="nav-link {{ request()->is('log_pendaftar_persatuan') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-history"></i>
                                    <p>
                                        Log Pendaftar Persatuan
                                    </p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ URL::to('/log_pembayaran_ahli') }}"
                                    class="nav-link {{ request()->is('log_pembayaran_ahli') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-history"></i>
                                    <p>
                                        Log Pembayaran Ahli
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li
                        class="nav-item has-treeview {{ request()->is('setting_certificate') || request()->is('setting_terms_conditions') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-cog"></i>
                            <p>
                                Settings
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview offset-md-1" style="">
                            <li class="nav-item">
                                <a href="{{ URL::to('/setting_certificate') }}"
                                    class="nav-link {{ request()->is('setting_certificate') ? 'active' : '' }}">
                                    <i class="fas fa-certificate nav-icon"></i>
                                    <p class="">Certificate</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ URL::to('/setting_terms_conditions') }}"
                                    class="nav-link {{ request()->is('setting_terms_conditions') ? 'active' : '' }}">
                                    <i class="fas fa-certificate nav-icon"></i>
                                    <p class="">Terma & Syarat</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/wallet" class="nav-link {{ request()->is('wallet') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-wallet"></i>
                                    <p>
                                        Payment Gateway
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                @php
                    $user = Auth::user();
                    $DetailCompany = \App\Models\DetailCompany::where('id_user', $user->id)->first();

                @endphp

                @if (false)
                    <li class="nav-item">
                        @if ($DetailCompany->status_certificate_approval == 'APPROVED' && $DetailCompany->certificate_file == 1)
                            <a href="/setViewCertificate/1" class="nav-link" target="_blank">
                                <i class="nav-icon fas fa-certificate"></i>
                                <p>
                                    View Certificate
                                </p>
                            </a>
                        @endif
                    </li>
                @endif
            </ul>
            <!--MANPOWER-->
        @elseif($level == 3)
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="true">

                <li class="nav-item">
                    <a href="{{ URL::to('homeManPower') }}"
                        class="nav-link {{ Route::currentRouteNamed('homeManPower') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            Utama
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ URL::to('status-approval') }}"
                        class="nav-link {{ Route::currentRouteNamed('status-approval') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-clipboard-check"></i>
                        <p>Status Approval</p>
                    </a>
                </li>


                <li class="nav-item {{ request()->is('personalDetail' . Auth::user()->id) ? '' : 'menu-open' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-user"></i>
                        <p>
                            Maklumat Anda
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview offset-md-1">
                        <li class="nav-item">
                            <a href="{{ URL::to('personalDetail/' . Auth::user()->id) }}"
                                class="nav-link {{ request()->is('personalDetail/' . Auth::user()->id) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-id-card"></i><i class=""></i>
                                <p>
                                    Peribadi
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ URL::to('employmentDetail/' . Auth::user()->id) }}"
                                class="nav-link {{ request()->is('employmentDetail/' . Auth::user()->id) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-graduation-cap"></i>
                                <p>
                                    Pendidikan
                                </p>
                            </a>
                        </li>
                        {{-- <li class="nav-item">
                            <a href="{{ URL::to('maklumatPerniagaan/' . Auth::user()->id) }}"
                                class="nav-link {{ request()->is('maklumatPerniagaan/' . Auth::user()->id) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-shopping-bag"></i>
                                <p>
                                    Perniagaan
                                </p>
                            </a>
                        </li> --}}
                        {{-- <li class="nav-item">
                            <a href="{{ URL::to('maklumatProduk') }}"
                                class="nav-link {{ request()->is('maklumatProduk') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-shopping-bag"></i>
                                <p>
                                    Produk
                                </p>
                            </a>
                        </li> --}}
                        {{-- <li class="nav-item">
                            <a href="{{ URL::to('kerjasamaAgensi') }}"
                                class="nav-link {{ request()->is('kerjasamaAgensi') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-shopping-bag"></i>
                                <p>
                                    Kerjasama Agensi
                                </p>
                            </a>
                        </li> --}}
                    </ul>
                </li>

                <li class="nav-item {{ request()->is('personalDetail' . Auth::user()->id) ? '' : 'menu-open' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-file-download"></i>
                        <p>
                            Muat Turun
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview offset-md-1">
                        @if ($status_approval == true || $status_approval == 1)
                            <li class="nav-item">
                                <a href="{{ URL::to('/setViewCertificate/1') }}" target="_blank"
                                    class="nav-link {{ request()->is('certificate/' . Auth::user()->id) ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-certificate"></i>
                                    <p>
                                        Sijil Pendaftaran
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ URL::to('/sijilCawangan') }}"
                                    class="nav-link {{ request()->is('sijilCawangan') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-certificate"></i>
                                    <p>
                                        Sijil Cawangan
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ URL::to('/companyCard') }}"
                                    class="nav-link {{ request()->is('companyCard') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-id-card"></i>
                                    <p>
                                        Kad Keahlian
                                    </p>
                                </a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a href="{{ URL::to('/profilDigital') }}"
                                class="nav-link {{ request()->is('profilDigital') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-qrcode"></i>
                                <p>
                                    QR Profil Digital
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li
                    class="nav-item {{ request()->is('logCertificate') || request()->is('log_pembayaran') || request()->is('log_pendaftar_persatuan') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon far fa-building"></i>
                        <p>
                            Log
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview offset-md-1">
                        <li class="nav-item">
                            <a href="{{ URL::to('/log-pembayaran-keahlian?type=register') }}"
                                class="nav-link {{ request()->fullUrl() === URL::to('/log-pembayaran-keahlian?type=register') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-history"></i>
                                <p>Pendaftaran</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ URL::to('/log-pembayaran-keahlian?type=renewal') }}"
                                class="nav-link {{ request()->fullUrl() === URL::to('/log-pembayaran-keahlian?type=renewal') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-history"></i>
                                <p>Renewal</p>
                            </a>
                        </li>
                        {{-- <li class="nav-item">
                            <a href="{{ URL::to('/logCertificate') }}"
                                class="nav-link {{ request()->is('logCertificate') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-history"></i>
                                <p>
                                    Status Log
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ URL::to('/log_pendaftar_persatuan') }}"
                                class="nav-link {{ request()->is('log_pendaftar_persatuan') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-history"></i>
                                <p>
                                    Log Pendaftar Persatuan
                                </p>
                            </a>
                        </li> --}}

                        {{-- <li class="nav-item">
                            <a href="{{ URL::to('/log_pembayaran') }}"
                                class="nav-link {{ request()->is('log_pembayaran') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-history"></i>
                                <p>
                                    Log Pembayaran Ahli
                                </p>
                            </a>
                        </li> --}}
                        {{-- <li class="nav-item">
                            <a href="{{ URL::to('/log-pembayaran-keahlian') }}"
                                class="nav-link {{ Route::currentRouteNamed('log.pembayaran.keahlian') ? 'active' : '' }}">
                                <i class="fas fa-receipt nav-icon"></i>
                                <p>Log Pembayaran Keahlian</p>
                            </a>
                        </li> --}}
                    </ul>
                </li>

            </ul>
        @endif
        <br><br><br><br>
    </nav>
</div>
