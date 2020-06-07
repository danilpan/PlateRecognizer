@extends('layouts.app')
@extends('layouts.sidenav')

@section('content')
    <div class="container">
        <div class="main col-sm col-md col-lg col-xl">
            <div class="show_title">
                <h4>
                    Name of company - {{$company->short_name}}
                </h4>
                <h4>
                    Official name of company - {{$company->official_name}}
                </h4>
                <a class="btn btn-primary" href="{{ route('offices.create') }}">Create Gate</a>
            </div>
            <table class="table">
                <caption style="caption-side: top; text-align: center">Offices of company</caption>
                <tr>
                    <th>No</th>
                    <th>Address</th>
                    <th>Actions</th>
                </tr>
                @foreach ($company->offices as $office)
                    <tr>
                        <td>{{$office->id }}</td>
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
