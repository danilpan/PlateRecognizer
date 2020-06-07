@extends('layouts.app')
@extends('layouts.sidenav')

@section('content')
    <div class="container">
        <div class="main col-sm col-md col-lg col-xl">
            <div class="title_companies">
                <h2>Create new gate</h2>
            </div>
            {{ HTML::ul($errors->all() )}}

            <div class="company_form">
            <form action="{{ route('gates.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    {{ Form::label('name', 'Name') }}
                    {{ Form::text('name', Request::old('name'), array('class' => 'form-control')) }}
                </div>

                <div class="form-group">
                    {{ Form::label('client_hash', 'MAC of Client') }}
                    {{ Form::text('client_hash', Request::old('client_hash'), array('class' => 'form-control')) }}
                </div>

                <div class="form-group">
                    {{ Form::label('office_id', 'Office') }}

                    <select name="office_id"
                            class="form-control {{ $errors->has('office_id') ? ' is-invalid' : '' }}">
                        @foreach( $offices as $office ):
                        <option value="{{ $office->id }}" {{ (old("office_id") == $office->id ? "selected":"") }}>
                            {{$office->full_address }}
                        </option>
                        @endforeach
                    </select>
                </div>

                {{ Form::submit('Create the Gate', array('class' => 'btn2 btn-primary')) }}

            </form>
            </div>
        </div>
    </div>
@endsection
