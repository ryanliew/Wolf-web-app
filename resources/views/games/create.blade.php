@extends('layouts.app')

@section('title')
    创建游戏
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-egypt">
                <div class="panel-heading">{{ trans('misc.create_game') }}</div>

                <div class="panel-body">
                    <game-create></game-create>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
