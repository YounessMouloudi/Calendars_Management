@extends('layouts.app')

@section('title','Edit Calendar')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container py-5">
    <div class="col-md-6 offset-3">
        @if (session('info'))
            <div class="alert alert-warning mb-3">
                {{ session('info') }}
            </div>
        @endif
        <div class="card">
            <div class="card-header">Update Calendar : </div>
            <div class="card-body">
                <div class="text-danger"></div>
                <form class="mt-2" action="{{ route('calendriers.update',$calendrier)}}" method="post">
                    @csrf
                    @method("PUT")
                    <div class="mb-3">
                        <label for="" class="form-label">Name : </label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" 
                        value="{{ old("name",$calendrier->name)}}">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection