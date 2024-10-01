@extends('layouts.app')

@section('title','Calendriers')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container py-5">
    <h5 class="mb-3">Listes des Calendriers : </h5>
    <div class="table-responsive">
        <table class="table text-center table-bordered table-hover">
            <thead>
                <tr>                                           
                    <th scope="col">id</th>
                    <th scope="col">name</th>
                    <th scope="col">user</th>
                    <th>actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ( $calendriers as $calendrier )
                    <tr>
                        <td>{{$calendrier->id}}</td>   
                        <td>
                            <a href="{{ route('calendriers.show', $calendrier->id) }}">{{$calendrier->name}}</a>
                        </td>   
                        <td>{{$calendrier->user->name}}</td>
                        <td class="d-flex justify-content-center">
                            <a href="{{ route('calendriers.edit', $calendrier->id) }}">
                                <button class="btn btn-success me-3">
                                    <i class="bi bi-pencil"></i>
                                </button>
                            </a>   
                            <form action="{{ route('calendriers.destroy',$calendrier->id) }}" method="post">
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
                        <td colspan="4" class="fw-bold">list Calendriers vide</td>
                    </tr>
                @endforelse
            </tbody>
        </table>        
    </div>
</div>

@endsection