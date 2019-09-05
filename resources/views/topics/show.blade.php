@extends('layouts.app')
@section('title', $topic->title)
@section('description', $topic->excerpt)
@section('styles')
    <link href="{{ asset('markdown/css/prism.css') }}" rel="stylesheet">
    <link href="{{ asset('markdown/css/fluidbox.min.css') }}" rel="stylesheet">
    <style>
        .left-box > div {
            margin-bottom: 10px;
        }
    </style>
@endsection
@section('content')
    <div class="row">

        <div class="col-lg-3 col-md-3 hidden-sm hidden-xs author-info left-box">
            @include('topics._left_author_info',['topic'=>$topic])
            <div class="card" id="left-title-box">
            </div>
        </div>

        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 topic-content">
            <div class="card ">
                <div class="card-body">

                    <h1 class="text-center mt-3 mb-3">
                        <div class="pull-left">
                            <i class="grey file text outline icon"></i>
                            <span style="line-height: 34px;">Elasticsearch 一些命令汇总 以及学习总结 </span>
                        </div>
                        <div class="clearfix"></div>
{{--                        {{ $topic->title }}--}}
                    </h1>

                    <p class="book-article-meta" style="margin-bottom: 10px;">

                        <a href="{{ route('categories.show', $topic->category->id) }}" title="分类" class="hide-on-mobile remove-padding-left"><i class="fa fa-folder" aria-hidden="true"></i> {{$topic->category->name}}</a>
                        <span class="divider hide-on-mobile">/</span>
                        <a class=" hide-on-mobile" href="#" title="作者">
                            <img class="ui image display-inline-block" style="width:16px;height:16px;margin-top:-2px;" src="{{ $topic->user->avatar }}"> {{ $topic->user->name }}
                        </a>
                        <span class="divider hide-on-mobile">/</span>
                        <a class="new-tooltip" data-inverted="" data-toggle="tooltip" title="{{ $topic->created_at }}" data-placement="bottom">
                            <i class="fa fa-clock-o" aria-hidden="true"></i>
                            <span title="{{ $topic->created_at }}">
                                {{ $topic->created_at->diffForHumans() }}
                            </span>
                        </a>
                        <span class="divider">/</span>
                        <span class="text-mute"><i class="fa fa-eye" aria-hidden="true"></i> 609</span>
                        <span class="divider">/</span>
                        <span class="text-mute"><i class="far fa-comment" aria-hidden="true"></i>
                        {{ $topic->reply_count }}</span>
                    </p>
                    <div class="ui divider"></div>

                    <div class="topic-body mt-4 mb-4">
                        {!! $topic->body !!}
                    </div>
                    @can('update', $topic)
                        <div class="operate">
                            <hr>
                            <a href="{{ route('topics.edit', $topic->id) }}" class="btn btn-outline-secondary btn-sm" role="button">
                                <i class="far fa-edit"></i> 编辑
                            </a>
                            <form action="{{ route('topics.destroy', $topic->id) }}" method="POST"
                                style="display: inline-block"
                                onclick="return confirm('确定要删除吗？');">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button type="submit" class="btn btn-outline-secondary btn-sm">
                                    <i class="far fa-trash-alt"></i> 删除
                                </button>
                            </form>
                        </div>
                    @endcan
                </div>
            </div>

            {{-- 用户回复列表 --}}
            <div class="card topic-reply mt-4">
                <div class="card-body">
                    @includeWhen(Auth::check(), 'topics._reply_box', ['topic' => $topic])
                    @include('topics._reply_list', ['replies' => $topic->replies()->with('user', 'topic')->get()])
                </div>
            </div>
        </div>
    </div>
@stop
@section('scripts')
    <script src="{{ asset('markdown/js/prism.js') }}"></script>
    <script src="{{ asset('markdown/js/jquery.min.js') }}"></script>
    <script src="{{ asset('markdown/js/jquery.ba-throttle-debounce.min.js') }}"></script>
    <script src="{{ asset('markdown/js/jquery.fluidbox.min.js') }}"></script>
    <script src="{{ asset('js/scrollfix.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('p img').wrap(function(){
                return '<a href="' + this.src + '" title="' + this.alt + '"></a>';
            });

            //文章图片点击放大
            $('a[title="file"]').fluidbox({
                stackIndex:990,
            });

            //文章标题栏
            $("h2,h3,h4,h5,h6").each(function(i,item){
                // var tag = $(item).get(0).localName;
                $(item).attr("id","title-"+i);
                // $(item).attr("class","list-group-item list-group-item-action list-group-item-light list-item-"+i+ ' new'+tag);
                // $(item).attr("href","#title-"+i+"");
                // $("#toc").append(item);

                $("#left-title-box").append('<a class="list-group-item list-group-item-action list-group-item-light list-item-'+i+'" href="#title-'+i+'" style="border: none">'+$(this).text()+'</a>');
                // $(".newh2").css("margin-left",0);
                // $(".newh3").css("margin-left",20);
                // $(".newh4").css("margin-left",40);
                // $(".newh5").css("margin-left",60);
                // $(".newh6").css("margin-left",80);
            });

            //左侧标题栏固定
            var fixtop = $("#left-title-box");
            fixtop.scrollFix({distanceTop:20});

        })
    </script>
@endsection