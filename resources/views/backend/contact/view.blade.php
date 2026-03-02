@extends('backend.layout')
@section('backend_title', 'Message View')
@section('backend_content')

<div class="container-fluid py-4">
    <div class="mb-4">
        <a href="{{ route('dashboard.contact-list') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-2"></i>Back to Messages
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white py-3 px-4 border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-semibold">
                            <i class="far fa-envelope me-2"></i> Message Detail
                        </h5>
                        <div class="d-flex align-items-center gap-3">
                            <span class="badge bg-success px-3 py-2">
                                <i class="fas fa-check me-1"></i> Read
                            </span>
                            <small class="opacity-75">
                                <i class="far fa-clock me-1"></i>
                                {{ $contact->created_at->format('d M Y') }}
                            </small>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-3 mb-4 p-3 bg-light rounded-3">
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold fs-4"
                            style="width:56px;height:56px;flex-shrink:0;">
                            {{ strtoupper(substr($contact->name, 0, 1)) }}
                        </div>
                        <div>
                            <h5 class="mb-1 fw-bold">{{ $contact->name }}</h5>
                            <a href="tel:{{ $contact->phone }}" class="text-decoration-none text-muted">
                                <i class="fas fa-phone-alt me-1 text-success" style="font-size:13px;"></i>
                                {{ $contact->phone }}
                            </a>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="text-muted text-uppercase fw-semibold mb-2" style="font-size:11px;letter-spacing:1px;">
                            <i class="fas fa-comment-dots me-1"></i> Message
                        </label>
                        <div class="p-4 border rounded-3 bg-white" style="line-height:1.8;min-height:120px;">
                            {{ $contact->message }}
                        </div>
                    </div>


                </div>

                <div class="card-footer bg-white border-top d-flex justify-content-between align-items-center px-4 py-3">
                    <a href="tel:{{ $contact->phone }}" class="btn btn-success btn-sm px-4">
                        <i class="fas fa-phone me-2"></i>Call Now
                    </a>
                    <form action="{{ route('dashboard.contacts.destroy', $contact->id) }}" method="POST"
                        onsubmit="return confirm('Delete this message permanently?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm px-4">
                            <i class="fas fa-trash me-2"></i>Delete Message
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
