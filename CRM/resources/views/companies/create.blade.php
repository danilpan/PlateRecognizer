@extends('layouts.app')
@extends('layouts.sidenav')

@section('content')
    <div class="container">
        <div class="main col-sm col-md col-lg col-xl">
            <div class="title_companies">
                <h2>Create new company</h2>
            </div>
            {{ HTML::ul($errors->all() )}}

            <div class="company_form">
                <form action="{{ route('companies.store') }}" method="POST">

                    <div class="form-group">
                        {{ Form::label('short_name', 'Short Name') }}
                        {{ Form::text('short_name', Request::old('short_name'), array('class' => 'form-control')) }}
                    </div>

                    <div class="form-group">
                        {{ Form::label('official_name', 'Official Name') }}
                        {{ Form::text('official_name', Request::old('official_name'), array('class' => 'form-control')) }}
                    </div>

                    {{ Form::submit('Create the Company', array('class' => 'btn btn-primary')) }}

                </form>
            </div>
        </div>
    </div>
@endsection
