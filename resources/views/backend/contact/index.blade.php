@extends('backend.layout')
@section('backend_title', 'Contact list')
@section('backend_content')

    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1 fw-bold">Contact Messages</h4>
                <p class="text-muted mb-0">All customer inquiries in one place</p>
            </div>
            <div class="d-flex align-items-center gap-3">
                @if ($unreadCount > 0)
                    <div class="d-flex align-items-center gap-2 px-3 py-2 rounded-3"
                        style="background:#fff3cd;border:1px solid #ffc107;">
                        <span class="badge bg-danger rounded-pill fs-6 px-2">{{ $unreadCount }}</span>
                        <span class="text-dark fw-semibold" style="font-size:14px;">
                            Unread Message{{ $unreadCount > 1 ? 's' : '' }}
                        </span>
                    </div>
                @else
                    <div class="d-flex align-items-center gap-2 px-3 py-2 rounded-3"
                        style="background:#d1e7dd;border:1px solid #198754;">
                        <i class="fas fa-check-circle text-success"></i>
                        <span class="text-success fw-semibold" style="font-size:14px;">All Read</span>
                    </div>
                @endif

            </div>
        </div>



        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th class="ps-4">#</th>
                                <th>Name</th>
                                <th>Phone</th>

                                <th>Status</th>
                                <th>Date</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($contacts as $index => $contact)
                                <tr class="{{ !$contact->is_read ? 'table-warning' : '' }}">
                                    <td class="ps-4 text-muted">{{ $contacts->firstItem() + $index }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold"
                                                style="width:38px;height:38px;flex-shrink:0;
                                                   background:{{ !$contact->is_read ? '#ffc107' : '#e9ecef' }};
                                                   color:{{ !$contact->is_read ? '#000' : '#6c757d' }};">
                                                {{ strtoupper(substr($contact->name, 0, 1)) }}
                                            </div>
                                            <span class="{{ !$contact->is_read ? 'fw-bold text-dark' : 'fw-semibold' }}">
                                                {{ $contact->name }}
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="tel:{{ $contact->phone }}"
                                            class="text-decoration-none text-dark {{ !$contact->is_read ? 'fw-bold' : '' }}">
                                            <i class="fas fa-phone-alt text-success me-1" style="font-size:12px;"></i>
                                            {{ $contact->phone }}
                                        </a>
                                    </td>
                                    
                                    <td>
                                        @if (!$contact->is_read)
                                            <span class="badge bg-danger px-2 py-1">
                                                <i class="fas fa-circle me-1" style="font-size:8px;"></i> Unread
                                            </span>
                                        @else
                                            <span class="badge bg-success px-2 py-1">
                                                <i class="fas fa-check me-1" style="font-size:8px;"></i> Read
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <small class="{{ !$contact->is_read ? 'fw-bold text-dark' : 'text-muted' }}">
                                            <i class="far fa-clock me-1"></i>
                                            {{ $contact->created_at->format('d M Y') }}
                                        </small>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('dashboard.contacts.show', $contact->id) }}"
                                                class="btn btn-sm {{ !$contact->is_read ? 'btn-warning' : 'btn-outline-primary' }}"
                                                title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <form action="{{ route('dashboard.contacts.destroy', $contact->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this message?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="far fa-envelope-open fa-3x mb-3 d-block"></i>
                                            <p class="mb-0">No messages yet.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if ($contacts->hasPages())
                <div class="card-footer bg-white border-0 d-flex justify-content-end py-3 px-4">
                    {{ $contacts->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>

@endsection
