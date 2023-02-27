@if (Session::has('message'))
    <p style="color:green;">{{ Session::get('message') }}</p>
@endif


<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Permission</th>
            <th>Action</th>
        </tr>
    </thead>
    @php
        $i = 1;
    @endphp
    <tbody>
        @forelse ($role_with_permission as $role)
            <tr>
                <td>{{ $i++ }}</td>
                <td>{{ $role->name }}</td>
                <td>
                    @forelse ($role->permissions as $permission)
                        {{ $permission->name }}
                    @empty
                        <p>Permission not available!</p>
                    @endforelse
                </td>
                <td>
                    <a href="{{ route('roles.edit', Crypt::encrypt($role->id)) }}">Edit</a>
                </td>
            </tr>
        @empty
        @endforelse
    </tbody>
</table>
