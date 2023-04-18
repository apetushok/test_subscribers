
@extends('layouts.layout')

@section('title', 'Tag Page')

@section('content')
    <div class="ml-3">
        <div class="mt-3 pt-3">
            <h2>{{ !empty($subscriber) ? 'Updating of a' : 'Creating of a new' }} subscriber</h2>
        </div>
        <form action="{{ !empty($subscriber) ? route('subscriber-update', $subscriber) : route('subscriber-store') }}" method="POST" class="mt-5 mb-3 subscriber-edit-form">
            @csrf
            @include('components.errors')
            <br/>

            @if(!empty($subscriber))
                <input name="id" type="hidden" value="{{$subscriber['id']}}">
            @else
                <label>Email</label>
                <input name="email" id="email" type="email" class="mb-3 px-3 py-2 rounded border" placeholder="Email" value="{{!empty($subscriber) ? ($subscriber['email'] ?? '') : ''}}"/>
            @endif

            <label>Name</label>
            <input name="name" id="name" type="text" class="mb-3 px-3 py-2 rounded border" placeholder="Name" value="{{!empty($subscriber) ? ($subscriber['fields']['name'] ?? '') : ''}}"/>

            <label>Country</label>
            <input name="country" id="country" type="text" class="mb-3 px-3 py-2 rounded border" placeholder="Country" value="{{!empty($subscriber) ? ($subscriber['fields']['country'] ?? '') : ''}}"/>

            <button type="submit" class="right btn btn-outline-success">{{ !empty($subscriber) ? 'Update' : 'Add' }}</button>
        </form>
    </div>
@endsection
