@extends('layouts.app')

@section('title')
    游戏 #{{ $game->id }}
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">

            <game-details :id="{{ $game->id }}" :scroll-y="scrollY"></game-details>

        </div>
    </div>
</div>
@endsection
