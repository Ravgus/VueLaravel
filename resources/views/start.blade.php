@extends('layouts.app')

@section('content')

    {{--<example-component></example-component>
    <prop-component :urldata="{{json_encode($url_data)}}"></prop-component>
    <ajax-component></ajax-component>
    <chart-component></chart-component>
    <chartpie-component></chartpie-component>--}}
    {{--<chartrandom-component></chartrandom-component>--}}
    {{--<socket-component></socket-component>--}}
    {{--<socketchat-component></socketchat-component>--}}
@if(Auth::check())
    <h4 class="text-center">Пользователь - {{ Auth::user()->email }}</h4>
    <socket-private-component :users="{{ \App\User::select('email', 'id')->where('id', '!=', Auth::id())->get() }}" :user="{{ Auth::user() }}"></socket-private-component>
@endif

@endsection