<html lang="en" dir="ltr"
    style="--primary01:rgba(108, 95, 252, 0.1); --primary02:rgba(108, 95, 252, 0.2); --primary03:rgba(108, 95, 252, 0.3); --primary06:rgba(108, 95, 252, 0.6); --primary09:rgba(108, 95, 252, 0.9); --primary005:rgba(108, 95, 252, 0.05);">

@include('templates.partials.head')

<body class="app sidebar-mini ltr">
    <div class="horizontalMenucontainer">
        <!-- GLOBAL-LOADER -->
        <div id="global-loader" style="display: none;"> <img src="https://spruko.com/demo/sash/sash/assets/images/loader.svg" class="loader-img"
                alt="Loader"> </div> <!-- /GLOBAL-LOADER -->
        <!-- PAGE -->
        <div class="page">
            <div class="page-main">
                <!-- app-Header -->
                @include('templates.partials.header')
                <!--APP-SIDEBAR-->
                @include('templates.partials.sidebar')
                {{-- <div class="jumps-prevent" style="padding-top: 74px;"></div> --}}
                <!--app-content open-->
                <div class="main-content app-content mt-0">
                    <div class="side-app">
                        <!-- CONTAINER -->
                        <div class="main-container container-fluid">
                            <!-- PAGE-HEADER -->
                            <div class="page-header">
                                <h1 class="page-title">@yield('title')</h1>
                                <div>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="javascript:void(0)">@yield('pwd')</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">@yield('sub-pwd')</li>
                                    </ol>
                                </div>
                            </div> <!-- PAGE-HEADER END -->
                            <!-- ROW-1 OPEN -->
                            @yield('content')
                        </div> <!-- CONTAINER CLOSED -->
                    </div>
                </div>
                <!--app-content closed-->
            </div> <!-- Sidebar-right -->
            @include('templates.partials.footer')
        </div> <!-- BACK-TO-TOP --> <a href="#top" id="back-to-top"><i class="fa fa-angle-up"></i></a>
        @include('templates.partials.script')
    </div>
</body>

</html>