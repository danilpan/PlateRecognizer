@extends('layouts.app')
@extends('layouts.sidenav')

@section('content')
    <div class="container">
        <div class="main col-sm col-md col-lg col-xl">
            <div class="title_companies">
                <h2>Edit car</h2>
            </div>
            {{ HTML::ul($errors->all()) }}
            <div class="company_form">
                {{ Form::model($car,['action' => ['CarController@update', $car->id], 'method' => 'PUT'])}}
                <div class="car-form">
                    <div class="form-group">
                        {{ Form::label('plate_number', 'Plate Number') }}
                        {{ Form::text('plate_number', Request::old('short_name'), array('class' => 'form-control')) }}
                    </div>
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
                                        @if($gate->pivot && $gate->pivot->has_access==1)
                                            <input type="checkbox" name="gates[]" value="{{$gate->id}}" checked/>
                                        @else
                                            <input type="checkbox" name="gates[]" value="{{$gate->id}}"/>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                    {{ Form::submit('Edit the car', ['class' => 'btn2 btn-primary']) }}

                    {{ Form::close() }}

                </div>
            </div>
        </div>
@endsection
