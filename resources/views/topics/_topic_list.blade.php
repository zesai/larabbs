@if (count($topics))
    <ul class="list-unstyled topic-ul-list">
        @foreach ($topics as $topic)
            <li class="media">
{{--                <div class="mb-4" style="max-width: 540px;">--}}
                <div class="mb-4" style="width: 100%;">
                    <div class="row no-gutters">
                        <div class="col-md-4">
{{--                            <img src="..." class="card-img" alt="...">--}}
                            <a href="{{ $topic->link() }}">
{{--                                <img class="media-object img-thumbnail mr-3" style="width: 52px; height: 52px;" src="{{ $topic->user->avatar }}" title="{{ $topic->user->name }}">--}}
                                <img class="media-object img-thumbnail mr-3" style="width:100%;height:178.33px;" src="{{ $topic->user->avatar }}" title="{{ $topic->user->name }}">
                            </a>
                        </div>
                        <div class="col-md-8">
                            <div class="card-body" style="height: 178.33px;">
                                <div class="topic-list-right" style="height: 30%;">
                                    <h5 class="card-title">
                                        <a href="{{ $topic->link() }}" title="{{ $topic->title }}">
                                            {{ $topic->title }}
                                        </a>
                                    </h5>
                                </div>
                                <div class="topic-list-right" style="height: 60%;">
                                    <p class="card-text">
                                        {{ $topic->excerpt }}
                                    </p>
                                </div>

                                <p class="card-text" style="height: 10%">
                                    <small class="media-body meta text-secondary">

                                        <a class="text-secondary" href="{{ route('categories.show', $topic->category_id) }}" title="{{ $topic->category->name }}">
                                            <i class="far fa-folder"></i>
                                            {{ $topic->category->name }}
                                        </a>
                                        <span class="divider"> &nbsp;&nbsp;/&nbsp;&nbsp; </span>
                                        <a class="text-secondary" href="{{ route('users.show', [$topic->user_id]) }}" title="{{ $topic->user->name }}"><i class="far fa-user"></i> {{ $topic->user->name }}</a>
                                        <span class="divider"> &nbsp;&nbsp;/&nbsp;&nbsp; </span>
                                        <span class="timeago new-tooltip" data-toggle="tooltip" data-placement="bottom" title="最后活跃于：{{ $topic->updated_at }}"><i class="far fa-clock"></i> {{ $topic->updated_at->diffForHumans() }}</span>
                                        <span class="divider"> &nbsp;&nbsp;/&nbsp;&nbsp; </span>
                                        <span class="text-mute new-tooltip" data-toggle="tooltip" data-placement="bottom" title="阅读数"><i class="fa fa-eye" aria-hidden="true"></i> 609</span>
                                        <span class="divider"> &nbsp;&nbsp;/&nbsp;&nbsp; </span>
                                        <span class="text-mute new-tooltip" data-toggle="tooltip" data-placement="bottom" title="评论数: {{ $topic->reply_count }}"><i class="far fa-comment" aria-hidden="true"></i> {{ $topic->reply_count }}</span>
                                    </small>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </li>

            @if ( ! $loop->last)
                <hr>
            @endif

        @endforeach
    </ul>

@else
    <div class="empty-block">暂无数据 ~_~ </div>
@endif