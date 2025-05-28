@extends('layouts.admin')

@section('content')
    <div class="container">
        <h2>Pending Testimonials</h2>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if($testimonials->count() == 0)
            <p>No testimonials pending approval.</p>
        @else
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Testimonial</th>
                        <th>Date</th>
                        <th>Approve</th>
                        <th>Reject</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($testimonials as $testimonial)
                    <tr>
                        <td>{{ $testimonial->user->name }}</td>
                        <td>{{ $testimonial->text }}</td>
                        <td>{{ $testimonial->created_at->format('d M Y') }}</td>
                        <td>
                            <form action="{{ route('admin.testimonials.approve', $testimonial->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">Approve</button>
                            </form>
                        </td>
                        <td>
                            <form action="{{ route('admin.testimonials.reject', $testimonial->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection