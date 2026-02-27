@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3 fade-in-up">
        <h4 class="mb-0">Dashboard</h4>
        <div class="d-flex gap-2">
            <a href="{{ route('contacts.index') }}" class="btn btn-outline-primary">
                <i class="bi bi-person-lines-fill me-1"></i> Manage Contacts
            </a>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addContactModal">
                <i class="bi bi-plus-lg me-1"></i> Add Contact
            </button>
        </div>
    </div>

    <div class="row g-3 mb-4 fade-in-up">
        <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="card shadow-sm h-100 border-0">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3 text-primary bg-primary bg-opacity-10 rounded-3 p-2">
                        <i class="bi bi-person-badge" style="font-size: 1.5rem;"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Total Contacts</div>
                        <div class="h4 mb-0">{{ $totalContacts ?? 0 }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="card shadow-sm h-100 border-0">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3 text-warning bg-warning bg-opacity-10 rounded-3 p-2">
                        <i class="bi bi-star-fill" style="font-size: 1.5rem;"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Favorite Contacts</div>
                        <div class="h4 mb-0">{{ $favoriteCount ?? 0 }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (($favoriteContacts ?? collect())->count())
        <div class="card shadow-sm fade-in-up mb-4">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <strong><i class="bi bi-star-fill text-warning me-1"></i> Favorites</strong>
                <a href="{{ route('favorites.index') }}" class="btn btn-sm btn-outline-secondary">View All</a>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    @foreach ($favoriteContacts ?? [] as $f)
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                            <div class="card h-100 border-1 shadow-sm dash-fav-card" data-id="{{ $f->id }}"
                                style="cursor:pointer;">
                                <div class="card-body d-flex flex-column align-items-center text-center p-4">
                                    <div class="contact-avatar mb-2" style="width:56px;height:56px;">
                                        @if ($f->photo_path)
                                            <img src="{{ asset('storage/' . $f->photo_path) }}" alt="">
                                        @else
                                            {{ strtoupper(substr($f->first_name ?? 'A', 0, 1)) }}{{ strtoupper(substr($f->last_name ?? '', 0, 1)) }}
                                        @endif
                                    </div>
                                    <div class="fw-semibold">{{ $f->first_name }} {{ $f->last_name }}</div>
                                    <div class="text-muted small">{{ $f->email }}</div>
                                    @if ($f->city)
                                        <div class="badge-soft mt-2">{{ $f->city }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @else
        <div class="card shadow-sm fade-in-up mb-4">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <strong><i class="bi bi-star text-warning me-1"></i> Favorites</strong>
                <a href="{{ route('contacts.index') }}" class="btn btn-sm btn-outline-secondary">Add Favorites</a>
            </div>
            <div class="card-body text-center text-muted py-4">
                Mark contacts with the star to showcase them here.
            </div>
        </div>
    @endif

    <div class="card shadow-sm fade-in-up">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <strong>Recent Contacts</strong>
            <a href="{{ route('contacts.index') }}" class="btn btn-sm btn-outline-secondary">View All</a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="recent-contacts-table" class="table table-hover table-striped mb-0 " style="padding: 0px 12px 0px 12px;">
                    <thead class="table-light">
                        <tr>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>City</th>
                            <th>Birthday</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse(($recentContacts ?? []) as $c)
                            <tr>
                                <td>
                                    <div class="dt-user">
                                        <div class="dt-avatar">
                                            @if ($c->photo_path)
                                                <img src="{{ asset('storage/' . $c->photo_path) }}" alt="">
                                            @else
                                                {{ strtoupper(substr($c->first_name ?? 'A', 0, 1)) }}{{ strtoupper(substr($c->last_name ?? '', 0, 1)) }}
                                            @endif
                                        </div>
                                        <div class="min-w-0">
                                            <div class="dt-name text-truncate">{{ $c->first_name }} {{ $c->last_name }}</div>
                                            <div class="dt-email text-truncate">{{ $c->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $c->email }}</td>
                                <td>{{ $c->phone }}</td>
                                <td>{{ $c->city }}</td>
                                <td>{{ $c->birthday ?? '-' }}</td>
                                <td class="text-end">
                                    <button class="btn btn-sm btn-primary view-btn" data-id="{{ $c->id }}"><i class="bi bi-eye me-1"></i> View</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">No contacts yet. Use "Add Contact" to create your first one.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('contacts.modals')
@endsection

@push('scripts')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // jQuery Validate for Add Contact modal when opened from Dashboard
        function initDashboardFormValidation() {
            if (!$('#addContactForm').data('validator')) {
                $('#addContactForm').validate({
                    errorElement: 'div',
                    errorClass: 'invalid-feedback',
                    highlight: function(el) {
                        $(el).addClass('is-invalid');
                    },
                    unhighlight: function(el) {
                        $(el).removeClass('is-invalid');
                    },
                    errorPlacement: function(err, el) {
                        err.insertAfter(el);
                    },
                    rules: {
                        first_name: {
                            required: true,
                            maxlength: 100
                        },
                        last_name: {
                            required: true,
                            maxlength: 100
                        },
                        email: {
                            required: true,
                            email: true,
                            maxlength: 150
                        },
                        phone: {
                            required: true,
                            minlength: 5,
                            maxlength: 20
                        }
                    }
                });
            }
        }
        // Ensure Work & About fields exist in the dashboard modal
        function ensureDashboardWorkAboutFields() {
            const $form = $('#addContactForm');
            if ($form.find('[name=job_title]').length) return;
            const workHtml = `
          <hr class="my-2">
          <div class="row g-3">
            <div class="col-12"><div class="text-muted me-2 text-uppercase">Work</div><hr class="my-1"></div>
            <div class="col-md-6">
              <label class="form-label">Job Title</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-briefcase"></i></span>
                <input type="text" name="job_title" class="form-control" placeholder="e.g. Software Engineer">
              </div>
            </div>
            <div class="col-md-6">
              <label class="form-label">Company</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-building"></i></span>
                <input type="text" name="company" class="form-control" placeholder="e.g. Company name">
              </div>
            </div>
            <div class="col-md-6">
              <label class="form-label">Department</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-diagram-3"></i></span>
                <input type="text" name="department" class="form-control" placeholder="e.g. Department">
              </div>
            </div>
            <div class="col-md-6">
              <label class="form-label">Work Email</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                <input type="email" name="work_email" class="form-control" placeholder="e.g. work@example.com">
              </div>
            </div>
            <div class="col-md-6">
              <label class="form-label">Work Phone</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                <input type="text" name="work_phone" class="form-control" placeholder="e.g. +91 98765 43210">
              </div>
            </div>
            <div class="col-md-6">
              <label class="form-label">Website</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-globe"></i></span>
                <input type="url" name="website" class="form-control" placeholder="https://">
              </div>
            </div>
          </div>`;
            const aboutHtml = `
          <hr class="my-2">
          <div class="row g-3">
            <div class="col-12"><div class="text-muted me-2 text-uppercase">About</div><hr class="my-1"></div>
            <div class="col-md-6">
              <label class="form-label">Birthday</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                <input type="date" name="birthday" class="form-control">
              </div>
            </div>
            <div class="col-12">
              <label class="form-label">Notes</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                <textarea name="notes" class="form-control" rows="3" placeholder="Add any notes..."></textarea>
              </div>
            </div>
          </div>`;
            $form.append(workHtml + aboutHtml);
        }
        // Initialize on modal show to ensure elements exist
        // document.getElementById('addContactModal')?.addEventListener('shown.bs.modal', function() {
        //     ensureDashboardWorkAboutFields();
        //     initDashboardFormValidation();
        // });

        // DataTable on Recent Contacts: 10 per page with search
        $(function() {
            if ($('#recent-contacts-table').length) {
                const dt = $('#recent-contacts-table').DataTable({
                    pageLength: 10,
                    lengthChange: false,
                    searching: true,
                    info: false,
                    order: [
                        [4, 'desc']
                    ],
                    columnDefs: [{
                            targets: [0, 1, 2, 3, 4],
                            orderable: true
                        },
                        {
                            targets: [5],
                            orderable: false
                        }
                    ]
                });
                $('#recent-contacts-table_filter input').attr('placeholder', 'Search contacts...');
            }
        });

        // Quick add from dashboard (supports photo upload)
        $('#addContactForm').on('submit', function(e) {
            e.preventDefault();
            const form = $(this);
            initDashboardFormValidation();
            if (!form.valid()) return;
            const fd = new FormData(this);
            $.ajax({
                    url: '{{ route('contacts.store') }}',
                    method: 'POST',
                    data: fd,
                    processData: false,
                    contentType: false
                })
                .done(function() {
                    const addModal = bootstrap.Modal.getOrCreateInstance(document.getElementById('addContactModal'));
                    addModal.hide();
                    form[0].reset();
                    // Reload to refresh recent list and counters
                    window.location.reload();
                }).fail(function(xhr) {
                    const msg = xhr.responseJSON?.message || 'Failed to create contact.';
                    $('#addContactErrors').removeClass('d-none').text(msg);
                });
        });

        function fillAndShowViewModal(c) {
            const val = (v) => (v && String(v).trim().length ? v : '-');
            const initials = (f, l) => ((String(f || '').charAt(0) + String(l || '').charAt(0)) || 'A').toUpperCase();

            // Header
            if (c.photo_path) {
                $('#viewAvatar').html(`<img src="{{ asset('storage') }}/${c.photo_path}" alt="">`);
            } else {
                $('#viewAvatar').text(initials(c.first_name, c.last_name));
            }
            $('#viewFullName').text(val(`${c.first_name||''} ${c.last_name||''}`.trim()));
            $('#viewEmail').text(val(c.email));
            $('#removePhotoBtn').toggleClass('d-none', !c.photo_path).data('id', c.id);

            // Contact tab
            $('#viewPhone').text(val(c.phone));
            $('#viewAddress').text(val(c.address));
            $('#viewCity').text(val(c.city));
            $('#viewState').text(val(c.state));
            $('#viewCountry').text(val(c.country));
            $('#viewPostalCode').text(val(c.postal_code));

            // Work tab
            $('#viewJobTitle').text(val(c.job_title));
            $('#viewCompany').text(val(c.company));
            $('#viewDepartment').text(val(c.department));
            $('#viewWorkEmail').text(val(c.work_email));
            $('#viewWorkPhone').text(val(c.work_phone));
            if (c.website && String(c.website).trim()) {
                $('#viewWebsite').html(`<a href="${c.website}" target="_blank" rel="noopener">${c.website}</a>`);
            } else {
                $('#viewWebsite').text('-');
            }

            // About tab
            if (c.birthday) {
                try {
                    $('#viewBirthday').text(new Date(c.birthday).toLocaleDateString());
                } catch (e) {
                    $('#viewBirthday').text(val(c.birthday));
                }
            } else {
                $('#viewBirthday').text('-');
            }
            $('#viewNotes').text(val(c.notes));

            const viewModal = new bootstrap.Modal(document.getElementById('viewContactModal'));
            viewModal.show();
        }

        // View modal from recent list
        $(document).on('click', '.view-btn', function() {
            const id = $(this).data('id');
            $.get(`{{ url('/contacts') }}/${id}`).done(function(res) {
                fillAndShowViewModal(res.data || {});
            });
        });

        // View modal from dashboard favorites
        $(document).on('click', '.dash-fav-card', function() {
            const id = $(this).data('id');
            $.get(`{{ url('/contacts') }}/${id}`).done(function(res) {
                fillAndShowViewModal(res.data || {});
            });
        });

        // Remove photo from View modal (dashboard context)
        $(document).on('click', '#removePhotoBtn', function() {
            const id = $(this).data('id');
            if (!id) return;
            if (!confirm('Remove the current photo for this contact?')) return;
            const fd = new FormData();
            fd.append('_method', 'PUT');
            fd.append('remove_photo', '1');
            $.ajax({
                    url: `{{ url('/contacts') }}/${id}`,
                    method: 'POST',
                    data: fd,
                    processData: false,
                    contentType: false
                })
                .done(function() {
                    window.location.reload();
                });
        });
    </script>
@endpush
