<html lang="en" dir="ltr"
    style="--primary01:rgba(108, 95, 252, 0.1); --primary02:rgba(108, 95, 252, 0.2); --primary03:rgba(108, 95, 252, 0.3); --primary06:rgba(108, 95, 252, 0.6); --primary09:rgba(108, 95, 252, 0.9); --primary005:rgba(108, 95, 252, 0.05);">

@include('templates.partials.head')

<body class="app sidebar-mini ltr">
    <!-- BACKGROUND-IMAGE -->
    <div class="login-img">
        <!-- GLOABAL LOADER -->
        <div id="global-loader" style="display: none;"> <img src="{{asset('assets/images/loader.svg')}}" class="loader-img"
                alt="Loader"> </div> <!-- /GLOABAL LOADER -->
        <!-- PAGE -->
        <div class="page">
            <div class="">
                <!-- CONTAINER OPEN -->
                <div class="col col-login mx-auto mt-7">
                    {{-- <div class="text-center"> <a href="{{route('main')}}"><img src="{{asset('assets/images/logo.jpeg')}}" style="height: 130px"
                                class="header-brand-img" alt=""></a> </div> --}}
                </div>
                <div class="row">
                    <div class="col-3 mx-auto main-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="panel panel-primary">
                                    <div class="tab-menu-heading">
                                        <div class="tabs-menu1">
                                            <!-- Tabs -->
                                            <ul class="nav panel-tabs">
                                                <li class="mx-0 tab-login"><a href="#tab5" class="active"
                                                        data-bs-toggle="tab">Login</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="panel-body tabs-menu-body p-0 pt-5">
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="tab5">
                                                <form role="form" action="{{route('login')}}" method="POST">
                                                    @csrf
                                                    <div class="wrap-input100 input-group"><a
                                                        href="javascript:void(0)"
                                                        class="input-group-text bg-white text-muted"> <i
                                                            class="zmdi zmdi-email text-muted" aria-hidden="true"></i> </a>
                                                    <input class="input100 border-start-0 form-control ms-0 @error('email') is-invalid @enderror" type="text"
                                                        placeholder="email" value="{{ old('email') }}" name="email" autocomplete="off">
                                                        @error('email')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                <div class="wrap-input100 input-group" id="Password-toggle">
                                                    <a href="javascript:void(0)"
                                                        class="input-group-text bg-white text-muted"> <i
                                                            class="zmdi zmdi-eye text-muted" aria-hidden="true"></i> </a>
                                                    <input class="input100 border-start-0 form-control ms-0 @error('password') is-invalid @enderror" type="password" autocomplete="off"
                                                        placeholder="Password" name="password"> 
                                                    @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                    </div>
                                                <div class="container-login100-form-btn"> <button
                                                        class="login100-form-btn btn-primary" type="submit"> Login </button> </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- End PAGE -->
    </div> <!-- BACKGROUND-IMAGE CLOSED -->
    @include('templates.partials.script')
</body>

</html>