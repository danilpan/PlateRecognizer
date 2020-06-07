@extends('layouts.app')
@extends('layouts.sidenav')

@section('content')
    <div class="container">
        <div class="main col-sm col-md col-lg col-xl">
            <div class="history_head">
                <div class="visit_title">
                    <h2><span>V</span>isit history</h2>
                </div>
            </div>
            <div class="table">
                <table>
                    <tr>
                        <th>Gate</th>
                        <th>Plate Number</th>
                        <th>Entered</th>
                        <th>Date</th>
                    </tr>
                    @foreach($enters as $enter)
                        <tr>
                            <td>
                                {{$enter->gate->name}}
                            </td>
                            <td>
                                {{$enter->car->plate_number}}
                            </td>
                            <td>
                                {{$enter->has_entered==1?'Yes':'No'}}
                            </td>
                            <td>
                                {{$enter->created_at}}
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection
