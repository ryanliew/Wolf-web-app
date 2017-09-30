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
                    <div class="game-summary">
                        <div class="flex">
                            <div class="level">
                                游戏 #{{ $game->id }}
                            </div>
                            <div>
                                获胜阵营：{{ $game->is_concluded ? $game->is_good_win ? '好人阵营' : '狼人阵营' : "-"}}
                            </div>
                        </div>
                        {{ $game->created_at }} <br>
                        玩家：
                        <div class="flex overflow-scroll">
                            @foreach($game->players() as $player)
                                <div class="img-responsive img-circle profile img-medium" style="background-image: url('{{ $player->avatar_path }}');"></div>
                            @endforeach
                        </div>
                    </div>
                </a>
                <hr>
            @endforeach
        </div>
    </div>
</div>
@endsection
