@extends('layouts.app')

@section('content')

    <div>

        <sailings-list-component></sailings-list-component>

        <itins-component></itins-component>

    </div>

    <div>
        <map-component></map-component>
    </div>

@endsection
