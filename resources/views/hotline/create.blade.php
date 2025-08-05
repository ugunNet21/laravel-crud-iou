<!--views/hotline/create.blade.php-->
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Create New Hotline Case</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('hotline.store') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label for="recipient_type" class="form-label">Purpose To</label>
                                <select class="form-select" id="recipient_type" name="recipient_type" required>
                                    <option value="">Select Purpose</option>
                                    <option value="Back Office Kota">Back Office Kota</option>
                                    <option value="PIC">PIC</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="recipient_id" class="form-label">Recipient</label>
                                <select class="form-select" id="recipient_id" name="recipient_id" required>
                                    <option value="">Select Recipient</option>
                                    @foreach($recipientTypes['Back Office Kota'] as $user)
                                        <option value="{{ $user->id }}" data-type="Back Office Kota"
                                            class="recipient-option recipient-back-office">
                                            {{ $user->name }} - ({{ $user->email }})
                                        </option>
                                    @endforeach
                                    @foreach($recipientTypes['PIC'] as $user)
                                        <option value="{{ $user->id }}" data-type="PIC" class="recipient-option recipient-pic">
                                            {{ $user->name }} - ({{ $user->email }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="service_type" class="form-label">Service Type</label>
                                <select class="form-select" id="service_type" name="service_type" required>
                                    <option value="">Select Service Type</option>
                                    @foreach($serviceTypes as $type)
                                        <option value="{{ $type }}">{{ $type }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="subject" class="form-label">Subject</label>
                                <input type="text" class="form-control" id="subject" name="subject" required>
                            </div>

                            <div class="mb-3">
                                <label for="priority" class="form-label">Priority</label>
                                <select class="form-select" id="priority" name="priority" required>
                                    <option value="low">Low</option>
                                    <option value="medium">Medium</option>
                                    <option value="high">High</option>
                                    <option value="critical">Critical</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="message" class="form-label">Message</label>
                                <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="attachments" class="form-label">Attachments</label>
                                <input type="file" class="form-control" id="attachments" name="attachments[]" multiple>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="reset" class="btn btn-secondary me-md-2">Reset</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const recipientType = document.getElementById('recipient_type');
                const recipientSelect = document.getElementById('recipient_id');

                recipientType.addEventListener('change', function () {
                    const selectedType = this.value;

                    if (!selectedType) {
                        recipientSelect.innerHTML = '<option value="">Select Purpose first</option>';
                        recipientSelect.disabled = true;
                        return;
                    }

                    // Show loading state
                    recipientSelect.innerHTML = '<option value="">Loading recipients...</option>';
                    recipientSelect.disabled = false;

                    // Fetch recipients via AJAX
                    fetch(`/hotline/api/recipients?type=${encodeURIComponent(selectedType)}`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.length === 0) {
                                recipientSelect.innerHTML = '<option value="">No recipients found</option>';
                                return;
                            }

                            let options = '<option value="">Select Recipient</option>';
                            data.forEach(user => {
                                options += `<option value="${user.id}">${user.name} - (${user.email})</option>`;
                            });
                            recipientSelect.innerHTML = options;
                        })
                        .catch(error => {
                            console.error('Error fetching recipients:', error);
                            recipientSelect.innerHTML = '<option value="">Error loading recipients</option>';
                        });
                });
            });
        </script>
    @endpush
@endsection