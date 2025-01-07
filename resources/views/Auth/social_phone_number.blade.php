@extends('layouts.master')
@section('page_title', 'Phone Number')

@section('body-content')
<div id="app">
    @php
       $customer=session('customer');
    @endphp
    <social-phone-number :customer="'{{ json_encode($customer)}}'" />
</div>
@endsection