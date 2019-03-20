<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<title>消息盒子</title>

<link rel="stylesheet" href="/layim/dist/css/layui.css?v=1">
<style>
.layim-msgbox{margin: 15px;}
.layim-msgbox li{position: relative; margin-bottom: 10px; padding: 0 130px 10px 60px; padding-bottom: 10px; line-height: 22px; border-bottom: 1px dotted #e2e2e2;}
.layim-msgbox .layim-msgbox-tips{margin: 0; padding: 10px 0; border: none; text-align: center; color: #999;}
.layim-msgbox .layim-msgbox-system{padding: 0 10px 10px 10px;}
.layim-msgbox li p span{padding-left: 5px; color: #999;}
.layim-msgbox li p em{font-style: normal; color: #FF5722;}

.layim-msgbox-avatar{position: absolute; left: 0; top: 0; width: 50px; height: 50px;}
.layim-msgbox-user{padding-top: 5px;}
.layim-msgbox-content{margin-top: 3px;}
.layim-msgbox .layui-btn-small{padding: 0 15px; margin-left: 5px;}
.layim-msgbox-btn{position: absolute; right: 0; top: 12px; color: #999;}
</style>
</head>
<body>
	
<ul>
	@foreach($users as $key => $val)
	    @if ($val->id !== $user->id)
	        <li class="friend_apply" data-avatar="{{$val['avatar']}}" data-name="{{$val['name']}}" data-friend_id={{$val['id']}}>{{ $val['name'] }}  申请加好友</li>
	    @endif
	@endforeach
</ul>

<!-- 
上述模版采用了 laytpl 语法，不了解的同学可以去看下文档：http://www.layui.com/doc/modules/laytpl.html 
-->


<script src="/layim/dist/layui.js?v=1"></script>
<script>
layui.use(['layim', 'flow'], function(){


  
  var layim = parent.layui.layim
  ,layer = parent.layui.layer
  ,laytpl = layui.laytpl
  ,$ = parent.layui.jquery
  ,flow = parent.layui.flow;

  var cache = {}; //用于临时记录请求到的数据

  var $ = layui.jquery; 

  {{-- 申请好友 --}}
  $('.friend_apply').on('click', function() {
      $this = $(this);
      layim.add({
        type: 'friend'
        ,username: $this.data('name')
        ,avatar: '//tva1.sinaimg.cn/crop.0.0.720.720.180/005JKVuPjw8ers4osyzhaj30k00k075e.jpg'
        ,submit: function(group, remark, index){
          //通知对方
          $.post('{{ route('chat.friend.apply') }}', {
            friend_id : $this.data('friend_id')
            ,remark: remark
            ,group: group
          }, function(res){
            if(res.code == 0){
              layer.close(index);
              return layer.msg(res.message);
            }
            layer.msg('好友申请已发送，请等待对方确认', {
              icon: 1
              ,shade: 0.5
            }, function(){
              layer.close(index);
            });
          });
          
        }
      });
  });
});
</script>
</body>
</html>