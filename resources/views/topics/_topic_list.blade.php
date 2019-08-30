@if (count($topics))
    <ul class="list-unstyled">
        @foreach ($topics as $topic)
            <li class="media">
{{--                <div class="mb-4" style="max-width: 540px;">--}}
                <div class="mb-4" style="max-width: 100%;">
                    <div class="row no-gutters">
                        <div class="col-md-4">
{{--                            <img src="..." class="card-img" alt="...">--}}
                            <a href="{{ route('users.show', [$topic->user_id]) }}">
{{--                                <img class="media-object img-thumbnail mr-3" style="width: 52px; height: 52px;" src="{{ $topic->user->avatar }}" title="{{ $topic->user->name }}">--}}
                                <img class="media-object img-thumbnail mr-3" style="width: 100%; height: 100%;" src="{{ $topic->user->avatar }}" title="{{ $topic->user->name }}">
                            </a>
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <a href="{{ $topic->link() }}" title="{{ $topic->title }}">
                                        {{ $topic->title }}
                                    </a>
                                </h5>
                                <p class="card-text">
                                    This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.
                                </p>
                                <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                            </div>
                        </div>
                    </div>
                </div>
{{--                <div class="media-left">--}}
{{--                    <a href="{{ route('users.show', [$topic->user_id]) }}">--}}
{{--                        <img class="media-object img-thumbnail mr-3" style="width: 52px; height: 52px;" src="{{ $topic->user->avatar }}" title="{{ $topic->user->name }}">--}}
{{--                    </a>--}}
{{--                </div>--}}

{{--                <div class="media-body">--}}

{{--                    <div class="media-heading mt-0 mb-1">--}}
{{--                        <a href="{{ $topic->link() }}" title="{{ $topic->title }}">--}}
{{--                            {{ $topic->title }}--}}
{{--                        </a>--}}
{{--                        <a class="float-right" href="{{ $topic->link() }}">--}}
{{--                            <span class="badge badge-secondary badge-pill"> {{ $topic->reply_count }} </span>--}}
{{--                        </a>--}}
{{--                    </div>--}}

{{--                    <small class="media-body meta text-secondary">--}}

{{--                        <a class="text-secondary" href="{{ route('categories.show', $topic->category_id) }}" title="{{ $topic->category->name }}">--}}
{{--                            <i class="far fa-folder"></i>--}}
{{--                            {{ $topic->category->name }}--}}
{{--                        </a>--}}

{{--                        <span> • </span>--}}
{{--                        <a class="text-secondary" href="{{ route('users.show', [$topic->user_id]) }}" title="{{ $topic->user->name }}">--}}
{{--                            <i class="far fa-user"></i>--}}
{{--                            {{ $topic->user->name }}--}}
{{--                        </a>--}}
{{--                        <span> • </span>--}}
{{--                        <i class="far fa-clock"></i>--}}
{{--                        <span class="timeago" title="最后活跃于：{{ $topic->updated_at }}">{{ $topic->updated_at->diffForHumans() }}</span>--}}
{{--                    </small>--}}

{{--                </div>--}}
            </li>

            @if ( ! $loop->last)
                <hr>
            @endif

        @endforeach
    </ul>

@else
    <div class="empty-block">暂无数据 ~_~ </div>
@endif