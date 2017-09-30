@extends('layouts.app')

@section('title')
    以往游戏
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 game-list">
            @foreach($games as $game)
                <a href="{{ url('game', $game->id) }}">
                    <div class="game-summary" style="background-color:{{ $game->win_side_color }}">
                        <div class="flex flex-center">
                            <div class="win-side">
                                <div class="img-responsive img-circle profile img-medium" style="background-image: url('{{ $game->win_side_img }}');"></div>
                            </div>
                            <div class="level ml-5">
                                <b>游戏 #{{ $game->id }}</b> <small>{{ $game->created_at }}</small>
                                <br>
                                玩家人数: {{ $game->players()->count() }}
                                <br>
                                上帝: {{ $game->judge()->name }}
                            </div>
                        </div>                      
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>
@endsection
