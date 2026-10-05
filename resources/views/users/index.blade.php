@extends('layouts.app')

@section('content')
<div class="row mb-3">
    <div class="col-lg-12 margin-tb d-flex justify-content-between align-items-center">
        <div>
            <h2 class="fw-bold text-dark"><i class="fa-solid fa-users text-primary me-2"></i> Users Management</h2>
        </div>
        <div>
            <a class="btn btn-success font-bold" href="{{ route('users.create') }}"><i class="fa fa-plus"></i> Create New User</a>
        </div>
    </div>
</div>

<div class="table-responsive border rounded-3 shadow-sm">
    <table class="table table-bordered table-hover align-middle mb-0">
       <thead class="table-dark">
           <tr>
               <th>No</th>
               <th>Name</th>
               <th>Email</th>
               <th>Roles</th>
               <th width="320px" class="text-end">Action</th>
           </tr>
       </thead>
       <tbody>
           @foreach ($data as $key => $user)
            <tr>
                <td class="fw-bold">{{ ++$i }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                  @if(!empty($user->getRoleNames()))
                    @foreach($user->getRoleNames() as $v)
                       <label class="badge bg-success font-monospace">{{ $v }}</label>
                    @endforeach
                  @endif
                </td>
                <td class="text-end">
                     @if(Auth::id() !== $user->id && !session()->has('impersonator_id'))
                         <form method="POST" action="{{ route('users.impersonate', $user->id) }}" style="display:inline">
                             @csrf
                             <button type="submit" class="btn btn-warning btn-sm fw-bold text-dark" title="Impersonate user view"><i class="fa-solid fa-user-secret"></i> Impersonate</button>
                         </form>
                     @endif
                     <a class="btn btn-info btn-sm" href="{{ route('users.show',$user->id) }}"><i class="fa-solid fa-list"></i> Show</a>
                     <a class="btn btn-primary btn-sm" href="{{ route('users.edit',$user->id) }}"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                      <form method="POST" action="{{ route('users.destroy', $user->id) }}" style="display:inline">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i> Delete</button>
                      </form>
                </td>
            </tr>
         @endforeach
       </tbody>
    </table>
</div>

<div class="mt-3">
    {!! $data->links('pagination::bootstrap-5') !!}
</div>
@endsection