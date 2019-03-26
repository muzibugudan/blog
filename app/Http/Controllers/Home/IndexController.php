<?php

namespace App\Http\Controllers\Home;

use App\Model\Article;
use App\Model\Cate;
use App\Model\Collect;
use App\Model\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    //前台首页
    public function index()
    {
//        获取相关二级类及二级类下的文章
       $cate_arts = Cate::where('cate_pid','<>',0)->with('article')->get();
        return view('home.index',compact('cate_arts'));
    }
    public function lists(Request $request,$id)
    {
      // 获取分类
      $cate=Cate::find($id);
      $cateid=$cate->cate_id;
      $catename=$cate->cate_name;

      // 筛选父id
      $arr=[];
      if($cate->cate_pid==0){
        $cate=Cate::where('cate_pid',$cate->cate_id)->get();
        // 将父类的id存入数组
        foreach ($cate as $v) {
          $arr[]=$v->cate_id;
        }
      }else{
          $arr[]=$cate->cate_id;
      }
      // 获取分类下的文章
      $arts=Article::whereIn('cate_id',$arr)->paginate(5);
      return view('home.lists',compact('catename','cateid','arts'));
    }
    public function detail(Request $request,$id)
    {
      //文章的查看次数+1
        \DB::table('article')
            ->where('art_id', $id)
            ->increment('art_view');

        $art = Article::with('cate')->where('art_id',$id)->first();

//        上一篇 下一篇
//        1 2 5  6 7 8
        $pre = Article::where('art_id','<',$id)->orderBy('art_id','desc')->first();
       // dd($pre);

        $next = Article::where('art_id','>',$id)->orderBy('art_id','asc')->first();


//        相关文章
        $similar = Article::where('cate_id',$art->cate_id)->take(4)->get();

//        文章评论
        $comment = Comment::where('post_id',$art->art_id)->get();
        return view('home.detail',compact('art','pre','next','similar','comment'));

    }
//    文章收藏
    public function collect(Request $request)
    {
//        1.获取ajax提交的数据
        $uid = $request->input('uid');
        $artid = $request->input('artid');
        $act = $request->input('act');

//        2.判断当前是收藏操作还是取消收藏操作
        switch($act){
//            收藏操作
            case 'add':
                //3.判断是否已经收藏过
               $collect = Collect::where([
                    ['uid','=',$uid],
                    ['art_id','=',$artid]
                ])->get();
               //未被收藏过了
               if($collect->isEmpty()){
                   //添加收藏记录
                    $res = Collect::create(['uid'=>$uid,'art_id'=>$artid]);
                    Article::where('art_id',$artid)->increment('art_collect');
                    //如果收藏成功
                    if($res){
                        return response()->json(['status'=>0,'msg'=>'已收藏']);
                    }else{
                        return response()->json(['status'=>1,'msg'=>'收藏失败']);
                    }
               }else{
                   return response()->json(['status'=>0,'msg'=>'已收藏']);
               }

                break;

            //取消收藏操作
            case 'remove':
                $collect = Collect::where([
                    ['uid','=',$uid],
                    ['art_id','=',$artid]
                ])->first();
                //已收藏
                if(!empty($collect)) {
                    //文章的收藏数量-1
                    Article::where('art_id',$artid)->decrement('art_collect');
//                    取消收藏
                  $res = $collect->delete();
                  if($res){
                      return response()->json(['status'=>0,'msg'=>'请收藏']);
                  }else{
                      return response()->json(['status'=>0,'msg'=>'取消收藏失败']);
                  }
                }else{
                    return response()->json(['status'=>0,'msg'=>'请收藏']);
                }
                break;
        }
    }
}
