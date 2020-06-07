@extends('layouts.app')
@extends('layouts.sidenav')

@section('content')
    <div class="container">
        <div class="main col-sm col-md col-lg col-xl">
        <div class="title_companies">
                <h2>Create new office</h2>
            </div>
            {{ HTML::ul($errors->all() )}}

            <div class="company_form">
            <form action="{{ route('offices.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    {{ Form::label('full_address', 'Full Address') }}
                    {{ Form::text('full_address', Request::old('full_address'), array('class' => 'form-control')) }}
                </div>

                <div class="form-group">
                    {{ Form::label('company_id', 'Company') }}

                    <select name="company_id"
                            class="form-control {{ $errors->has('company_id') ? ' is-invalid' : '' }}">
                        @foreach( $companies as $company ):
                        <option value="{{ $company->id }}" {{ (old("company_id") == $company->id ? "selected":"") }}>
                            {{$company->official_name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                {{ Form::submit('Create the Office', array('class' => 'btn2 btn-primary')) }}

            </form>
            </div>
        </div>
    </div>
@endsection
