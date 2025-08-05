<!--views/hotline/index.blade.php-->
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-between mb-4">
        <div class="col-md-6">
            <h2>Hotline Cases</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('hotline.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> New Case
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No. Antrian</th>
                            <th>Case</th>
                            <th>Title</th>
                            <th>To</th>
                            <th>Priority</th>
                            <th>Status</th>
                            <th>Last Message</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($hotlines as $hotline)
                        <tr>
                            <td>{{ $hotline->case_number }}</td>
                            <td>{{ $hotline->service_type }}</td>
                            <td>{{ $hotline->subject }}</td>
                            <td>
                                <span class="badge bg-secondary">
                                    {{ $hotline->recipient_type }}
                                </span>
                            </td>
                            <td>
                                @php
                                    $priorityClasses = [
                                        'low' => 'bg-info',
                                        'medium' => 'bg-primary',
                                        'high' => 'bg-warning',
                                        'critical' => 'bg-danger'
                                    ];
                                @endphp
                                <span class="badge {{ $priorityClasses[$hotline->priority] ?? 'bg-secondary' }}">
                                    {{ ucfirst($hotline->priority) }}
                                </span>
                            </td>
                            <td>
                                @php
                                    $statusClasses = [
                                        'open' => 'bg-success',
                                        'processing' => 'bg-info',
                                        'resolved' => 'bg-secondary',
                                        'archived' => 'bg-dark'
                                    ];
                                @endphp
                                <span class="badge {{ $statusClasses[$hotline->status] ?? 'bg-secondary' }}">
                                    {{ ucfirst($hotline->status) }}
                                </span>
                            </td>
                            <td>
                                @if($hotline->lastMessage)
                                    <small class="text-muted">
                                        {{ $hotline->lastMessage->created_at->diffForHumans() }}
                                    </small>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('hotline.show', $hotline->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye"></i> View
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">No hotline cases found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection