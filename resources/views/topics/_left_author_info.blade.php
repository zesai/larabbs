<div class="card">
    <div class="card-body">
        <div class="text-center">
            作者：{{ $topic->user->name }}
        </div>
        <hr>
        <div class="media">
            <div align="center">
                <a href="{{ route('users.show', $topic->user->id) }}">
                    <img class="thumbnail img-fluid" src="{{ $topic->user->avatar }}" width="300px" height="300px">
                </a>
            </div>
        </div>
    </div>
</div>