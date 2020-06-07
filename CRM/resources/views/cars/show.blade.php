@extends('layouts.app')
@extends('layouts.sidenav')

@section('content')
    <div class="container">
        <div class="main col-sm col-md col-lg col-xl">
            <div class="show_title">
                <h4>
                    Plate Number - {{$car->plate_number}}
                </h4>
                <a class="btn btn-primary" href="{{ route('cars.create') }}">Create car</a>
            </div>
            <table class="table">
                <caption style="caption-side: top; text-align: center">Gates of car</caption>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Has Access</th>
                    <th width="280px">Action</th>
                </tr>
                @foreach ($car->gates as $gate)
                    <tr>
                        <td>{{$gate->id}}</td>
                        <td>{{ $gate->name }}</td>
                        <td>{{ $gate->pivot->has_access==1?'Yes':"No"}}</td>
                        <td>
                            <a class="btn btn-primary" href="{{ route('gates.show',$gate->id) }}">Show</a>
                            <a class="btn btn-primary" href="{{ route('gates.edit',$gate->id) }}">Edit</a>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection
