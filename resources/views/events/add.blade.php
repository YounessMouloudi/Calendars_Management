@extends('layouts.app')

@section('title','Add Event')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container py-5">
    <div class="col-md-6 offset-3">
        <div class="card">
            <div class="card-header">Add New Event : </div>
            <div class="card-body">
                <form id="eventForm" class="mt-2" action="{{ route('events.store')}}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="eventName" class="form-label">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="eventName" name="name" value="{{old('name')}}">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="eventDescription" class="form-label">Description</label>
                        <textarea id="eventDesc" name="description" class="form-control" rows="2" style="resize: none">{{old('description')}}</textarea>
                        @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="eventStartDate" class="form-label">Start Date</label>
                        <input type="date" class="form-control @error('start_date') is-invalid @enderror" id="eventStartDate" name="start_date" value="{{old('start_date')}}">
                        @error('start_date')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="eventEndDate" class="form-label">End Date</label>
                        <input type="date" class="form-control @error('end_date') is-invalid @enderror" id="eventEndDate" name="end_date" value="{{old('end_date')}}">
                        @error('end_date')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="eventCalendar" class="form-label">Calendrier</label>
                        <select class="form-select @error('calendrier_id') is-invalid @enderror" name="calendrier_id">
                            <option selected>Select Calendar</option>
                            @foreach ($calendriers as $calend)
                                <option value="{{old('calendrier_id',$calend->id)}}" {{old('calendrier_id') == $calend->id ? "selected" : ""}}>{{$calend->name}}</option>
                            @endforeach
                        </select>                        
                        @error('calendrier_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <button type="submit" id="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection