@extends('errors.minimal')

@section('title', __('Server Error'))
@section('code', '405')
@section('message', ($message ?? 'Method Not Allowed'))
