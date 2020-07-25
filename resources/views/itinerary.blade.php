@extends('layouts.app')

@section('content')

    <div>

        <sailings-list-component></sailings-list-component>

        <itins-component></itins-component>

    </div>

    <div>
        <keep-alive>
            <router-view />
        </keep-alive>
    </div>

@endsection
