@extends('layouts.main')

@section('page_title', 'Winners')
@section('betting', 'active-link')
@section('content')
   
    <winner-lists :game-type="'{{ $game_type }}'"></winner-lists>
    
@endsection