@extends('layouts.app')

@section('title','Edit Event')

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
            <div class="card-header">Edit Event : </div>
            <div class="card-body">
                <div class="text-danger"></div>
                <form id="eventForm" class="mt-2" action="{{ route('events.update',$event->id)}}" method="POST">
                    @csrf
                    @method("PUT")
                    <div class="mb-3">
                        <label for="eventName" class="form-label">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="eventName" name="name" value="{{old('name',$event->name)}}">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="eventDescription" class="form-label">Description</label>
                        <textarea id="eventDesc" name="description" class="form-control" rows="2" style="resize: none">{{old('description',$event->description)}}</textarea>
                        @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="eventStartDate" class="form-label">Start Date</label>
                        <input type="date" class="form-control @error('start_date') is-invalid @enderror" id="eventStartDate" name="start_date" value="{{old('start_date',$event->start_date)}}">
                        @error('start_date')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="eventEndDate" class="form-label">End Date</label>
                        <input type="date" class="form-control @error('end_date') is-invalid @enderror" id="eventEndDate" name="end_date" value="{{old('end_date',$event->end_date)}}">
                        @error('end_date')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="eventCalendar" class="form-label">Calendrier</label>
                        <select class="form-select @error('calendrier_id') is-invalid @enderror" aria-label="Default select example" name="calendrier_id">
                            <option selected>Select Calendar</option>
                            @foreach ($calendriers as $calend)
                                <option value="{{old('calendrier_id', $event->calendrier_id)}}" {{$event->calendrier_id == $calend->id ? "selected" : ""}}>{{$calend->name}}</option>
                            @endforeach
                        </select>                        
                        @error('calendrier_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <button type="submit" id="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection