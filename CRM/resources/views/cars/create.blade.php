@extends('layouts.app')
@extends('layouts.sidenav')

@section('content')
    <div class="container">
        <div class="main col-sm col-md col-lg col-xl">
            <div class="title_companies">
                <h2>Create new car</h2>
            </div>
            {{ HTML::ul($errors->all() )}}

            <div class="company_form">
                <form action="{{ route('cars.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        {{ Form::label('plate_number', 'Plate Number') }}
                        {{ Form::text('plate_number', Request::old('plate_number'), array('class' => 'form-control')) }}
                    </div>
                    <h4>Have access to gates</h4>
                    <div class="form-group">
                        <table class="table">
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Has access</th>
                            </tr>
                            @foreach ($gates as $gate)
                                <tr>
                                    <td>{{$gate->id }}</td>
                                    <td>{{ $gate->name }}</td>
                                    <td>
                                        <input type="checkbox" name="gates[]" value="{{$gate->id}}"/>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>

                    {{ Form::submit('Create the Gate', array('class' => 'btn2 btn-primary')) }}

                </form>
            </div>
        </div>
    </div>
@endsection
