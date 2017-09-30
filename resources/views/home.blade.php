@extends('layouts.app')

@section('title')
    排行榜
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-egypt">
                <div class="panel-heading borderless">玩家排位</div>

                <div class="panel-body">
                    <table class="table borderless">
                        <thead>
                            <tr>
                                <th class="text-center">排位</th>
                                <th>玩家</th>
                                <th class="text-center">分数</th>
                                <th class="text-center">胜率</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach($users->sortByDesc('score')->values() as $key => $player)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td class="text-left">
                                        <div class="flex flex-center">
                                            <div style="background-image: url('{{ $player->avatar_path }}');" class="img-responsive img-circle profile img-small"></div>
                                            <span>{{ $player->name }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $player->score }}</td>
                                    <td>{{ round($player->win_rate, 2) }}%</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="panel panel-egypt">
                <div class="panel-heading borderless">阵营胜率</div>

                <div class="panel-body borderless">
                    <table class="table borderless text-center">
                        <thead>
                            <tr>
                                <th>阵营</th>
                                <th>胜率</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>好人阵营</td>
                                <td>{{ $total_score > 0 ? round( $good_score / $total_score * 100, 2 ) : 0 }}%</td>
                            </tr>
                            <tr>
                                <td>狼人阵营</td>
                                <td>{{ $total_score > 0 ? round( $bad_score / $total_score * 100, 2 ) : 0 }}%</td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
