@extends('layouts.app')

@section('content')
   {{-- <App v-bind:news="{{json_encode($news)}}"
         v-bind:reviews="{{json_encode($reviews)}}"
         v-bind:auth="{{json_encode($auth)}}"> {{ csrf_field() }} </App>--}}
    <App>{{csrf_field()}}</App>
@endsection