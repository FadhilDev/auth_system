@extends('layouts.app')

@section('content')
    <div class="container">
    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ $message }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <table class="table table-bordered">
        <thead>
        <th>Name</th>
        <th>E-Mail</th>
        <th>Admin</th>
        <th>Author</th>
        <th>User</th>
        <th>Action</th>
        </thead>
        <tbody>
        <a class="btn  btn-sm btn-success m-2" href="{{route('admin.create')}}">New</a>
        @foreach($users as $user)
            <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }} <input type="hidden" name="email" value="{{ $user->email }}"></td>
                    <td><input type="checkbox" {{ $user->hasRole('Admin') ? 'checked' : '' }} name="role_admin" onclick="return false;"></td>
                    <td><input type="checkbox" {{ $user->hasRole('Author') ? 'checked' : '' }} name="role_author" onclick="return false;"></td>
                    <td><input type="checkbox" {{ $user->hasRole('User') ? 'checked' : '' }} name="role_user" onclick="return false;"></td>

                    <td class="d-flex">
                        <a  href="{{ route('admin.edit',$user->id)}}" class="btn  btn-sm btn-primary mr-1">Edit</a>
                        <a href="{{ route('admin.edit',$user->id)}}" class="btn  btn-sm btn-secondary">Change Password</a>
                        <form class="delFrm" action="{{route('admin.destroy',$user->id)}}" method="post">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger mx-1 del" type="submit">Delete</button>
                        </form>
                    </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {!! $users->render() !!}
    </div>
    <script>
     $('.delFrm').on('submit',function (e) {
         e.preventDefault();
         let form=this;
                bootbox.confirm({
                    size: "small",
                message: "Are you sure?",
                buttons: {
                    confirm: {
                        label: 'Yes',
                        className: 'btn-sm btn-success'
                    },
                    cancel: {
                        label: 'No',
                        className: ' btn-sm btn-danger'
                    }
                },

                callback: function (result) {
                    if(result===true){
                        form.submit();
                    }

                }
            });

            });


    </script>
@endsection
