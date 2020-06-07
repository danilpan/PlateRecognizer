@extends('layouts.app')
@extends('layouts.sidenav')

@section('content')
    <div class="container">
        <div class="main col-sm col-md col-lg col-xl">
            <div class="show_title">
                <h4>
                    Name of gate - {{$gate->name}}
                </h4>
                <h4>
                    Address of gate's office - {{$gate->office->full_address}}
                </h4>
                <a class="btn btn-primary" href="{{ route('gates.create') }}">Create Gate</a>
            </div>
            <table class="table">
                <caption style="caption-side: top; text-align: center">Cars which have access to gate</caption>
                <tr>
                    <th>No</th>
                    <th>Plate Number</th>
                    <th>Has Access</th>
                    <th width="280px">Action</th>
                </tr>
                @foreach ($gate->cars as $car)
                    <tr>
                        <td>{{$car->id }}</td>
                        <td>{{ $car->plate_number }}</td>
                        <td>{{ $car->pivot->has_access==1 ? 'Yes':'No' }}</td>
                        <td>
                            <a class="btn btn-primary" href="{{ route('cars.show',$car->id) }}">Show</a>
                            <a class="btn btn-primary" href="{{ route('cars.edit',$car->id) }}">Edit</a>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection
