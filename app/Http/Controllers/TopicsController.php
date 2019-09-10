<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use App\Markdown\Markdown;
use App\Markdown\Parser;
use App\Models\Category;
use App\Models\Link;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\TopicRequest;
use Auth;
use Illuminate\Support\Facades\Cache;

class TopicsController extends Controller
{
    protected $markdown;

    public function __construct(Markdown $markdown)
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
        $this->markdown = $markdown;
    }

    /**
     * 话题首页
     * @param Request $request
     * @param Topic $topic
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
	public function index(Request $request, Topic $topic, User $user, Link $link)
	{
        $topics = $topic->withOrder($request->order)->paginate(20);

        //获取活跃用户
        $active_users = $user->getActiveUsers();
        //获取推荐资源
        $links = $link->getAllCached();
		return view('topics.index', compact('topics', 'active_users', 'links'));
	}

    /**
     * 显示文章
     * @param Request $request
     * @param Topic $topic
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Request $request, Topic $topic)
    {
        if ( ! empty($topic->slug) && $topic->slug != $request->slug) {
            return redirect($topic->link(), 301);
        }

        $topic->body = $this->markdown->toHtml($topic->body);
        return view('topics.show', compact('topic') );
    }

    /**
     * 显示话题创建页
     * @param Topic $topic
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
	public function create(Topic $topic)
	{
	    $categories = Category::all();
		return view('topics.create_and_edit', compact('topic','categories'));
	}

    /**
     * 创建话题
     * @param TopicRequest $request
     * @param Topic $topic
     * @return \Illuminate\Http\RedirectResponse
     */
	public function store(TopicRequest $request, Topic $topic)
	{
        $topic->fill($request->all());
        $topic->user_id = Auth::id();
        $topic->save();
		return redirect()->to($topic->link())->with('message', '帖子创建成功');
	}

    /**
     * 修改话题页
     * @param Topic $topic
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
	public function edit(Topic $topic)
	{
        $this->authorize('update', $topic);
        $categories = Category::all();
		return view('topics.create_and_edit', compact('topic','categories'));
	}

    /**
     * 修改话题
     * @param TopicRequest $request
     * @param Topic $topic
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
	public function update(TopicRequest $request, Topic $topic)
	{
		$this->authorize('update', $topic);
		$topic->update($request->all());

		return redirect()->to($topic->link())->with('message', '更新成功');
	}

    /**
     * 删除话题
     * @param Topic $topic
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
	public function destroy(Topic $topic)
	{
		$this->authorize('destroy', $topic);
		$topic->delete();

		return redirect()->route('topics.index')->with('success', '删除成功');
	}

    /**
     * 编辑器上传文件
     * @param Request $request
     * @param ImageUploadHandler $uploader
     * @return array
     */
	public function uploadImage(Request $request, ImageUploadHandler $uploader)
    {
        //初始化返回数据,默认是失败的
        $data = [
            'success'   => false,
            'msg'       => '上传失败!',
            'file_path' => ''
        ];
        if ($file = $request->file){
            $result = $uploader->save($request->file, 'topics', \Auth::id(), 1024);
            if($result){
               $data['file_path']  = $result['path'];
               $data['msg']        = '上传成功!';
               $data['success']    = true;
            }
        }

        return $data;
    }
}
