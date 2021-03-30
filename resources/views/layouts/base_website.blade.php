@php
date_default_timezone_set("Asia/Bangkok");//set you countary name from below timezone list
@endphp
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Vuexy admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Vuexy admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
    <title>@yield('title') - Obor App</title>
    <link rel="apple-touch-icon" href="{{ asset('images/favicon.jpg') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/favicon.jpg') }}">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/charts/apexcharts.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/tables/datatable/datatables.min.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/forms/select/select2.min.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/extensions/sweetalert2.min.css">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="/app-assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/components.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/themes/dark-layout.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/themes/semi-dark-layout.css">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="/app-assets/css/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/core/colors/palette-gradient.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/pages/dashboard-ecommerce.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/pages/card-analytics.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/plugins/forms/validation/form-validation.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/plugins/forms/wizard.css">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="/assets/css/style.css">
    <!-- END: Custom CSS-->

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern 2-columns  navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">

    <!-- BEGIN: Header-->
    <nav class="header-navbar navbar-expand-lg navbar navbar-with-menu floating-nav navbar-light navbar-shadow">
        <div class="navbar-wrapper">
            <div class="navbar-container content">
                <div class="navbar-collapse" id="navbar-mobile">
                    <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
                        <!-- <ul class="nav navbar-nav">
                            <li class="nav-item mobile-menu d-xl-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ficon feather icon-menu"></i></a></li>
                        </ul>
                        <ul class="nav navbar-nav bookmark-icons"> -->
                            <!-- li.nav-item.mobile-menu.d-xl-none.mr-auto-->
                            <!--   a.nav-link.nav-menu-main.menu-toggle.hidden-xs(href='#')-->
                            <!--     i.ficon.feather.icon-menu-->
                            <!-- <li class="nav-item d-none d-lg-block"><a class="nav-link" href="app-todo.html" data-toggle="tooltip" data-placement="top" title="Todo"><i class="ficon feather icon-check-square"></i></a></li>
                            <li class="nav-item d-none d-lg-block"><a class="nav-link" href="app-chat.html" data-toggle="tooltip" data-placement="top" title="Chat"><i class="ficon feather icon-message-square"></i></a></li>
                            <li class="nav-item d-none d-lg-block"><a class="nav-link" href="app-email.html" data-toggle="tooltip" data-placement="top" title="Email"><i class="ficon feather icon-mail"></i></a></li>
                            <li class="nav-item d-none d-lg-block"><a class="nav-link" href="app-calender.html" data-toggle="tooltip" data-placement="top" title="Calendar"><i class="ficon feather icon-calendar"></i></a></li> -->
                        <!-- </ul>
                        <ul class="nav navbar-nav">
                            <li class="nav-item d-none d-lg-block"><a class="nav-link bookmark-star"><i class="ficon feather icon-star warning"></i></a>
                                <div class="bookmark-input search-input">
                                    <div class="bookmark-input-icon"><i class="feather icon-search primary"></i></div>
                                    <input class="form-control input" type="text" placeholder="Explore Vuexy..." tabindex="0" data-search="template-list">
                                    <ul class="search-list search-list-bookmark"></ul>
                                </div> -->
                                <!-- select.bookmark-select-->
                                <!--   option Chat-->
                                <!--   option email-->
                                <!--   option todo-->
                                <!--   option Calendar-->
                            <!-- </li>
                        </ul> -->
                    </div>
                    <ul class="nav navbar-nav float-right">
                        <li class="nav-item d-none d-lg-block"><a class="nav-link nav-link-expand"><i class="ficon feather icon-maximize"></i></a></li>
                        <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                                <div class="user-nav d-sm-flex d-none"><span class="user-name text-bold-600">{{ Auth::user()->name }}</span><span class="user-status">@if( Auth::user()->role == 0 ) Super Admin @elseif( Auth::user()->role == 1 ) Admin @elseif( Auth::user()->role == 2 ) Marketing @elseif( Auth::user()->role == 3 ) Staf Gudang @else Admin Royalti @endif</span></div><span><img class="round" src="{{ Avatar::create(Auth::user()->name)->toBase64() }}" alt="avatar" height="40" width="40"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="#" data-toggle="modal" data-target="#modalChangePassword"><i class="feather icon-user"></i> Change Password</a>
                                <div class="dropdown-divider"></div>
                                <form class="dropdown-item" method="POST" action="{{ route('logout') }}">
                                    {{ csrf_field() }}
                                    <button class="button-like-a" type="submit"><i class="feather icon-power"></i> Logout</button>
                                </form>
                                <!-- <a class="dropdown-item" href="{{ route('logout') }}">
                                <i class="feather icon-power"></i> Logout</a> -->
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <ul class="main-search-list-defaultlist d-none">
        <li class="d-flex align-items-center"><a class="pb-25" href="#">
                <h6 class="text-primary mb-0">Files</h6>
            </a></li>
        <li class="auto-suggestion d-flex align-items-center cursor-pointer"><a class="d-flex align-items-center justify-content-between w-100" href="#">
                <div class="d-flex">
                    <div class="mr-50"><img src="/app-assets/images/icons/xls.png" alt="png" height="32"></div>
                    <div class="search-data">
                        <p class="search-data-title mb-0">Two new item submitted</p><small class="text-muted">Marketing Manager</small>
                    </div>
                </div><small class="search-data-size mr-50 text-muted">&apos;17kb</small>
            </a></li>
        <li class="auto-suggestion d-flex align-items-center cursor-pointer"><a class="d-flex align-items-center justify-content-between w-100" href="#">
                <div class="d-flex">
                    <div class="mr-50"><img src="/app-assets/images/icons/jpg.png" alt="png" height="32"></div>
                    <div class="search-data">
                        <p class="search-data-title mb-0">52 JPG file Generated</p><small class="text-muted">FontEnd Developer</small>
                    </div>
                </div><small class="search-data-size mr-50 text-muted">&apos;11kb</small>
            </a></li>
        <li class="auto-suggestion d-flex align-items-center cursor-pointer"><a class="d-flex align-items-center justify-content-between w-100" href="#">
                <div class="d-flex">
                    <div class="mr-50"><img src="/app-assets/images/icons/pdf.png" alt="png" height="32"></div>
                    <div class="search-data">
                        <p class="search-data-title mb-0">25 PDF File Uploaded</p><small class="text-muted">Digital Marketing Manager</small>
                    </div>
                </div><small class="search-data-size mr-50 text-muted">&apos;150kb</small>
            </a></li>
        <li class="auto-suggestion d-flex align-items-center cursor-pointer"><a class="d-flex align-items-center justify-content-between w-100" href="#">
                <div class="d-flex">
                    <div class="mr-50"><img src="/app-assets/images/icons/doc.png" alt="png" height="32"></div>
                    <div class="search-data">
                        <p class="search-data-title mb-0">Anna_Strong.doc</p><small class="text-muted">Web Designer</small>
                    </div>
                </div><small class="search-data-size mr-50 text-muted">&apos;256kb</small>
            </a></li>
        <li class="d-flex align-items-center"><a class="pb-25" href="#">
                <h6 class="text-primary mb-0">Members</h6>
            </a></li>
        <li class="auto-suggestion d-flex align-items-center cursor-pointer"><a class="d-flex align-items-center justify-content-between py-50 w-100" href="#">
                <div class="d-flex align-items-center">
                    <div class="avatar mr-50"><img src="/app-assets/images/portrait/small/avatar-s-8.jpg" alt="png" height="32"></div>
                    <div class="search-data">
                        <p class="search-data-title mb-0">John Doe</p><small class="text-muted">UI designer</small>
                    </div>
                </div>
            </a></li>
        <li class="auto-suggestion d-flex align-items-center cursor-pointer"><a class="d-flex align-items-center justify-content-between py-50 w-100" href="#">
                <div class="d-flex align-items-center">
                    <div class="avatar mr-50"><img src="/app-assets/images/portrait/small/avatar-s-1.jpg" alt="png" height="32"></div>
                    <div class="search-data">
                        <p class="search-data-title mb-0">Michal Clark</p><small class="text-muted">FontEnd Developer</small>
                    </div>
                </div>
            </a></li>
        <li class="auto-suggestion d-flex align-items-center cursor-pointer"><a class="d-flex align-items-center justify-content-between py-50 w-100" href="#">
                <div class="d-flex align-items-center">
                    <div class="avatar mr-50"><img src="/app-assets/images/portrait/small/avatar-s-14.jpg" alt="png" height="32"></div>
                    <div class="search-data">
                        <p class="search-data-title mb-0">Milena Gibson</p><small class="text-muted">Digital Marketing Manager</small>
                    </div>
                </div>
            </a></li>
        <li class="auto-suggestion d-flex align-items-center cursor-pointer"><a class="d-flex align-items-center justify-content-between py-50 w-100" href="#">
                <div class="d-flex align-items-center">
                    <div class="avatar mr-50"><img src="/app-assets/images/portrait/small/avatar-s-6.jpg" alt="png" height="32"></div>
                    <div class="search-data">
                        <p class="search-data-title mb-0">Anna Strong</p><small class="text-muted">Web Designer</small>
                    </div>
                </div>
            </a></li>
    </ul>
    <ul class="main-search-list-defaultlist-other-list d-none">
        <li class="auto-suggestion d-flex align-items-center justify-content-between cursor-pointer"><a class="d-flex align-items-center justify-content-between w-100 py-50">
                <div class="d-flex justify-content-start"><span class="mr-75 feather icon-alert-circle"></span><span>No results found.</span></div>
            </a></li>
    </ul>
    <!-- END: Header-->


    <!-- BEGIN: Main Menu-->
    <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
        <div class="navbar-header mb-3">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mr-auto">
                    <a class="navbar-brand m-1 ml-3" href="{{ route('admin.dashboard') }}">
                        <img src="{{ asset('images/logo.png') }}" style="height: 120px; width: auto">
                        <!-- <h2 class="brand-text mb-0">Vuexy</h2> -->
                    </a>
                </li>
                <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="feather icon-x d-block d-xl-none font-medium-4 primary toggle-icon"></i><i class="toggle-icon feather icon-disc font-medium-4 d-none d-xl-block collapse-toggle-icon primary" data-ticon="icon-disc"></i></a></li>
            </ul>
        </div>
        <div class="shadow-bottom"></div>
        <div class="main-menu-content">
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                <li class=" nav-item @if(trim($__env->yieldContent('dashboard')) == 1) echo active @endif">
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="feather icon-home"></i>
                        <span class="menu-title" data-i18n="Ecommerce">Dashboard</span>
                    </a>
                </li>
                <li class=" nav-item">
                    <a href="#">
                        <i class="feather icon-clipboard"></i>
                        <span class="menu-title" data-i18n="Ecommerce">Master Data</span>
                    </a>
                    <ul class="menu-content">
                        @if(Auth::user()->role === 0 || Auth::user()->role === 1 || Auth::user()->role === 4)
                        <li @if(trim($__env->yieldContent('pengarang')) == 1) class="active" @endif>
                            <a href="{{ route('admin.master.pengarang.list') }}">
                                <i class="feather icon-circle"></i>
                                <span class="menu-item" data-i18n="Shop">Pengarang</span>
                            </a>
                        </li>
                        @endif
                        @if(Auth::user()->role === 0 || Auth::user()->role === 1)
                        <li @if(trim($__env->yieldContent('penerjemah')) == 1) class="active" @endif>
                            <a href="{{ route('admin.master.penerjemah.list') }}">
                                <i class="feather icon-circle"></i>
                                <span class="menu-item" data-i18n="Shop">Penerjemah</span>
                            </a>
                        </li>
                        <li @if(trim($__env->yieldContent('kategori')) == 1) class="active" @endif>
                            <a href="{{ route('admin.master.kategori.list') }}">
                                <i class="feather icon-circle"></i>
                                <span class="menu-item" data-i18n="Shop">Kategori</span>
                            </a>
                        </li>
                        <li @if(trim($__env->yieldContent('penerbit')) == 1) class="active" @endif>
                            <a href="{{ route('admin.master.penerbit.list') }}">
                                <i class="feather icon-circle"></i>
                                <span class="menu-item" data-i18n="Shop">Penerbit</span>
                            </a>
                        </li>
                        <li @if(trim($__env->yieldContent('supplier')) == 1) class="active" @endif>
                            <a href="{{ route('admin.master.supplier.list') }}">
                                <i class="feather icon-circle"></i>
                                <span class="menu-item" data-i18n="Shop">Supplier</span>
                            </a>
                        </li>
                        <li @if(trim($__env->yieldContent('distributor')) == 1) class="active" @endif>
                            <a href="{{ route('admin.master.distributor.list') }}">
                                <i class="feather icon-circle"></i>
                                <span class="menu-item" data-i18n="Shop">Distributor</span>
                            </a>
                        </li>
                        @endif
                        @if(Auth::user()->role === 3 || Auth::user()->role === 0)
                        <li @if(trim($__env->yieldContent('lokasi')) == 1) class="active" @endif>
                            <a href="{{ route('admin.master.lokasi.list') }}">
                                <i class="feather icon-circle"></i>
                                <span class="menu-item" data-i18n="Shop">Lokasi Gudang</span>
                            </a>
                        </li>
                        @endif
                        @if(Auth::user()->role === 1 || Auth::user()->role === 2 || Auth::user()->role === 0)
                        <li @if(trim($__env->yieldContent('salesman')) == 1) class="active" @endif>
                            <a href="{{ route('admin.master.salesman.list') }}">
                                <i class="feather icon-circle"></i>
                                <span class="menu-item" data-i18n="Shop">Salesman</span>
                            </a>
                        </li>
                        <li @if(trim($__env->yieldContent('pelanggan')) == 1) class="active" @endif>
                            <a href="{{ route('admin.master.pelanggan.list') }}">
                                <i class="feather icon-circle"></i>
                                <span class="menu-item" data-i18n="Shop">Pelanggan</span>
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>
                <li class=" nav-item">
                    <a href="#">
                        <i class="feather icon-package"></i>
                        <span class="menu-title" data-i18n="Ecommerce">Inventori</span>
                    </a>
                    <ul class="menu-content">
                        @if(Auth::user()->role === 0 || Auth::user()->role === 1 || Auth::user()->role === 3 || Auth::user()->role === 2)
                        <li @if(trim($__env->yieldContent('indukbuku')) == 1) class="active" @endif>
                            <a href="{{ route('admin.inventori.induk-buku.list') }}">
                                <i class="feather icon-circle"></i>
                                <span class="menu-item" data-i18n="Shop">Data Induk Buku</span>
                            </a>
                        </li>
                        @endif
                        @if(Auth::user()->role === 0 || Auth::user()->role === 2)
                        <li @if(trim($__env->yieldContent('belibuku')) == 1) class="active" @endif>
                            <a href="{{ route('admin.inventori.pembelian-buku.list') }}">
                                <i class="feather icon-circle"></i>
                                <span class="menu-item" data-i18n="Shop">Pembelian Buku</span>
                            </a>
                        </li>
                        @endif
                        @if(Auth::user()->role === 0 || Auth::user()->role === 2 || Auth::user()->role === 1)
                        <li @if(trim($__env->yieldContent('jualbuku')) == 1) class="active" @endif>
                            <a href="{{ route('admin.inventori.penjualan-buku.list') }}">
                                <i class="feather icon-circle"></i>
                                <span class="menu-item" data-i18n="Shop">Penjualan Buku</span>
                            </a>
                        </li>
                        @endif
                        @if(Auth::user()->role === 0 || Auth::user()->role === 1)
                        <li @if(trim($__env->yieldContent('returbeli')) == 1) class="active" @endif>
                            <a href="{{ route('admin.inventori.retur-pembelian.list') }}">
                                <i class="feather icon-circle"></i>
                                <span class="menu-item" data-i18n="Shop">Retur Pembelian Buku</span>
                            </a>
                        </li>
                        <li @if(trim($__env->yieldContent('returjual')) == 1) class="active" @endif>
                            <a href="{{ route('admin.inventori.retur-penjualan.list') }}">
                                <i class="feather icon-circle"></i>
                                <span class="menu-item" data-i18n="Shop">Retur Penjualan Buku</span>
                            </a>
                        </li>
                        @endif
                        @if(Auth::user()->role === 0 || Auth::user()->role === 1 || Auth::user()->role === 3)
                        <li @if(trim($__env->yieldContent('konsinyasi')) == 1) class="active" @endif>
                            <a href="{{ route('admin.faktur.konsinyasi.list') }}">
                                <i class="feather icon-circle"></i>
                                <span class="menu-item" data-i18n="Shop">Faktur Konsinyasi</span>
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>
                @if(Auth::user()->role === 0 || Auth::user()->role === 1 || Auth::user()->role === 2)
                <li class=" nav-item">
                    <a href="#">
                        <i class="feather icon-dollar-sign"></i>
                        <span class="menu-title" data-i18n="Ecommerce">Hutang & Piutang</span>
                    </a>
                    <ul class="menu-content">
                        <li @if(trim($__env->yieldContent('debithutang')) == 1) class="active" @endif>
                            <a href="{{ route('admin.hutang-piutang.debit-hutang.list') }}">
                                <i class="feather icon-circle"></i>
                                <span class="menu-item" data-i18n="Shop">Hutang</span>
                            </a>
                        </li>
                        <li @if(trim($__env->yieldContent('debitpiutang')) == 1) class="active" @endif>
                            <a href="{{ route('admin.hutang-piutang.debit-piutang.list') }}">
                                <i class="feather icon-circle"></i>
                                <span class="menu-item" data-i18n="Shop">Piutang</span>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif
                @if(Auth::user()->role === 0 || Auth::user()->role === 1 || Auth::user()->role === 2)
                <li @if(trim($__env->yieldContent('bukubesar')) == 1) class="active nav-item" @else class=" nav-item" @endif>
                    <a href="#">
                        <i class="feather icon-book-open"></i>
                        <span class="menu-title" data-i18n="Ecommerce">Buku Besar</span>
                    </a>
                    <ul class="menu-content">
                        <li @if(trim($__env->yieldContent('laporankeuangan')) == 1) class="active" @endif>
                            <a href="{{ route('admin.buku-besar.laporan-keuangan') }}">
                                <i class="feather icon-circle"></i>
                                <span class="menu-item" data-i18n="Shop">Laporan Keuangan</span>
                            </a>
                        </li>
                        <li @if(trim($__env->yieldContent('dataaccount')) == 1) class="active" @endif>
                            <a href="{{ route('admin.buku-besar.data-account.list') }}">
                                <i class="feather icon-circle"></i>
                                <span class="menu-item" data-i18n="Shop">Data Account</span>
                            </a>
                        </li>
                        <li @if(trim($__env->yieldContent('kaslain2')) == 1) class="active" @endif>
                            <a href="{{ route('admin.buku-besar.kas-lain2.showCreateForm') }}">
                                <i class="feather icon-circle"></i>
                                <span class="menu-item" data-i18n="Shop">Input Kas Lain-lain</span>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif
                @if(Auth::user()->role === 0 || Auth::user()->role === 1)
                <li class=" nav-item @if(trim($__env->yieldContent('user')) == 1) echo active @endif">
                    <a href="{{ route('admin.user.list') }}">
                        <i class="feather icon-user"></i>
                        <span class="menu-title" data-i18n="Ecommerce">Data Akun</span>
                    </a>
                </li>
                @endif
            </ul>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modalChangePassword" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Change Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.user.change-password') }}" method="POST">
                {{ csrf_field() }}
                <input type="hidden" name="id" value="{{ Auth::user()->id }}">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="">Password Lama</label>
                                <div class="controls">
                                    <input type="password" name="password_old" class="form-control" data-validation-required-message="This field is required" placeholder="Old Password">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Password</label>
                                <div class="controls">
                                    <input type="password" name="password" class="form-control" minlength="8" data-validation-required-message="This field is required" placeholder="New Password">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Password Confirmation</label>
                                <div class="controls">
                                    <input type="password" name="password_confirmation" data-validation-match-match="password" class="form-control" data-validation-required-message="Repeat password must match" placeholder="Repeat New Password">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Ubah</button>
                </div>
            </form>
        </div>
    </div>
    </div>
    <!-- END: Main Menu-->

    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                @yield('content')
            </div>
        </div>
    </div>
    <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    <!-- BEGIN: Footer-->
    <footer class="footer footer-static footer-light">
        <p class="clearfix blue-grey lighten-2 mb-0">
            <span class="float-md-left d-block d-md-inline-block mt-25">COPYRIGHT &copy; 2021 Hefaistech
            </span>
            <span class="float-md-right d-none d-md-block">Under Development
            </span>
            <button class="btn btn-primary btn-icon scroll-top" type="button"><i class="feather icon-arrow-up"></i></button>
        </p>
    </footer>
    <!-- END: Footer-->


    <!-- BEGIN: Vendor JS-->
    <script src="/app-assets/vendors/js/vendors.min.js"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="/app-assets/vendors/js/charts/apexcharts.min.js"></script>
    <script src="/app-assets/vendors/js/forms/validation/jqBootstrapValidation.js"></script>
    <script src="/app-assets/vendors/js/tables/datatable/pdfmake.min.js"></script>
    <script src="/app-assets/vendors/js/tables/datatable/vfs_fonts.js"></script>
    <script src="/app-assets/vendors/js/tables/datatable/datatables.min.js"></script>
    <script src="/app-assets/vendors/js/tables/datatable/datatables.buttons.min.js"></script>
    <script src="/app-assets/vendors/js/tables/datatable/buttons.html5.min.js"></script>
    <script src="/app-assets/vendors/js/tables/datatable/buttons.print.min.js"></script>
    <script src="/app-assets/vendors/js/tables/datatable/buttons.bootstrap.min.js"></script>
    <script src="/app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js"></script>
    <script src="/app-assets/vendors/js/extensions/jquery.steps.min.js"></script>
    <script src="/app-assets/vendors/js/forms/validation/jquery.validate.min.js"></script>
    <script src="/app-assets/vendors/js/forms/select/select2.full.min.js"></script>
    <script src="/app-assets/vendors/js/extensions/sweetalert2.all.min.js"></script>
    <script src="/app-assets/js/scripts/extensions/sweet-alerts.js"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="/app-assets/js/core/app-menu.js"></script>
    <script src="/app-assets/js/core/app.js"></script>
    <script src="/app-assets/js/scripts/components.js"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="/app-assets/js/scripts/pages/dashboard-ecommerce.js"></script>
    <script src="/app-assets/js/scripts/forms/validation/form-validation.js"></script>
    <script src="/app-assets/js/scripts/datatables/datatable.js"></script>
    <script src="/app-assets/js/scripts/forms/wizard-steps.js"></script>
    <script src="/app-assets/js/scripts/forms/select/form-select2.js"></script>
    <!-- END: Page JS-->

    <script>
        $('#type-success').on('click', function () {
            Swal.fire({
            title: "Good job!",
            text: "You clicked the button!",
            type: "success",
            confirmButtonClass: 'btn btn-primary',
            buttonsStyling: false,
            });
        });
    </script>

    <!-- Untuk Induk Buku -->
    <script>
    $(function () {
        $('#country_pengarang').on('change', function () {
            if($(this).val() == 101){
                $('#kelurahan_pengarang').val('').prop('disabled', false);
                $('#kecamatan_pengarang').val('').prop('disabled', false);
                $('#kota_pengarang').val('').prop('disabled', false);
                $('#select2-kota_pengarang-container').text("== Pilih kota ==");
                $('#nik_pengarang').val('').prop('disabled', false);
                $('#npwp_pengarang').val('').prop('disabled', false);
                $('#kode_pengarang').val('').prop('disabled', false);
            }else{
                $('#select2-kelurahan_pengarang-container').text("");
                $('#kelurahan_pengarang').val('').prop('disabled', true);
                $('#select2-kecamatan_pengarang-container').text("");
                $('#kecamatan_pengarang').val('').prop('disabled', true);
                $('#select2-kota_pengarang-container').text("");
                $('#kota_pengarang').val('').prop('disabled', true);
                $('#nik_pengarang').val('').prop('disabled', true);
                $('#npwp_pengarang').val('').prop('disabled', true);
                $('#kode_pengarang').val('').prop('disabled', true);
            }
        });
    });
    </script>
    <script>
        $("#opt_pengarang").change(function() {
            $.ajax({
                url: '../../../admin/master/pengarang/info/' + $(this).val(),
                type: 'get',
                data: {},
                success: function(data) {
                    if (data.success == true) {
                        $('#nm_pengarang').val(data.info.nm_pengarang).prop('disabled', true);
                        $('#email_pengarang').val(data.info.email).prop('disabled', true);
                        $('#telepon_pengarang').val(data.info.telepon).prop('disabled', true);
                        $('#npwp_pengarang').val(data.info.NPWP).prop('disabled', true);
                        $('#nik_pengarang').val(data.info.NIK).prop('disabled', true);
                        $('#select2-country_pengarang-container').text(data.info.negara.name);
                        $('#country_pengarang').prop('disabled', true);
                        if(data.info.tb_negara_id == 101){
                            $('#select2-kelurahan_pengarang-container').text(data.info.kelurahan.name);
                            $('#kelurahan_pengarang').prop('disabled', true);
                            // $('#kelurahan_pengarang').val(data.info.kelurahan).prop('disabled', true);
                            $('#select2-kecamatan_pengarang-container').text(data.info.kecamatan.name);
                            $('#kecamatan_pengarang').prop('disabled', true);
                            // $('#kecamatan_pengarang').val(data.info.kecamatan).prop('disabled', true);
                            $('#select2-kota_pengarang-container').text(data.info.kota.name);
                            $('#kota_pengarang').prop('disabled', true);
                            // $('#kota_pengarang').val(data.info.kota).prop('disabled', true);   
                        }
                        $('#kode_pengarang').val(data.info.kode_pos).prop('disabled', true);
                        $('#alamat_pengarang').val(data.info.alamat).prop('disabled', true);
                        $('#persen_royalti_pengarang').val(data.info.persen_royalti).prop('disabled', true);
                        $('#nama_rek_pengarang').val(data.info.nama_rekening).prop('disabled', true);
                        $('#bank_rek_pengarang').val(data.info.bank_rekening).prop('disabled', true);
                        $('#no_rek_pengarang').val(data.info.nomor_rekening).prop('disabled', true);
                    }
                },
                error: function() {
                    $('#nm_pengarang').val('').prop('disabled', false);
                    $('#email_pengarang').val('').prop('disabled', false);
                    $('#telepon_pengarang').val('').prop('disabled', false);
                    $('#npwp_pengarang').val('').prop('disabled', false);
                    $('#nik_pengarang').val('').prop('disabled', false);
                    $('#select2-country_pengarang-container').text('== Pilih Negara ==');
                    $('#country_pengarang').prop('disabled', false);
                    $('#select2-kelurahan_pengarang-container').text('== Pilih Kelurahan ==');
                    $('#kelurahan_pengarang').prop('disabled', false);
                    // $('#kelurahan_pengarang').val('').prop('disabled', false);
                    $('#select2-kecamatan_pengarang-container').text('== Pilih Kecamatan ==');
                    $('#kecamatan_pengarang').prop('disabled', false);
                    // $('#kecamatan_pengarang').val('').prop('disabled', false);
                    $('#select2-kota_pengarang-container').text('== Pilih Kota ==');
                    $('#kota_pengarang').prop('disabled', false);
                    // $('#kota_pengarang').val('').prop('disabled', false);
                    $('#kode_pengarang').val('').prop('disabled', false);
                    $('#alamat_pengarang').val('').prop('disabled', false);
                    $('#persen_royalti_pengarang').val('').prop('disabled', false);
                    $('#nama_rek_pengarang').val('').prop('disabled', false);
                    $('#bank_rek_pengarang').val('').prop('disabled', false);
                    $('#no_rek_pengarang').val('').prop('disabled', false);
                }
            });
        });
    </script>
    <script>
        $("#opt_penerbit").change(function() {
            $.ajax({
                url: '../../../admin/master/penerbit/info/' + $(this).val(),
                type: 'get',
                data: {},
                success: function(data) {
                    if (data.success == true) {
                        $('#nm_penerbit').val(data.info.nm_penerbit).prop('disabled', true);
                        $('#email_penerbit').val(data.info.email).prop('disabled', true);
                        $('#telepon_penerbit').val(data.info.telepon).prop('disabled', true);
                        $('#npwp_penerbit').val(data.info.NPWP).prop('disabled', true);
                        $('#select2-kelurahan_penerbit-container').text(data.info.kelurahan.name);
                        $('#kelurahan_penerbit').prop('disabled', true);
                        // $('#kelurahan_penerbit').val(data.info.kelurahan).prop('disabled', true);
                        $('#select2-kecamatan_penerbit-container').text(data.info.kecamatan.name);
                        $('#kecamatan_penerbit').prop('disabled', true);
                        // $('#kecamatan_penerbit').val(data.info.kecamatan).prop('disabled', true);
                        $('#select2-kota_penerbit-container').text(data.info.kota.name);
                        $('#kota_penerbit').prop('disabled', true);
                        // $('#kota_penerbit').val(data.info.kota).prop('disabled', true);
                        $('#kode_penerbit').val(data.info.kode_pos).prop('disabled', true);
                        $('#alamat_penerbit').val(data.info.alamat).prop('disabled', true);
                    }
                },
                error: function() {
                    $('#nm_penerbit').val('').prop('disabled', false);
                    $('#email_penerbit').val('').prop('disabled', false);
                    $('#telepon_penerbit').val('').prop('disabled', false);
                    $('#npwp_penerbit').val('').prop('disabled', false);
                    $('#select2-kelurahan_penerbit-container').text('== Pilih Kelurahan ==');
                    $('#kelurahan_penerbit').prop('disabled', false);
                    // $('#kelurahan_penerbit').val('').prop('disabled', false);
                    $('#select2-kecamatan_penerbit-container').text('== Pilih Kecamatan ==');
                    $('#kecamatan_penerbit').prop('disabled', false);
                    // $('#kecamatan_penerbit').val('').prop('disabled', false);
                    $('#select2-kota_penerbit-container').text('== Pilih Kota ==');
                    $('#kota_penerbit').prop('disabled', false);
                    // $('#kota_penerbit').val('').prop('disabled', false);
                    $('#kode_penerbit').val('').prop('disabled', false);
                    $('#alamat_penerbit').val('').prop('disabled', false);
                }
            });
        });
    </script>
    <script>
        $("#opt_penerjemah").change(function() {
            $.ajax({
                url: '../../../admin/master/penerjemah/info/' + $(this).val(),
                type: 'get',
                data: {},
                success: function(data) {
                    if (data.success == true) {
                        $('#nm_penerjemah').val(data.info.nm_penerjemah).prop('disabled', true);
                        $('#email_penerjemah').val(data.info.email).prop('disabled', true);
                        $('#telepon_penerjemah').val(data.info.telepon).prop('disabled', true);
                        $('#npwp_penerjemah').val(data.info.NPWP).prop('disabled', true);
                        $('#select2-kelurahan_penerjemah-container').text(data.info.kelurahan.name);
                        $('#kelurahan_penerjemah').prop('disabled', true);
                        // $('#kelurahan_penerjemah').val(data.info.kelurahan).prop('disabled', true);
                        $('#select2-kecamatan_penerjemah-container').text(data.info.kecamatan.name);
                        $('#kecamatan_penerjemah').prop('disabled', true);
                        // $('#kecamatan_penerjemah').val(data.info.kecamatan).prop('disabled', true);
                        $('#select2-kota_penerjemah-container').text(data.info.kota.name);
                        $('#kota_penerjemah').prop('disabled', true);
                        // $('#kota_penerjemah').val(data.info.kota).prop('disabled', true);
                        $('#kode_penerjemah').val(data.info.kode_pos).prop('disabled', true);
                        $('#alamat_penerjemah').val(data.info.alamat).prop('disabled', true);
                    }
                },
                error: function() {
                    $('#nm_penerjemah').val('').prop('disabled', false);
                    $('#email_penerjemah').val('').prop('disabled', false);
                    $('#telepon_penerjemah').val('').prop('disabled', false);
                    $('#npwp_penerjemah').val('').prop('disabled', false);
                    $('#select2-kelurahan_penerjemah-container').text('== Pilih Kelurahan ==');
                    $('#kelurahan_penerjemah').prop('disabled', false);
                    // $('#kelurahan_penerjemah').val('').prop('disabled', false);
                    $('#select2-kecamatan_penerjemah-container').text('== Pilih Kecamatan ==');
                    $('#kecamatan_penerjemah').prop('disabled', false);
                    // $('#kecamatan_penerjemah').val('').prop('disabled', false);
                    $('#select2-kota_penerjemah-container').text('== Pilih Kota ==');
                    $('#kota_penerjemah').prop('disabled', false);
                    // $('#kota_penerjemah').val('').prop('disabled', false);
                    $('#kode_penerjemah').val('').prop('disabled', false);
                    $('#alamat_penerjemah').val('').prop('disabled', false);
                }
            });
        });
    </script>
    <script>
        $("#opt_distributor").change(function() {
            $.ajax({
                url: '../../../admin/master/distributor/info/' + $(this).val(),
                type: 'get',
                data: {},
                success: function(data) {
                    if (data.success == true) {
                        $('#nm_distributor').val(data.info.nm_distributor).prop('disabled', true);
                        $('#email_distributor').val(data.info.email).prop('disabled', true);
                        $('#telepon_distributor').val(data.info.telepon).prop('disabled', true);
                        $('#npwp_distributor').val(data.info.NPWP).prop('disabled', true);
                        $('#select2-kelurahan_distributor-container').text(data.info.kelurahan.name);
                        $('#kelurahan_distributor').prop('disabled', true);
                        // $('#kelurahan_distributor').val(data.info.kelurahan).prop('disabled', true);
                        $('#select2-kecamatan_distributor-container').text(data.info.kecamatan.name);
                        $('#kecamatan_distributor').prop('disabled', true);
                        // $('#kecamatan_distributor').val(data.info.kecamatan).prop('disabled', true);
                        $('#select2-kota_distributor-container').text(data.info.kota.name);
                        $('#kota_distributor').prop('disabled', true);
                        // $('#kota_distributor').val(data.info.kota).prop('disabled', true);
                        $('#kode_distributor').val(data.info.kode_pos).prop('disabled', true);
                        $('#alamat_distributor').val(data.info.alamat).prop('disabled', true);
                    }
                },
                error: function() {
                    $('#nm_distributor').val('').prop('disabled', false);
                    $('#email_distributor').val('').prop('disabled', false);
                    $('#telepon_distributor').val('').prop('disabled', false);
                    $('#npwp_distributor').val('').prop('disabled', false);
                    $('#select2-kelurahan_distributor-container').text("== Pilih kelurahan ==");
                    $('#kelurahan_distributor').prop('disabled', false);
                    // $('#kelurahan_distributor').val('').prop('disabled', false);
                    $('#select2-kecamatan_distributor-container').text("== Pilih kecamatan ==");
                    $('#kecamatan_distributor').prop('disabled', false);
                    // $('#kecamatan_distributor').val('').prop('disabled', false);
                    $('#select2-kota_distributor-container').text("== Pilih kota ==");
                    $('#kota_distributor').prop('disabled', false);
                    // $('#kota_distributor').val('').prop('disabled', false);
                    $('#kode_distributor').val('').prop('disabled', false);
                    $('#alamat_distributor').val('').prop('disabled', false);
                }
            });
        });
    </script>
    <script>
    $(function () {
        $('#kota_pengarang').on('change', function () {
            $.ajax({
                url: '../../../../admin/dependent-dropdown/district/' + $(this).val(),
                method: 'get',
                data: {},
                success: function (response) {
                    $('#kecamatan_pengarang').empty();

                    $.each(response, function (id, name) {
                        $('#kecamatan_pengarang').append(new Option(name, id))
                    })
                }
            })
        });
    });
    </script>
    <script>
    $(function () {
        $('#kecamatan_pengarang').on('change', function () {
            $.ajax({
                url: '../../../../admin/dependent-dropdown/village/' + $(this).val(),
                method: 'get',
                data: {},
                success: function (response) {
                    $('#kelurahan_pengarang').empty();

                    $.each(response, function (id, name) {
                        $('#kelurahan_pengarang').append(new Option(name, id))
                    })
                }
            })
        });
    });
    </script>
    <script>
    $(function () {
        $('#kota_penerbit').on('change', function () {
            $.ajax({
                url: '../../../../admin/dependent-dropdown/district/' + $(this).val(),
                method: 'get',
                data: {},
                success: function (response) {
                    $('#kecamatan_penerbit').empty();

                    $.each(response, function (id, name) {
                        $('#kecamatan_penerbit').append(new Option(name, id))
                    })
                }
            })
        });
    });
    </script>
    <script>
    $(function () {
        $('#kecamatan_penerbit').on('change', function () {
            $.ajax({
                url: '../../../../admin/dependent-dropdown/village/' + $(this).val(),
                method: 'get',
                data: {},
                success: function (response) {
                    $('#kelurahan_penerbit').empty();

                    $.each(response, function (id, name) {
                        $('#kelurahan_penerbit').append(new Option(name, id))
                    })
                }
            })
        });
    });
    </script>
    <script>
    $(function () {
        $('#kota_penerjemah').on('change', function () {
            $.ajax({
                url: '../../../../admin/dependent-dropdown/district/' + $(this).val(),
                method: 'get',
                data: {},
                success: function (response) {
                    $('#kecamatan_penerjemah').empty();

                    $.each(response, function (id, name) {
                        $('#kecamatan_penerjemah').append(new Option(name, id))
                    })
                }
            })
        });
    });
    </script>
    <script>
    $(function () {
        $('#kecamatan_penerjemah').on('change', function () {
            $.ajax({
                url: '../../../../admin/dependent-dropdown/village/' + $(this).val(),
                method: 'get',
                data: {},
                success: function (response) {
                    $('#kelurahan_penerjemah').empty();

                    $.each(response, function (id, name) {
                        $('#kelurahan_penerjemah').append(new Option(name, id))
                    })
                }
            })
        });
    });
    </script>
    <script>
    $(function () {
        $('#kota_distributor').on('change', function () {
            $.ajax({
                url: '../../../../admin/dependent-dropdown/district/' + $(this).val(),
                method: 'get',
                data: {},
                success: function (response) {
                    $('#kecamatan_distributor').empty();

                    $.each(response, function (id, name) {
                        $('#kecamatan_distributor').append(new Option(name, id))
                    })
                }
            })
        });
    });
    </script>
    <script>
    $(function () {
        $('#kecamatan_distributor').on('change', function () {
            $.ajax({
                url: '../../../../admin/dependent-dropdown/village/' + $(this).val(),
                method: 'get',
                data: {},
                success: function (response) {
                    $('#kelurahan_distributor').empty();

                    $.each(response, function (id, name) {
                        $('#kelurahan_distributor').append(new Option(name, id))
                    })
                }
            })
        });
    });
    </script>
    <!-- Untuk beli buku -->
    <script>
        $("#opt_supplier").change(function() {
            $.ajax({
                url: '../../../admin/master/supplier/info/' + $(this).val(),
                type: 'get',
                data: {},
                success: function(data) {
                    if (data.success == true) {
                        $('#nm_perusahaan').val(data.info.nm_perusahaan).prop('disabled', true);
                        $('#nm_supplier').val(data.info.nm_supplier).prop('disabled', true);
                        $('#telepon_supplier').val(data.info.telepon).prop('disabled', true);
                        $('#select2-village-container').text(data.info.kelurahan.name);
                        $('#village').prop('disabled', true);
                        // $('#kelurahan_supplier').val(data.info.kelurahan).prop('disabled', true);
                        $('#select2-district-container').text(data.info.kecamatan.name);
                        $('#district').prop('disabled', true);
                        // $('#kecamatan_supplier').val(data.info.kecamatan).prop('disabled', true);
                        $('#select2-city-container').text(data.info.kota.name);
                        $('#city').prop('disabled', true);
                        // $('#kota_supplier').val(data.info.kota).prop('disabled', true);
                        $('#kode_supplier').val(data.info.kode_pos).prop('disabled', true);
                        $('#alamat_supplier').val(data.info.alamat).prop('disabled', true);
                    }
                },
                error: function() {
                    $('#nm_perusahaan').val('').prop('disabled', false);
                    $('#nm_supplier').val('').prop('disabled', false);
                    $('#telepon_supplier').val('').prop('disabled', false);
                    $('#select2-village-container').text("== Pilih kelurahan ==");
                    $('#village').prop('disabled', false);
                    // $('#kelurahan_supplier').val('').prop('disabled', false);
                    $('#select2-district-container').text("== Pilih kecamatan ==");
                    $('#district').prop('disabled', false);
                    // $('#kecamatan_supplier').val('').prop('disabled', false);
                    $('#select2-city-container').text("== Pilih kota ==");
                    $('#city').prop('disabled', false);
                    // $('#kota_supplier').val('').prop('disabled', false);
                    $('#kode_supplier').val('').prop('disabled', false);
                    $('#alamat_supplier').val('').prop('disabled', false);
                }
            });
        });
    </script>
    <!-- Digunakan jual buku juga -->

    <script>
        $("#opt_buku").change(function() {
            $.ajax({
                url: '../../../admin/inventori/induk-buku/info/' + $(this).val(),
                type: 'get',
                data: {},
                success: function(data) {
                    if (data.success == true) {
                        $("#qty_beli").prop('max', data.info.stock.qty);
                        $("#harga_satuan_beli").val(data.info.harga_jual);
                        $("#status_jual").val(data.info.is_obral);
                    }
                },
                error: function() {
                }
            });
        });
    </script>
    <script>
        $('#qty_beli').keyup(function() {
            var formatter = new Intl.NumberFormat('id-ID');
            var quantity = $("#qty_beli").val();
            var discount = $("#diskon").val();
            var iPrice = $("#harga_satuan_beli").val();
            if(discount !== undefined){
                var harga_diskon = (discount * (quantity * iPrice)) / 100;
                var total = (quantity * iPrice) - harga_diskon;
            }else{
                var total = quantity * iPrice;
            }

            $("#total_harga_beli").val(formatter.format(total)); // sets the total price input to the quantity * price
        });
    </script>
    <script>
        $('#harga_satuan_beli').keyup(function() {
            var formatter = new Intl.NumberFormat('id-ID');
            var quantity = $("#qty_beli").val();
            var discount = $("#diskon").val();
            var iPrice = $("#harga_satuan_beli").val();

            if(discount !== undefined){
                var harga_diskon = (discount * (quantity * iPrice)) / 100;
                var total = (quantity * iPrice) - harga_diskon;
            }else{
                var total = quantity * iPrice;
            }
            $("#total_harga_beli").val(formatter.format(total)); // sets the total price input to the quantity * price
        });
    </script>

    <!-- Hanya jual buku -->
    <script>
        $('#diskon').keyup(function() {
            var formatter = new Intl.NumberFormat('id-ID');
            var quantity = $("#qty_beli").val();
            var discount = $("#diskon").val();
            var iPrice = $("#harga_satuan_beli").val();

            var harga_diskon = (discount * (quantity * iPrice)) / 100;

            var total = (quantity * iPrice) - harga_diskon;

            $("#total_harga_beli").val(formatter.format(total)); // sets the total price input to the quantity * price
        });
    </script>
    <script>
        $("#opt_pelanggan").change(function() {
            $.ajax({
                url: '../../../admin/master/pelanggan/info/' + $(this).val(),
                type: 'get',
                data: {},
                success: function(data) {
                    if (data.success == true) {
                        $('#nm_pelanggan').val(data.info.nama).prop('disabled', true);
                        $('#email_pelanggan').val(data.info.email).prop('disabled', true);
                        $('#telepon_pelanggan').val(data.info.telepon).prop('disabled', true);
                        $('#select2-village-container').text(data.info.kelurahan.name);
                        $('#village').prop('disabled', true);
                        // $('#kelurahan_pelanggan').val(data.info.kelurahan).prop('disabled', true);
                        $('#select2-district-container').text(data.info.kecamatan.name);
                        $('#district').prop('disabled', true);
                        // $('#kecamatan_pelanggan').val(data.info.kecamatan).prop('disabled', true);
                        $('#select2-city-container').text(data.info.kota.name);
                        $('#city').prop('disabled', true);
                        // $('#kota_pelanggan').val(data.info.kota).prop('disabled', true);
                        $('#alamat_pelanggan').val(data.info.alamat).prop('disabled', true);
                        $('#tanggal_lahir_pelanggan').val(data.info.tanggal_lahir).prop('disabled', true);
                        $('#diskon_pelanggan').val(data.info.discount).prop('disabled', true);
                        $('#diskon').val(data.info.discount);
                    }
                },
                error: function() {
                    $('#nm_pelanggan').val('').prop('disabled', false);
                    $('#email_pelanggan').val('').prop('disabled', false);
                    $('#telepon_pelanggan').val('').prop('disabled', false);
                    $('#select2-village-container').text("== Pilih kelurahan ==");
                    $('#village').prop('disabled', false);
                    // $('#kelurahan_supplier').val('').prop('disabled', false);
                    $('#select2-district-container').text("== Pilih kecamatan ==");
                    $('#district').prop('disabled', false);
                    // $('#kecamatan_supplier').val('').prop('disabled', false);
                    $('#select2-city-container').text("== Pilih kota ==");
                    $('#city').prop('disabled', false);
                    $('#alamat_pelanggan').val('').prop('disabled', false);
                    $('#tanggal_lahir_pelanggan').val('').prop('disabled', false);
                    $('#diskon_pelanggan').val('').prop('disabled', false);
                    $('#diskon').val('0');
                }
            });
        });
    </script>
    <script>
        $("#diskon_pelanggan").change(function() {
            $('#diskon').val($(this).val());
        });
    </script>
    <script>
        $("#opt_salesman").change(function() {
            $.ajax({
                url: '../../../admin/master/salesman/info/' + $(this).val(),
                type: 'get',
                data: {},
                success: function(data) {
                    if (data.success == true) {
                        $('#nm_salesman').val(data.info.nama).prop('disabled', true);
                    }
                },
                error: function() {
                    $('#nm_salesman').val('').prop('disabled', false);
                }
            });
        });
    </script>

    <!-- Untuk retur jual -->
    <script>
        $('#qty_retur').keyup(function() {
            var formatter = new Intl.NumberFormat('id-ID');
            var quantity = $(this).val();
            $.ajax({
                url: '../../../admin/inventori/penjualan-buku/info/' + $("#opt_penjualan").val(),
                type: 'get',
                data: {},
                success: function(data) {
                    if (data.success == true) {
                        var discount = data.info.discount;
                        $('#diskon_retur').val(data.info.discount);
                        $('#diskon_retur_act').val(data.info.discount);
                        var iPrice = data.info.harga_jual_satuan;
                        $('#harga_retur_satuan').val(formatter.format(data.info.harga_jual_satuan));
                        $('#harga_retur_satuan_act').val(data.info.harga_jual_satuan);
                        if(discount !== 0){
                            var harga_diskon = (discount * (quantity * iPrice)) / 100;
                            var total = (quantity * iPrice) - harga_diskon;
                        }else{
                            var total = quantity * iPrice;
                        }
                        $("#total_harga_retur").val(formatter.format(total)); // sets the total price input to the quantity * price
                    }
                },
                error: function() {
                }
            });
        });
    </script>
    <script>
        $("#opt_penjualan").change(function() {
            $.ajax({
                url: '../../../admin/inventori/penjualan-buku/info/' + $(this).val(),
                type: 'get',
                data: {},
                success: function(data) {
                    if (data.success == true) {
                        $('#kode_buku_returjual').val(data.info.indukbuku.kode_buku);
                        $('#id_pelanggan_returjual').val(data.info.pelanggan.id_pelanggan);
                    }
                },
                error: function() {
                }
            });
        });
    </script>
    <script>
        $("#opt_penjualan").change(function() {
            var formatter = new Intl.NumberFormat('id-ID');
            $.ajax({
                url: '../../../admin/inventori/penjualan-buku/info/' + $(this).val(),
                type: 'get',
                data: {},
                success: function(data) {
                    if (data.success == true) {
                        $('#buku_jual').val(data.info.indukbuku.isbn + ' - ' + data.info.indukbuku.judul_buku);
                        $('#nm_pelanggan').val(data.info.pelanggan.nama);
                        if(data.info.salesman != undefined){
                            $('#nm_salesman').val(data.info.salesman.nama);
                        }else{
                            $('#nm_salesman').val('');
                        }
                        $('#qty_jual').val(data.info.qty);
                        var returjual = 0;
                        if(data.info.returdetail != undefined){
                            if(data.info.returdetail.length > 1){
                                data.info.returdetail.forEach(function(data) {
                                    returjual += data.qty;
                                });
                            }else if(data.info.returdetail.length == 1){
                                returjual += data.info.returdetail[0].qty;
                            }
                        }
                        $("#qty_retur").prop('max', data.info.qty - returjual);
                        $('#diskon_jual').val(formatter.format(data.info.discount));
                        $('#harga_satuan_jual').val(formatter.format(data.info.harga_jual_satuan));
                        $('#total_harga_jual').val(formatter.format(data.info.harga_total));
                        var quantity = 1
                        $('#qty_retur').val(quantity);
                        $('#diskon_retur').val(data.info.discount);
                        $('#diskon_retur_act').val(data.info.discount);
                        var discount = data.info.discount
                        $('#harga_retur_satuan').val(formatter.format(data.info.harga_jual_satuan));
                        $('#harga_retur_satuan_act').val(data.info.harga_jual_satuan);
                        var iPrice = data.info.harga_jual_satuan
                        if(discount !== 0){
                            var harga_diskon = (discount * (quantity * iPrice)) / 100;
                            var total = (quantity * iPrice) - harga_diskon;
                        }else{
                            var total = quantity * iPrice;
                        }
                        $("#total_harga_retur").val(formatter.format(total));
                        // $('#total_harga_jual').val(formatter.format(data.info.harga_total));
                        $('#status_jual').val(data.info.status_penjualan);
                        if(data.info.status_penjualan == 0){
                            $('#status_jual_act').val('Tunai');
                        }else{
                            $('#status_jual_act').val('Non Tunai');
                        }
                    }
                },
                error: function() {
                }
            });
        });
    </script>

    <!-- Untuk dependent dropdown kota, kecamatan dan kelurahan -->
    <script>
    $(function () {
        $('#city').on('change', function () {
            $.ajax({
                url: '../../../../admin/dependent-dropdown/district/' + $(this).val(),
                method: 'get',
                data: {},
                success: function (response) {
                    $('#district').empty();

                    $.each(response, function (id, name) {
                        $('#district').append(new Option(name, id))
                    })
                }
            })
        });
    });
    </script>
    <script>
    $(function () {
        $('#district').on('change', function () {
            $.ajax({
                url: '../../../../admin/dependent-dropdown/village/' + $(this).val(),
                method: 'get',
                data: {},
                success: function (response) {
                    $('#village').empty();

                    $.each(response, function (id, name) {
                        $('#village').append(new Option(name, id))
                    })
                }
            })
        });
    });
    </script>
    <!-- Untuk konsinyasi -->
    <script>
        $("#opt_penerimatitip").change(function() {
            $.ajax({
                url: '../../../admin/inventori/penerima-titip/info/' + $(this).val(),
                type: 'get',
                data: {},
                success: function(data) {
                    if (data.success == true) {
                        $('#nm_penerimatitip').val(data.info.nama).prop('disabled', true);
                        $('#email_penerimatitip').val(data.info.email).prop('disabled', true);
                        $('#telepon_penerimatitip').val(data.info.telepon).prop('disabled', true);
                        $('#select2-village-container').text(data.info.kelurahan.name);
                        $('#village').prop('disabled', true);
                        // $('#kelurahan_penerimatitip').val(data.info.kelurahan).prop('disabled', true);
                        $('#select2-district-container').text(data.info.kecamatan.name);
                        $('#district').prop('disabled', true);
                        // $('#kecamatan_penerimatitip').val(data.info.kecamatan).prop('disabled', true);
                        $('#select2-city-container').text(data.info.kota.name);
                        $('#city').prop('disabled', true);
                        // $('#kota_penerimatitip').val(data.info.kota).prop('disabled', true);
                        $('#alamat_penerimatitip').val(data.info.alamat).prop('disabled', true);
                    }
                },
                error: function() {
                    $('#nm_penerimatitip').val('').prop('disabled', false);
                    $('#email_penerimatitip').val('').prop('disabled', false);
                    $('#telepon_penerimatitip').val('').prop('disabled', false);
                    $('#kelurahan_penerimatitip').val('').prop('disabled', false);
                    $('#kecamatan_penerimatitip').val('').prop('disabled', false);
                    $('#kota_penerimatitip').val('').prop('disabled', false);
                    $('#alamat_penerimatitip').val('').prop('disabled', false);
                }
            });
        });
    </script>
    <!-- Untuk negara pengarang -->
    <script>
    $(function () {
        $('#country').on('change', function () {
            if($(this).val() == 101){
                $('#village').val('').prop('disabled', false);
                $('#district').val('').prop('disabled', false);
                $('#city').val('').prop('disabled', false);
                $('#select2-city-container').text("== Pilih kota ==");
                $('#nik').val('').prop('disabled', false);
                $('#npwp').val('').prop('disabled', false);
                $('#kode_pengarang').val('').prop('disabled', false);
            }else{
                $('#select2-village-container').text("");
                $('#village').val('').prop('disabled', true);
                $('#select2-district-container').text("");
                $('#district').val('').prop('disabled', true);
                $('#select2-city-container').text("");
                $('#city').val('').prop('disabled', true);
                $('#nik').val('').prop('disabled', true);
                $('#npwp').val('').prop('disabled', true);
                $('#kode_pengarang').val('').prop('disabled', true);
            }
        });
    });
    </script>
    <script>
        function readURLIMG(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#img-pre').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]); // convert to base64 string
        }
        }

        $("#imgInp").change(function() {
        readURLIMG(this);
        });
    </script>
    <script>
        function ValidateFileUpload() {
            var fuData = document.getElementById('imgInp');
            var FileUploadPath = fuData.value;
            var Extension = FileUploadPath.substring(FileUploadPath.lastIndexOf('.') + 1).toLowerCase();
            if (Extension == "png" || Extension == "jpeg" || Extension == "jpg") {
                if (fuData.files && fuData.files[0]) {
                    var size = fuData.files[0].size;

                    if(size > MAX_SIZE){
                        $("#imgInp").val("");
                        alert("Maximum file size is " + MAX_SIZE);
                    }
                }
            } 
            else {
                $("#imgInp").val(""); 
                alert("Photo only allows file types of PNG, JPG, JPEG. ");
            }
        }
    </script>
    @include('sweetalert::alert')
    @yield('page-js')

</body>
<!-- END: Body-->

</html>