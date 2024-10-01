@extends('layouts.app')

@section('title','Dashboard')

@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

<div class="py-6 bg-white">
    <h2 class="font-semibold text-center text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Dashboard') }}
    </h2>
</div>

{{-- <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                {{ __("You're logged in!") }}
            </div>
        </div>
    </div>
</div> --}}

<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-4">
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            @php
                use Carbon\Carbon; 
            @endphp
            @foreach ( $users as $user)
                <div class="d-flex justify-between mb-3">
                    <h4 class="fw-semibold text-capitalize">{{$user->name}}</h4>
                    <h5>Année : {{$currentYear}}</h5>
                </div>
                <div class="d-flex justify-content-between border bordered rounded">
                    <h5 class="d-flex gap-2 p-3">
                        <span>Total Calendriers : </span><div class="text-primary">{{$user->calendrier->count()}}</div>
                    </h5>
                    <h5 class="d-flex gap-2 p-3">
                        <span>Total Events : </span><div class="text-danger">{{$user->events->count()}}</div>
                    </h5>
                </div>
                <div class="py-4">
                    <h4 class="mb-3">Total Event par Calendrier : </h4>
                    @foreach ($user->calendrier as $calendrier)
                        <table class="table table-bordered table-responsive mb-4">
                            <thead>
                                <tr>
                                    <th>Calendrier Name</th>
                                    <th>Total Events</th>
                                </tr>
                            </thead>
                            <tbody class="fs-5 text-center">
                                <tr>
                                    <td>{{$calendrier->name}}</td>
                                    <td class="text-danger fw-bold">{{$calendrier->events->count()}}</td>
                                </tr>
                            </tbody>
                        </table>
                    @endforeach
                    <div class="py-4">
                        @foreach ($user->calendrier as $calendrier)
                        <h4 class="mb-4">Taux de Remplissage par {{$calendrier->name}} : </h4>
                        <div class="table-responsive mb-4">
                            <table class="table table-bordered">
                                {{-- table horizontal --}}
                                <thead class="text-center">
                                    <tr>
                                        <th>Month</th>
                                        @for ($month = 1; $month <= 12; $month++)
                                            <th class="text-primary fs-5">{{ str_pad($month, 2, '0', STR_PAD_LEFT) }}</th>
                                        @endfor
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <tr>
                                        <td class="fw-bold">Fill Rate</td>
                                        @for ($month = 1; $month <= 12; $month++)
                                            @php
                                                $monthFormatted = str_pad($month, 2, '0', STR_PAD_LEFT);
                                                $eventsInMonth = $calendrier->events->filter(function ($event) use ($month, $currentYear) {
                                                    return Carbon::parse($event->start_date)->month === $month && 
                                                        Carbon::parse($event->start_date)->year === $currentYear;
                                                });
                                                $totalCapacity = 20;
                                                $totalEventsInMonth = $eventsInMonth->count();
                                                $tauxDeRemplissage = ($totalEventsInMonth / $totalCapacity) * 100;
                                            @endphp
                                            
                                            <td class="{{$tauxDeRemplissage > 0 ? 'text-danger' : ''}} fs-5 fw-bold">{{ $tauxDeRemplissage }}%</td>
                                        @endfor    
                                    </tr>
                                </tbody>

                                {{-- table vertical --}}
                                {{-- <thead class="text-center">
                                    <tr>
                                        <th>Month</th>
                                        <th>Fill Rate</th>
                                    </tr>
                                </thead>
                                <tbody class="fs-5 text-center">
                                    @for ($month = 1; $month <= 12; $month++)
                                        @php
                                            $monthFormatted = str_pad($month, 2, '0', STR_PAD_LEFT);
                                            $eventsInMonth = $calendrier->events->filter(function ($event) use ($month, $currentYear) {
                                                return Carbon::parse($event->start_date)->month === $month && 
                                                    Carbon::parse($event->start_date)->year === $currentYear;
                                            });
                                            $totalCapacity = 20;
                                            $totalEventsInMonth = $eventsInMonth->count();
                                            $tauxDeRemplissage = ($totalEventsInMonth / $totalCapacity) * 100;
                                        @endphp
                                        <tr>
                                            <td class="text-primary fw-bold">{{ $monthFormatted }}</td>
                                            <td class="{{$tauxDeRemplissage > 0 ? 'text-danger' : ''}} fw-bold">{{ $tauxDeRemplissage }}%</td>
                                        </tr>
                                    @endfor    
                                </tbody> --}}
                            </table>
                        </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@endsection
