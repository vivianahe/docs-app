@extends('layouts.app')

@section('content')
<div class="">
    @if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
    @endif
    <div>
        <div id="app">
            <app-component></app-component>
        </div>
    </div>
    <!--  -->
</div>
@endsection