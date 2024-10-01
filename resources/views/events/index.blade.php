@extends('layouts.app')

@section('title','Events')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container py-5">
    @if (session('message'))
        <div class="alert alert-success mb-3">
            {{ session('message') }}
        </div>
    @endif
    <h5 class="mb-3">Listes des Events : </h5>
    <div class="table-responsive">
        <table class="table text-center table-striped table-bordered table-hover">
            <thead>
                <tr>                                           
                    <th>Id</th>
                    <th>Name</th>
                    <th>Start date</th>
                    <th>End date</th>
                    <th>Description</th>
                    <th>Calendrier</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($events as $event)
                    <tr>
                        <td>{{$event->id}}</td>   
                        <td>{{$event->name}}</td>   
                        <td>{{$event->start_date}}</td>   
                        <td>{{$event->end_date}}</td>   
                        <td>{{$event->description}}</td>   
                        <td>{{$event->calendrier->name}}</td>   
                        <td class="d-flex justify-content-center">
                            <a href="{{ route('events.edit', $event->id) }}">
                                <button class="btn btn-success me-3">
                                    <i class="bi bi-pencil"></i>
                                </button>
                            </a>   
                            <form action="{{ route('events.destroy',$event->id) }}" method="post">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn-danger btn" onclick="return confirm('vous voulez supprimer ?')" >
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>   
                    </tr>                
                @empty
                    <tr>
                        <td colspan="6" class="text-danger fw-bold">liste vide</td>
                    </tr>                
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection