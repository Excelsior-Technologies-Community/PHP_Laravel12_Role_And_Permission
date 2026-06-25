@extends('layouts.app')


@section('content')


<div class="row mb-3">

    <div class="col-lg-12">

        <h2>
            Activity Logs
        </h2>

    </div>

</div>


<table class="table table-bordered">


    <tr>

        <th>No</th>

        <th>User</th>

        <th>Action</th>

        <th>Module</th>

        <th>Date</th>

    </tr>



    @foreach($logs as $log)


    <tr>


        <td>
            {{ $loop->iteration }}
        </td>


        <td>
            {{ $log->user->name }}
        </td>


        <td>
            {{ $log->action }}
        </td>


        <td>
            {{ $log->module }}
        </td>


        <td>
            {{ $log->created_at->format('d-m-Y H:i') }}
        </td>



    </tr>


    @endforeach


</table>



<div class="d-flex justify-content-center">

    {{ $logs->links() }}

</div>



@endsection