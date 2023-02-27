<form action="{{ $edit_role->id ? route('roles.update', $edit_role->id) : route('roles.store') }}" method="post">
    @if ($edit_role->id)
        @method('PUT')
    @endif
    @csrf
    <label for="name">Name</label>
    <input type="text" name="name" id="" value="{{ old('name', $edit_role->name) }}"><br><br>
    @foreach ($permissions as $permission)
        <label for="">{{ $permission->name }}</label>
        <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
            {{ $edit_role->permissions->pluck('id')->contains($permission->id) ? 'checked' : '' }}>
    @endforeach
    <br><br>
    <button type="submit">Add</button>
</form>
