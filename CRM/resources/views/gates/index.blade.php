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
                <h2>List of gates</h2>
                <a class="btn btn-primary" href="{{ route('gates.create') }}"> Create New Gate</a>
            </div>
        <table class="table">
            <tr>
                <th>No</th>
                <th>Full Address</th>
                <th>Company</th>
                <th width="280px">Action</th>
            </tr>
            @foreach ($gates as $gate)
                <tr>
                    <td>{{ $gate->id }}</td>
                    <td>{{ $gate->name }}</td>
                    <td>{{ $gate->office->full_address }}</td>
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
