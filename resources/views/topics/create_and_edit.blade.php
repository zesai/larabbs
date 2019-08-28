@extends('layouts.app')
@section('styles')
     <link rel="stylesheet" href="{{ asset('simplemde/dist/simplemde.min.css') }}" type="text/css">
@stop

@section('content')
<div class="container">
  <div class="col-md-10 offset-md-1">
    <div class="card ">
        <div class="card-body">
            <h2 class="">
                <i class="far fa-edit"></i>
                @if($topic->id)
                    编辑话题
                @else
                    新建话题
                @endif
            </h2>
            <hr>
        @if($topic->id)
          <form action="{{ route('topics.update', $topic->id) }}" method="POST" accept-charset="UTF-8">
          <input type="hidden" name="_method" value="PUT">
        @else
          <form action="{{ route('topics.store') }}" method="POST" accept-charset="UTF-8">
        @endif

          @include('shared._error')

          <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">
              <input class="form-control" type="text" name="title" value="{{ old('title', $topic->title ) }}" placeholder="请填写标题" required />
            </div>
            <div class="form-group">
              <select class="form-control" name="category_id" required>
                  <option value="" hidden disabled selected>请选择</option>
                  @foreach($categories as $value)
                  <option value="{{ $value->id }}">{{ $value->name }}</option>
                  @endforeach
              </select>
            </div>
            <div class="form-group">
                <textarea name="body"
                          id="editor"
                          class="form-control"
                          rows="6"
                          placeholder="请填入至少三个字符的内容"
                          required
                    >{{ old('body', $topic->body ) }}</textarea>
            </div>
            <div class="well well-sm">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save mr-2" aria-hidden="true"></i>
                    保存
                </button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <script type="text/javascript" src="{{ asset('simplemde/dist/simplemde.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('markdown/js/inline-attachment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('markdown/js/codemirror-4.inline-attachment.min.js') }}"></script>


    <script>
        $(document).ready(function() {
            var simplemde = new SimpleMDE({
                autofocus: true,
                element: document.getElementById("editor"),
                spellChecker: false,
                autosave: {
                    enabled: true,
                    delay: 5000,
                    unique_id: "editor"
                },
                forceSync: true,
                toolbar: [
                    "bold", "italic", "heading", "|", "quote", "code", "table",
                    "horizontal-rule", "unordered-list", "ordered-list", "|",
                    "link", "image", "|", "side-by-side", 'fullscreen', "|",
                    {
                        name: "guide",
                        action: function customFunction(editor) {
                            var win = window.open('https://github.com/riku/Markdown-Syntax-CN/blob/master/syntax.md', '_blank');
                            if (win) {
                                //Browser has allowed it to be opened
                                win.focus();
                            } else {
                                //Browser has blocked it
                                alert('Please allow popups for this website');
                            }
                        },
                        className: "fa fa-info-circle",
                        title: "Markdown 语法！"
                    }
                ],
            });

            // 在已有的 simplemde 对象的基础上再增加图片拖拽
            inlineAttachment.editors.codemirror4.attach(simplemde.codemirror, {
                // 传递 CSRF token
                extraParams: {
                    '_token': "{{ csrf_token() }}",
                },

                // 设置图片上传的地址
                uploadUrl: '{{ route('topics.upload_image') }}',

                // 上传之后的处理
                onFileUploadResponse: function(xhr) {

                    var result = JSON.parse(xhr.responseText),
                        filename = result.file_path;
                    if (result && filename) {
                        var newValue;
                        if (typeof this.settings.urlText === 'function') {
                            newValue = this.settings.urlText.call(this, filename, result);
                        } else {
                            newValue = this.settings.urlText.replace(this.filenameTag, filename);
                        }
                        var text = this.editor.getValue().replace(this.lastValue, newValue);
                        this.editor.setValue(text);
                        this.settings.onFileUploaded.call(this, filename);
                    }
                    return false;
                }
            });
        });
    </script>
@stop
