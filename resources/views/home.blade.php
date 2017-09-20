@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">Players Ranking</div>

                <div class="panel-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Rank</th>
                                <th>Name</th>
                                <th>Score</th>
                                <th>Win rate</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users->sortByDesc('score')->values() as $key => $player)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $player->name }}</td>
                                    <td>{{ $player->score }}</td>
                                    <td>{{ $player->win_rate }}%</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">Roles Ranking</div>

                <div class="panel-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Rank</th>
                                <th>Name</th>
                                <th>Score</th>
                                <th>Win rate</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($roles->sortByDesc('score')->values() as $key => $role)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>{{ $role->score }}</td>
                                    <td>{{ $role->win_rate }}%</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
