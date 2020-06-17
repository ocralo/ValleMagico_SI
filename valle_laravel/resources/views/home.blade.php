@extends('layouts.app')


@section('styles')
    <link href="{{ asset('css/home.css') }}" rel="stylesheet"> 
    <script> 
    var csrf_token = '<?php echo csrf_token(); ?>'; 
</script>       
@endsection

@section('content')
    <div id="HomePage" data-username={{ Auth::user()->username }} data-name={{ Auth::user()->name }} data-id={{ Auth::user()->id }} ></div>
@endsection
