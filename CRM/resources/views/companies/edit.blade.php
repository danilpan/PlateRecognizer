@extends('layouts.app')
@extends('layouts.sidenav')

@section('content')
    <div class="container">
        <div class="main col-sm col-md col-lg col-xl">
            <div class="title_companies">
                <h2>Edit company</h2>
            </div>
            {{ HTML::ul($errors->all()) }}
            {{ Form::model($company, array('action' => array('CompanyController@update', $company->id), 'method' => 'PUT'))}}

            <div class="company_form">
                <div class="form-group">
                    {{ Form::label('short_name', 'Short Name') }}
                    {{ Form::text('short_name', Request::old('short_name'), array('class' => 'form-control')) }}
                </div>

                <div class="form-group">
                    {{ Form::label('official_name', 'Official Name') }}
                    {{ Form::text('official_name', Request::old('official_name'), array('class' => 'form-control')) }}
                </div>

                {{ Form::submit('Edit the Company', array('class' => 'btn2 btn-primary')) }}

                {{ Form::close() }}

            </div>
        </div>
    </div>
@endsection
