<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Status</th>
            <th>Slug</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($categories as $category)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $category->name }}</td>
            <td>{{ $category->status ? 'Active' : 'Inactive' }}</td>
            <td>{{ $category->slug }}</td>
            <td>
                <button class="btn btn-warning btn-sm editBtn" data-id="{{ $category->id }}">Edit</button>
                <button class="btn btn-danger btn-sm deleteBtn" data-id="{{ $category->id }}">Delete</button>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5">No categories found</td>
        </tr>
        @endforelse
    </tbody>
</table>
