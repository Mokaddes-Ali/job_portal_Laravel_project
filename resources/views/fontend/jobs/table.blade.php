<table class="table table-bordered">
    <thead>
        <tr>
            <th>Title</th>
            <th>Category</th>
            <th>Job Type</th>
            <th>Vacancy</th>
            <th>Location</th>
            <th>Company</th>
        </tr>
    </thead>
    <tbody>
        @forelse($jobs as $job)
        <tr>
            <td>{{ $job->title }}</td>
            <td>{{ $job->category->name }}</td>
            <td>{{ $job->jobType->name }}</td>
            <td>{{ $job->vacancy }}</td>
            <td>{{ $job->location }}</td>
            <td>{{ $job->company_name }}</td>
        </tr>
        @empty
        <tr><td colspan="6">No jobs found</td></tr>
        @endforelse
    </tbody>
</table>
