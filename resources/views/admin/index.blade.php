@extends('layout', [
    'title' => 'Bazaar admin'
 ])

@php
    use App\Models\Role;
    $countRow = 1;
    $roleDescriptions = [
        'customer' => 'Geen adverteerder',
        'proprietary' => 'Particulier',
        'commercial' => 'Zakelijk'
    ];
@endphp

@section('content')
    <div class="col-2 ms-5 mt-5">
            <div class="form-group">
                <span class="fw-bold mb-2 text-uppercase"   >Op wat role wil je filteren</span>
                <div class=" mt-1">
                    <input class="form-check-input"
                           onclick="javascript:window.location.href='{{route('admin.index')}}'; return false"
                           {{($roleActive === 0)  ? "checked" : ""}} type="radio" id="role_all" name="role_all">
                    <label class="form-check-label" for="role_all">
                        Alles
                    </label>
                </div>
                @foreach($roles as $role)
                    <div class=" mt-1">
                        <input class="form-check-input"
                               onclick="javascript:window.location.href='{{route('admin.filter', $role->role_name)}}'; return false"
                               {{($roleActive ===  $role->role_name)  ? "checked" : ""}} id="role_user_{{$role->role_name}}" type="radio" name="role_user_{{$role->role_name}}">
                        <label class="form-check-label" for="role_user_{{$role->role_name}}">
                            {{ $roleDescriptions[$role->role_name] ?? '' }}
                        </label>
                    </div>
                @endforeach
            </div>
    </div>
    <div class="col mt-5">
        <h2 class="mb-5 text-uppercase">Lijst van gebruikers</h2>
        <table class="table" >
            <thead class="text-center text-uppercase">
            <tr>
                <th scope="col"></th>
                <th scope="col">Voornaam</th>
                <th scope="col">Achternaam</th>
                <th scope="col">E-mail</th>
                <th scope="col">Gebruiker role</th>
                <th scope="col">Acties</th>
            </tr>
            </thead>
            <tbody class="text-center">
                @foreach($users as $user)
                    <tr>
                        <th scope="row">{{$countRow++}}</th>
                        <td>{{$user->name}}</td>
                        <td>{{$user->lastname}}</td>
                        <td>{{$user->email}}</td>
                        <td>
                                {{$roleDescriptions[(Role::find($user->role_id))->role_name] ?? '' }}
                        </td>
                        <td>
                            <form action="{{route('users.edit', $user)}}" method="GET" style="display:inline;">
                                <button type="submit" class="btn btn-primary">Profiel</button>
                            </form>
                            @if((Role::find($user->role_id))->role_name === 'commercial')
                                <a  class="btn btn-secondary" href="{{route('admin.export.pdf', $user)}}">Export contract</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="col-2"></div>
@endsection
