<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title','IT') - Laravel 个人博客</title>
    <meta name="description" content="@yield('description', setting('seo_description','个人学习记录博客'))" />
    <meta name="keyword" content="@yield('keyword', setting('seo_keyword', 'PHP,Laravel,后端,MySQL,文章'))" />
    <!-- css 样式 -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <style>
        /*返回顶部样式*/
        .back-to-top {
            background-color: #777;
            color: #eee;
            text-align: center;
            overflow: hidden;
            width: 46px;
            height: 46px;
            border: none;
            opacity: .8;
        }
        .back-to-top:hover{
            background-color:#333
        }
        @media screen and (min-width:992px){.back-to-top{bottom:80px}}
        .back-to-top {
            cursor: pointer;
            position: fixed;
            bottom: 80px;
            right: 30px;
            display: none;
        }
        #back-to-top > .fa{
            margin-left: -1px;
        }
    </style>
    @yield('styles')
</head>
<body>
    <div id="app" class="{{ route_class() }}-page">
        @include('layouts._header')
        <div class="container">
            @include('shared._messages')
            @yield('content')
        </div>
        @include('layouts._footer')
    </div>
    {{--返回顶部--}}
    <button id="back-to-top" href="#" data-toggle="tooltip" data-placement="left"  class="btn btn-primary btn-lg back-to-top" role="button" title="返回顶部" data-toggle="tooltip" data-placement="top">
        <i class="fa fa-chevron-up" aria-hidden="true"></i>
    </button>
    {{-- js --}}
    @if (app()->isLocal())
        @include('sudosu::user-selector')
    @endif
    <script src="{{ mix('js/app.js') }}"></script>
    <script src="http://cdn.bootcss.com/scrollup/2.4.0/jquery.scrollUp.min.js"></script>
    <script>
        $(document).ready(function(){
            var back_top = $('#back-to-top');
            back_top.tooltip({ boundary: 'window' });
            $(window).scroll(function () {
                if ($(this).scrollTop() > 50) {
                    $('#back-to-top').fadeIn();
                } else {
                    $('#back-to-top').fadeOut();
                }
            });
            // scroll body to 0px on click
            back_top.click(function () {
                // $('#back-to-top').tooltip('hide');
                $('body,html').animate({
                    scrollTop: 0
                }, 800);
                return false;
            });
            // $('#back-to-top').tooltip('show');


        });
    </script>
    @yield('scripts')
</body>
</html>
