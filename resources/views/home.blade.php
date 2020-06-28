@extends('layouts.master')

<head>
    <title>Trang Chủ | Admin Panel</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://www.google.com/recaptcha/api.js"></script>
</head>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="/">FDai Store</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="/">Trang Chủ
                    <span class="sr-only">(current)</span>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Danh Mục
                </a>

                <div class="dropdown-menu" id="navbarCate" aria-labelledby="navbarDropdownMenuLink">
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Thương Hiệu
                </a>
                <div class="dropdown-menu" id="navbarBrand" aria-labelledby="navbarDropdownMenuLink">
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Thông Tin</a>
            </li>
            <li class="nav-item" style="margin-left:70px">
                <form class="form-inline" action="{{route('search')}}" autocomplete="off" method="get" style="margin-bottom: 0px;">
                    <button type="submit" style="position: absolute;" class="btn btn-default"><i class="fa fa-search form-control-feedback" style="color:black !important;"></i></button>
                    <input class="form-control mr-sm-2" style="padding-left: 37px;" id="searchInput" name="key" type="search" placeholder="Tìm Sản Phẩm..." aria-label="Search" required oninvalid="this.setCustomValidity('Không được để trống')" oninput="setCustomValidity('')"></input>
                </form>
            </li>
            @if (Auth::user())
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Hello, {{Auth::user()->name}}
                </a>
                <div class="dropdown-menu" id="navbarBrand" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="{{route('logout')}}">Đăng Xuất</a>
                </div>
            </li>
            @else
            <li class="nav-item">
                <div class="row" style="margin:0px">
                    <a class="nav-link" href="" data-toggle="modal" data-target="#loginModal" style="padding-right: 0px;">Đăng Nhập</a>
                    <a class="nav-link">/</a>
                    <a class="nav-link" href="" data-toggle="modal" data-target="#signupModal" style="padding-left: 0px;">Đăng Ký</a>
                </div>
            </li>
            @endif
        </ul>
    </div>
    <div class=" link-icons">
        <a href="{{url('cart')}}">
            <i class="fa fa-shopping-cart"></i>
            <span>{{Cart::content()->count()}}</span>
        </a>
    </div>
</nav>

<!-- Modal đăng nhập -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Đăng Nhập</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="loginForm" class="form-horizontal">
                    <div class="form-group" style="display: none;" id="error">
                        <div class="col">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col">
                            <input type="text" name="name" id="loginInputName" placeholder="Enter username" class="form-control">
                            <div class="invalid-tooltip">
                                Tên đăng nhập không được để trống.
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col">
                            <input type="password" name="password" id="loginInputPass" placeholder="Enter pass" class="form-control">
                            <div class="invalid-tooltip">
                                Mật khẩu không được để trống.
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="loginSubmit" class="btn btn-primary">Đăng nhập</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Huỷ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal đăng ký -->
<div class="modal fade" id="signupModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Đăng Ký</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="signupForm" class="form-horizontal">
                    <div class="form-group">
                        <div class="form-group" style="display: block;" id="signupError">
                            <div class="col" style="color:red" id="signupErrors">
                            </div>
                        </div>
                        <div class="col">
                            <input type="text" name="name" placeholder="Enter username" id="signupInputName" class="form-control">
                            <div class="invalid-tooltip">
                                Tên đăng nhập không được để trống.
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col">
                            <input type="text" name="email" placeholder="Enter email" id="signupInputEmail" class="form-control">
                            <div class="invalid-tooltip">
                                Email không được để trống.
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col">
                            <input type="text" name="password" placeholder="Enter pass" id="signupInputPass" class="form-control">
                            <div class="invalid-tooltip" id="signupInputPassError">
                                Mật khẩu không được để trống.
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col">
                            <input type="text" name="passAgain" placeholder="Enter pass again" id="signupInputPassAgain" class="form-control">
                            <div class="invalid-tooltip" id="signupInputPassAgainError">
                                Nhập lại mật khẩu không được để trống.
                            </div>
                        </div>
                    </div>
                    <div class="g-recaptcha" data-sitekey="6LdWe6kZAAAAAIg6BP0fNMAEMG-fu9yC_FlzKS4g"></div>
                    <div class="modal-footer">
                        <button type="submit" id="signupSubmit" class="btn btn-primary">Đăng Ký</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Huỷ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@yield('body')

@include('layouts.footer')

<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // get and set data to dropdown menu
        $.get('http://127.0.0.1:8000/navbarData', function(data) {
            cate = '';
            data.categories.forEach(element => {
                cate += '<a class="dropdown-item" href="http://127.0.0.1:8000/category/' + element.name + '">' + element.name + '</a>';
            })
            $("#navbarCate").append(cate);
            bra = '';
            data.brands.forEach(element => {
                bra += '<a class="dropdown-item" href="http://127.0.0.1:8000/brand/' + element.name + '">' + element.name + '</a>';
            })
            $('#navbarBrand').append(bra);
        })

        // login
        $('#loginInputName').on('keyup', function(e) {
            $('#loginInputName').removeClass("is-invalid")
        });
        $('#loginInputPass').on('keyup', function(e) {
            $('#loginInputPass').removeClass("is-invalid")
        });
        $("#loginSubmit").click(function(e) {
            e.preventDefault()

            if ($('#loginInputName').val() == '' || $('#loginInputPass').val() == '') {
                if ($('#loginInputName').val() == '') {
                    $('#loginInputName').addClass("is-invalid")
                }
                if ($('#loginInputPass').val() == '') {
                    $('#loginInputPass').addClass("is-invalid")
                }
                return false
            }

            $.ajax({
                type: "POST",
                url: "{{route('login')}}",
                data: $("#loginForm").serialize(),
                success: function(data) {
                    if (data.status == 'success') {
                        location.reload();
                    } else {
                        $('#error').css('display', 'block')
                    }
                },
                error: function(data) {
                    alert(data);
                }
            });
        })

        // signup
        $("#signupInputName").keyup(function(e) {
            $("#signupInputName").removeClass("is-invalid")
        });
        $("#signupInputEmail").keyup(function(e) {
            $("#signupInputEmail").removeClass("is-invalid")
        });
        $("#signupInputPass").keyup(function(e) {
            $("#signupInputPass").removeClass("is-invalid")
        });
        $("#signupInputPassAgain").keyup(function(e) {
            $("#signupInputPassAgain").removeClass("is-invalid")
        });
        $('#signupSubmit').click(function(e) {
            e.preventDefault();

            if ($("#signupInputName").val() == "" || $("#signupInputEmail").val() == "" ||
                $("#signupInputPass").val() == "" || $("#signupInputPassAgain").val() == "") {
                if ($("#signupInputName").val() == "") {
                    $("#signupInputName").addClass("is-invalid")
                }
                if ($("#signupInputEmail").val() == "") {
                    $("#signupInputEmail").addClass("is-invalid")
                }
                if ($("#signupInputPass").val() == "") {
                    $("#signupInputPass").addClass("is-invalid")
                }
                if ($("#signupInputPassAgain").val() == "") {
                    $("#signupInputPassAgain").addClass("is-invalid")
                }
                return false
            }

            if ($("#signupInputPass").val() != $("#signupInputPassAgain").val()) {
                $("#signupInputPass").addClass("is-invalid")
                $("#signupInputPassError").html("Ủa??")
                $("#signupInputPassAgain").addClass("is-invalid")
                $("#signupInputPassAgainError").html("Sao không trùng nhau???")
                return false
            }

            if ($("#signupInputPass").val().length < 9) {
                $("#signupInputPass").addClass("is-invalid")
                $("#signupInputPassError").html("Mật khẩu phải trên 8 ký tự")
                return false
            }

            // if (grecaptcha.getResponse() == "") {
            //     $("#signupErrors").html("");
            //     $('#signupError').css('display', 'block')
            //     $("#signupErrors").append("Captcha nè");
            //     return false
            // }

            $.ajax({
                type: "POST",
                url: "{{route('signup')}}",
                data: $("#signupForm").serialize(),
                success: function(data) {
                    location.reload();
                },
                error: function(data, message, error) {
                    $('#signupErrors').html("")
                    json = $.parseJSON(data.responseText);
                    $.each(json.errors, function(key, value) {
                        $('#signupError').css('display', 'block')
                        $("#signupErrors").append("<li>" + value + "</li>");
                    });
                }
            });
        });

        //region --live search
        // error when type utf8 char
        // $('#searchInput').on('keyup', function(e) {
        //     keyword = $('#searchInput').val();
        //     if (!keyword == "") {
        //         $.get('search?key=' + keyword, function(data) {
        //             if (data.length > 0) {
        //                 append = '';
        //                 data.forEach(element => {
        //                     append += '<a href="product/' + element.name + '"><div>' + element.name + '</div></a>';
        //                 })
        //                 $('#items').html(append)
        //             } else {
        //                 $('#items').html('<div>Hông tìm thấy gì cả...</div>')
        //             }
        //         })
        //         console.log(keyword)
        //     } else {
        //         $('#items').html('')
        //     }
        // });
        //endregion
    });
</script>