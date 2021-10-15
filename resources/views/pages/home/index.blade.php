@extends('layouts.main')

@section('title', "Home")

@section('content')
    @if(auth()->user()->hasRole('root'))
        @livewire('dash.root-home-view')
    @else
        @livewire('dash.admin-and-operator-home-view')
    @endif
@endsection

@section('custom-style')
    <style>
        .ct-series-a .ct-bar {
            /* Colour of your bars */
            stroke: green;

        }
        .ct-series-b .ct-bar {
            /* Colour of your bars */
            stroke: red;
        }

        .ct-series-c .ct-bar {
            /* Colour of your bars */
            stroke: #f5b759;
        }
    </style>
@endsection
