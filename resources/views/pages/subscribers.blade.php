@extends('layouts.layout')

@section('title', 'Page Title')

@section('content')
    <div class="mt-4 subscribers-wrap">
        <h1 class="h3 mb-0 text-gray-800">
            Subscribers
            <a class="btn btn-outline-success" href="{{route('subscriber-create-form')}}">Add a new subscriber</a>
        </h1>
        <div class="mt-3">
            @include('components.success')
        </div>
        <div class="row">
            <div class="subscribers-wrap">
                <table id="subscribers" class="display">
                    <thead>
                    <tr>
                        <th>Email</th>
                        <th>Name</th>
                        <th>Country</th>
                        <th>Subscribe date</th>
                        <th>Subscribe time</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <div class="table-pagination hide">
                    <button class="btn btn-outline-secondary pagination-btn" id="prev" disabled="disabled">Previous</button>
                    <button class="btn btn-outline-secondary pagination-btn" id="next" disabled="disabled">Next</button>
                </div>
            </div>
        </div>
    </div>
@endsection
