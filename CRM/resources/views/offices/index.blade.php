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
                <h2>List of offices</h2>
                <a class="btn btn-primary" href="{{ route('offices.create') }}"> Create New Office</a>
            </div>
        
             <table class="table">
            <tr>
                <th>No</th>
                <th>Full Address</th>
                <th width="280px">Action</th>
            </tr>
            @foreach ($offices as $office)
                <tr>
                    <td>{{ $office->id }}</td>
                    <td>{{ $office->full_address }}</td>
                    <td>
                        <a class="btn btn-primary" href="{{ route('offices.show',$office->id) }}">Show</a>
                        <a class="btn btn-primary" href="{{ route('offices.edit',$office->id) }}">Edit</a>
                    </td>
                </tr>
            @endforeach
        </table>
        </div>
    </div>
@endsection
