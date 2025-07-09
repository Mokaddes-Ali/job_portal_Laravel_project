<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse($jobTypes as $type)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $type->name }}</td>
            <td>{{ $type->status ? 'Active' : 'Inactive' }}</td>
            <td>
                <button class="btn btn-warning btn-sm editBtn" data-id="{{ $type->id }}">Edit</button>
                <button class="btn btn-danger btn-sm deleteBtn" data-id="{{ $type->id }}">Delete</button>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="4">No Job Types Found</td>
        </tr>
        @endforelse
    </tbody>
</table>
