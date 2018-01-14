@extends('layouts.app')

@section('title')
    身份抽取
@endsection

@section('content')


    <player-roles :id="{{ $game->id }}"></player-roles>


@endsection
