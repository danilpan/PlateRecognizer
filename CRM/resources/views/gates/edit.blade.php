@extends('layouts.app')
@extends('layouts.sidenav')

@section('content')
    <div class="container">
        <div class="main col-sm col-md col-lg col-xl">
            <div class="title_companies">
                <h2>Edit gate</h2>
            </div>
            {{ HTML::ul($errors->all()) }}
            <div class="company_form">
                <form action="{{ route('gates.update', $gate->id) }}" method="PUT">
                <div class="form-group">
                    {{ Form::label('name', 'Name') }}
                    {{ Form::text('name', $gate->name, ['class' => 'form-control']) }}
                </div>

                <div class="form-group">
                    {{ Form::label('client_hash', 'MAC of Client') }}
                    {{ Form::text('client_hash', $gate->client_hash, ['class' => 'form-control']) }}
                </div>

                <div class="form-group">
                    {{ Form::label('office_id', 'Office') }}

                    <select name="office_id"
                            class="form-control {{ $errors->has('office_id') ? ' is-invalid' : '' }}">
                        @foreach( $offices as $office ):
                        <option value="{{ $office->id }}" {{ ($gate->office->id == $office->id ? "selected":"") }}>
                            {{$office->full_address }}
                        </option>
                        @endforeach
                    </select>
                </div>
                {{ Form::submit('Edit the gate', ['class' => 'btn3 btn-primary']) }}
            </form>
            </div>
        </div>
    </div>
@endsection
