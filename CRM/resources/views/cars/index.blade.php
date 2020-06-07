@extends('layouts.app')
@extends('layouts.sidenav')

@section('content')
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <div class="container">
        <div class="main col-sm col-md col-lg col-xl">
            <div class="title_companies">
                <h2>List of cars</h2>
                <a class="btn btn-primary" href="{{ route('cars.create') }}"> Create New Car</a>
            </div>
            <table class="table">
                <tr>
                    <th>No</th>
                    <th>Plate Number</th>
                    <th width="280px">Action</th>
                </tr>
                @foreach ($cars as $car)
                    <tr>
                        <td>{{ $car->id }}</td>
                        <td>{{ $car->plate_number }}</td>
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
