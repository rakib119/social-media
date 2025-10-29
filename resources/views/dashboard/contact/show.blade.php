@extends('dashboard.layout.dashboard')
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
@endsection
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="page-title-box">
                <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <div class="page-title">
                            <h4>Message Details</h4>
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('contact.index')}}">Messages</a></li>
                                    <li class="breadcrumb-item active">{{ $message->subject }}</li>
                                </ol>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="float-end d-none d-sm-block">
                            <a href="{{ route('dashboard') }}" class="btn btn-success">Back</a>
                        </div>
                    </div>
                </div>
                </div>
            </div>
            <div class="container-fluid">
                <div class="page-content-wrapper">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="float-end d-none d-sm-block">
                                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#replyEmailModal">Reply</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-7">
                                            <div class="mt-4 mt-xl-3">
                                                <a href="#" class="text-primary">Subject: {{ $message?->subject }}</a>
                                                <h5 class="mt-1 mb-3">Form: {{ $message?->name }}</h5>
                                                <p class="mt-1 mb-3">Phone: {{ $message?->mobile  }}</p>
                                                <p class="mt-1 mb-3">Email Address: {{ $message?->email }}</p>
                                                <hr class="my-4">
                                                <div class="mt-4">
                                                    <h6>Messages :</h6>
                                                <div class="mt-4">
                                                    <P> {{ $message?->message }}</P>
                                                </div>
                                                @if (count($replies))
                                                    <div class="mt-4">
                                                        <h5 class="text-primary">Reply :</h5>
                                                        @foreach  ($replies as $reply)
                                                            <div class="mt-4">
                                                                <P> {{ $reply?->body }}</P>
                                                            </div>
                                                            <div class="mt-4">
                                                                <p class="text-muted mb-0">Sent on: {{ $reply->created_at }}</p>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reply Email Modal -->
    <div class="modal fade" id="replyEmailModal" tabindex="-1" aria-labelledby="replyEmailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="replyEmailModalLabel">Reply to Email</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('email.reply') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="recipient" class="form-label">To</label>
                            <input type="email" class="form-control" id="recipient" name="recipient" value="{{ $message?->email }}" required readonly>
                            <input type="hidden" class="form-control" id="name" name="name" value="{{ $message?->name }}">
                            <input type="hidden" class="form-control" id="contact_id" name="contact_id" value="{{ $message?->id }}">
                        </div>

                        <div class="mb-3">
                            <label for="subject" class="form-label">Subject</label>
                            <input type="text" class="form-control" id="subject" name="subject" required value="Re: {{ $message?->subject }}">
                        </div>

                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control" id="message" name="message" rows="6" placeholder="Write your message here..." required></textarea>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Send Reply</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection

{{-- Javascript --}}
@section('javacript')
    <script>
        document.addEventListener('DOMContentLoaded', function ()
        {
            const form      = document.getElementById('replyEmailForm');
            const alertBox  = document.getElementById('formAlert');

            form.addEventListener('submit', function (e) {
                e.preventDefault();

                // Clear old alerts
                alertBox.classList.add('d-none');
                alertBox.classList.remove('alert-success', 'alert-danger');

                // Validate fields
                const recipient = form.recipient.value.trim();
                const subject   = form.subject.value.trim();
                const message   = form.message.value.trim();

                if (!recipient || !subject || !message) {
                    alertBox.textContent = "All fields are required.";
                    alertBox.classList.remove('d-none');
                    alertBox.classList.add('alert-danger');
                    return;
                }

                // Create form data
                const formData = new FormData(form);

                // Send AJAX request
                fetch("{{ route('email.reply') }}", {
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alertBox.textContent = data.message || "Email sent successfully.";
                        alertBox.classList.remove('d-none');
                        alertBox.classList.add('alert-success');
                        form.reset();
                    } else {
                        alertBox.textContent = data.message || "An error occurred.";
                        alertBox.classList.remove('d-none');
                        alertBox.classList.add('alert-danger');
                    }
                })
                .catch(error =>
                {
                    console.error("Error:", error);
                    alertBox.textContent = "Something went wrong.";
                    alertBox.classList.remove('d-none');
                    alertBox.classList.add('alert-danger');
                });
            });
        });
    </script>
@endsection

