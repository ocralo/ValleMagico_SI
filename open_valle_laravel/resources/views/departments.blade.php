@extends('layouts.app')
@section('content')
<div class="mx-5 d-flex flex-wrap">
    @foreach ($departments as $department)
        <div class="card text-center m-2" style="width: 18rem;">
            <div class="card-body">
            <h5 class="card-title">{{$department->name}}</h5>
              {{-- <p class="card-text">With supporting text below as a natural lead-in to additional content.</p> --}}
              <a href="#" class="btn btn-danger">View</a>
            </div>
        </div>
    @endforeach
</div>
@endsection
