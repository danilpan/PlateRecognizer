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
                <h2>List of companies</h2>
                <a class="btn btn-primary" href="{{ route('companies.create') }}"> Create New Company</a>
            </div>
            <table class="table">
                <tr>
                    <th>No</th>
                    <th>Short Name</th>
                    <th>Official Name</th>
                    <th width="280px">Action</th>
                </tr>
                @foreach ($companies as $company)
                    <tr>
                        <td>{{ $company->id }}</td>
                        <td>{{ $company->short_name }}</td>
                        <td>{{ $company->official_name }}</td>
                        <td>
                            <a class="btn btn-primary" href="{{ route('companies.show',$company->id) }}">Show</a>
                            <a class="btn btn-primary" href="{{ route('companies.edit',$company->id) }}">Edit</a>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection
