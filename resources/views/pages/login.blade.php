@extends('layouts.blank_layout')

@section('title', 'Login')

@section('content')
    <div class="login-form">
        <form action="{{route('authenticate')}}" method="POST" class="pt-4 px-5">
            @csrf
            @include('components.errors')

            <input name="api_key" id="api_key" type="text" class="mb-3 px-3 py-2 text-sm rounded border border-gray-300" placeholder="API key"/>
            <button type="submit" class="btn btn-success">Sign in</button>
        </form>
    </div>
@endsection
