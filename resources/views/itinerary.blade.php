@extends('layouts.app')

@section('content')

    <div>

        <sailings-list-component></sailings-list-component>

        <itins-component></itins-component>

    </div>

    <div>
        <router-view />

    </div>

@endsection
