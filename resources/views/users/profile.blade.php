@extends('layouts.app')

@section('title')
    {{ $user->name }}的资料
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
        	@if(auth()->id() == $user->id)
            	<user-profile></user-profile>
            @else
            	<div class="row margin-1">
					<div class="col-xs-12 text-center">
						<div class="profile-img-container">
			            	<div class="img-circle profile img-big" style="background-image: url('{{ $user->avatar_path }}');"></div>
			            </div>
			            自 {{ $user->created_at->toDateString() }} 开始互怼
			        </div>					
				</div>
            @endif
			<div class="text-center player-details margin-1">
	            <h3>资料库</h3>
	            <div class="panel panel-egypt background-good">
	            	<div class="panel-body">
			            <h4>好人阵营</h4>
						<ul class="list-inline">
							@foreach($roles->where('type', 'good') as $role)
								@include('components.profile-role', ['role' => $role])	
							@endforeach
						</ul>
					</div>
				</div>
				<div class="panel panel-egypt background-bad">
	            	<div class="panel-body">
						<h4>狼人阵营</h4>
						<ul class="list-inline">
							@foreach($roles->where('type', 'bad') as $role)
								@include('components.profile-role', ['role' => $role])
							@endforeach
						</ul>
					</div>
				</div>
			</div>
        </div>
    </div>
</div>
@endsection
