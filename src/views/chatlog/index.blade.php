<html>
	<head>
		<meta charset="UTF-8">
		<title>Document</title>
		<link rel="stylesheet" href="/layim/src/css/layui.css">
		<link rel="stylesheet" href="/layim/src/css/modules/layim/layim.css?v=3.7.6">
		<style>
			body .layim-chat-main{height: auto;}
			.layim-chat-main ul {padding : 0; margin : 0}
		</style>
	</head>
	<body>
		<div class="layim-chat-main">
			<ul id="demo">
			</ul>
		</div>

		<script src="/layim/src/layui.js"></script>
		<script>
			var type = '{{ $type }}';
			var id = '{{ $id }}';
			var curId = '{{ $curId }}';

			layui.use('flow', function(){
				var $ = layui.jquery;
				var flow = layui.flow;
				var html = '';
				flow.load({
			  		isAuto : true
			    	,elem: '#demo' //指定列表容器
			    	,done: function(page, next){ //到达临界点（默认滚动触发），触发下一页
			      		//以jQuery的Ajax请求为例，请求下一页数据（注意：page是从2开始返回）
			      		$.get('{{ route('chat.chatlog.index') }}?page='+page + '&type=' + type + '&id=' + id, function(res){
		        			html = ''
			        		layui.each(res.data, function(index, item){
					        	if ( curId == item.from_id) {
						        	html += '<li class="layim-chat-mine">';
						        	html += '	<div class="layim-chat-user">';
						        	html +=	'		<img src="'+item.avatar+'">';
						        	html +=	'			<cite>';
						        	html +=	'				<i>'+ item.created_at +'</i>';
						        	html +=					item.name;
						        	html +=	'			</cite>';
						        	html +=	'	</div>';
						        	html +=	'	<div class="layim-chat-text">';
						        	html += 		item.content;
						        	html +=	'	</div>';
									html += '</li>';
					        	} else {
						        	html += '<li>';
									html += '	<div class="layim-chat-user">';
									html += '		<img src="'+ item.avatar +'">';
									html += '		<cite>' + item.name;
									html += '			<i>' + item.created_at + '</i>';
									html += '		</cite>';
									html += '	</div>';
									html += '	<div class="layim-chat-text">' + item.content + '</div>';
									html += '</li>';
					        	}
					        });

				        	next(html, page < res.pages);
			      		});
			    	}
			  	});
			});
		</script>
	</body>
</html>

