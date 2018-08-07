@extends('layouts.app')

@section('title')
    App更新记录
@endsection

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-xs-12">
				<!-- Patch v2.1 -->
				<ul class="list-unstyled">
			    	<li>
			    		<b>v2.1 (5/5/2018)</b>
			    		<ol>
			    			<li>
			    				身份抽取
			    				<ol>
			    					<li>身份抽取优化</li>
			    				</ol>
			    			</li>
			    			<li>
			    				新一季
			    				<ol>
			    					<li>分数重设</li>
			    				</ol>
			    			</li>
			    			<li>
			    				游戏/法官
			    				<ol>
			    					<li>当游戏进行中，所有玩家可直接进入游戏界面</li>
			    					<li>法官可以使用其他人的手机</li>
			    				</ol>
			    			</li>
			    		</ol>
			    	</li>
			    </ul>
				<!-- End patch v2.1 -->
				<!-- Patch v1.2 -->
				<hr>
				<ul class="list-unstyled">
			    	<li>
			    		<b>v1.2 (14/1/2018)</b>
			    		<ol>
			    			<li>
			    				创建游戏
			    				<ol>
			    					<li>玩家选定优化</li>
			    					<li>添加自动角色分配功能</li>
			    					<li>上帝可选择关闭角色分配</li>
			    				</ol>
			    			</li>
			    			<li>
			    				身份抽取
			    				<ol>
			    					<li>新添加身份抽取界面</li>
			    					<li>玩家可依靠屏幕指示，通过滑屏查看自己的身份</li>
			    				</ol>
			    			</li>
			    			<li>
			    				游戏界面
			    				<ol>
			    					<li>脚本优化，上帝可在脚本上设定玩家身份</li>
			    				</ol>
			    			</li>
			    			<li>
			    				更新记录
			    				<ol>
			    					<li>更新记录将被文字代替</li>
			    				</ol>
			    			</li>
			    		</ol>
			    	</li>
			    </ul>
				<!-- End patch v1.2 -->
				<!-- Patch v1.1 -->
				<hr>
			    <ul class="list-unstyled">
			    	<li>
			    		<b>v1.1 (22/10/2017)</b>
			    		<ol>
			    			<li>
			    				新增角色
								<ol>
									<li>诽谤者</li>
									<li>骑士</li>
									<li>狼美人</li>
								</ol>
			    			</li>
			    			<li>
			    				排行榜更新
			    				<ol>
			    					<li>查杀小数点太长</li>
			    					<li>玩家名字颜色统一</li>
			    					<li>玩家名字长度统一</li>
			    				</ol>
			    			</li>
			    			<li>
			    				创建游戏
			    				<ol>
			    					<li>设定默认为上局设定，微调即可</li>
			    					<li>当前使用者默认为上帝</li>
			    					<li>村名及普通狼人牌自动开启</li>
			    				</ol>
			    			</li>
			    			<li>
			    				游戏界面
			    				<ol>
			    					<li>随机发言将显示座位号码和方向</li>
			    					<li>新添加上递交本</li>
			    				</ol>
			    			</li>
			    			<li>
			    				杂项
			    				<ol>
			    					<li>玩家默认头像更改</li>
			    				</ol>
			    			</li>
			    		</ol>
			    	</li>
			    </ul>
			    <!-- End patch v1.1 -->
			</div>
		</div>
	</div>


@endsection
