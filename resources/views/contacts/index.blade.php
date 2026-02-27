@extends('layouts.app')

@section('content')
    <style>
        #addPhotoPreview{
            border: solid 1px black;
        }
        #editPhotoPreview{
            border: solid 1px black;
        }
    </style>
    <header class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <div class="row align-items-center g-3">
                <div class="col-12 col-md-4">
                    <h4 class="mb-0 fw-bold text-dark">
                        <i class="bi bi-person-lines-fill me-2 text-primary"></i>Address Book
                    </h4>
                </div>
                <div class="col-12 col-md-8">
                    <div class="d-flex flex-column flex-sm-row justify-content-md-end align-items-sm-center gap-2">
                        
                        <div class="input-group flex-grow-1 flex-md-grow-0" style="max-width: 300px;">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="bi bi-search text-muted"></i>
                            </span>
                            <input type="text" id="contactSearch" class="form-control border-start-0 bg-light" placeholder="Search contacts...">
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-primary d-inline-flex align-items-center" data-bs-toggle="modal" data-bs-target="#addContactModal">
                                <i class="bi bi-plus-lg me-1"></i> <span>New Contact</span>
                            </button>
                            <a href="{{ route('contacts.export.csv') }}" class="btn btn-outline-secondary d-inline-flex align-items-center">
                                <i class="bi bi-download me-1"></i> <span>Export</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div id="alerts"></div>

    <div class="row g-3">
        <div id="listCol" class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div id="favoritesBar" class="favorites-rail d-flex flex-wrap align-items-center gap-2 mb-2"></div>
                    <div id="alphaRail" class="alpha-rail d-flex flex-wrap gap-1 mb-2"></div>
                    <div id="contactList" class="contact-list"></div>
                    <nav class="mt-3">
                        <ul id="contactPager" class="pagination pagination-sm justify-content-end mb-0"></ul>
                    </nav>
                </div>
            </div>
        </div>
        <div id="detailCol" class="col-lg-4 d-none">
            <div id="detailPanel" class="detail-panel h-100 d-none">
                <div class="detail-header p-3">
                    <div class="d-flex align-items-center gap-3">
                        <div id="detailAvatar" class="contact-avatar">AB</div>
                        <div>
                            <div id="detailName" class="fw-semibold">Select a contact</div>
                            <div id="detailSubtitle" class="text-muted small">Details will appear here</div>
                        </div>
                    </div>
                </div>
                <div class="p-3">
                    <ul class="nav nav-pills detail-pills mb-3" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="tab-contact" data-bs-toggle="pill" data-bs-target="#tabContact" type="button" role="tab">Contact</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="tab-work" data-bs-toggle="pill" data-bs-target="#tabWork" type="button" role="tab">Work</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="tab-about" data-bs-toggle="pill" data-bs-target="#tabAbout" type="button" role="tab">About</button>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="tabContact" role="tabpanel" aria-labelledby="tab-contact">
                            <div class="mb-2 small text-uppercase text-muted">Contact</div>
                            <dl class="row mb-0">
                                <dt class="col-4 text-muted">Phone</dt>
                                <dd id="detailPhone" class="col-8">—</dd>
                                <dt class="col-4 text-muted">Email</dt>
                                <dd id="detailEmail" class="col-8">—</dd>
                                <dt class="col-4 text-muted">Address</dt>
                                <dd id="detailAddress" class="col-8">—</dd>
                                <dt class="col-4 text-muted">City</dt>
                                <dd id="detailCity" class="col-8">—</dd>
                                <dt class="col-4 text-muted">State</dt>
                                <dd id="detailState" class="col-8">—</dd>
                                <dt class="col-4 text-muted">Country</dt>
                                <dd id="detailCountry" class="col-8">—</dd>
                                <dt class="col-4 text-muted">Postal</dt>
                                <dd id="detailPostal" class="col-8">—</dd>
                            </dl>
                        </div>
                        <div class="tab-pane fade" id="tabWork" role="tabpanel" aria-labelledby="tab-work">
                            <div class="mb-2 small text-uppercase text-muted">Work</div>
                            <dl class="row mb-0">
                                <dt class="col-4 text-muted">Job title</dt>
                                <dd id="detailJobTitle" class="col-8">—</dd>
                                <dt class="col-4 text-muted">Company</dt>
                                <dd id="detailCompany" class="col-8">—</dd>
                                <dt class="col-4 text-muted">Department</dt>
                                <dd id="detailDepartment" class="col-8">—</dd>
                                <dt class="col-4 text-muted">Work email</dt>
                                <dd id="detailWorkEmail" class="col-8">—</dd>
                                <dt class="col-4 text-muted">Work phone</dt>
                                <dd id="detailWorkPhone" class="col-8">—</dd>
                                <dt class="col-4 text-muted">Website</dt>
                                <dd id="detailWebsite" class="col-8">—</dd>
                            </dl>
                        </div>
                        <div class="tab-pane fade" id="tabAbout" role="tabpanel" aria-labelledby="tab-about">
                            <div class="mb-2 small text-uppercase text-muted">About</div>
                            <dl class="row mb-0">
                                <dt class="col-4 text-muted">Birthday</dt>
                                <dd id="detailBirthday" class="col-8">—</dd>
                                <dt class="col-4 text-muted">Notes</dt>
                                <dd id="detailNotes" class="col-8">—</dd>
                            </dl>
                        </div>
                    </div>
                    <div class="detail-actions mt-3 d-flex gap-2">
                        <button class="btn btn-outline-primary" id="openEditBtn" disabled><i class="bi bi-pencil me-1"></i> Edit</button>
                        <button class="btn btn-outline-danger" id="openDeleteBtn" disabled><i class="bi bi-trash me-1"></i> Delete</button>
                    </div>
                </div>
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

        let allContacts = [];
        let filtered = [];
        let selectedId = null;
        let searchQuery = '';
        let alphaFilter = null; // null = All, else 'A'..'Z' or '#'
        let pageSize = 10;
        let currentPage = 1;
        let totalPages = 1;
        window.STORAGE_BASE = window.STORAGE_BASE || `{{ asset('storage') }}`;

        // Bootstrap-friendly jQuery Validate setup for modal forms
        $.validator.addMethod("phoneRegex", function(value, element) {
            // This regex allows: (123) 456-7890, 123-456-7890, or 1234567890
            return this.optional(element) || /^(\+?\d{1,3}[- ]?)?\d{10}$/.test(value);
        }, "Please enter a valid phone number.");
        function initFormValidation() {
            const validateOptions = {
                errorElement: 'div',
                errorClass: 'invalid-feedback',
                highlight: function(element) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element) {
                    $(element).removeClass('is-invalid');
                },
                errorPlacement: function(error, element) {
                    error.insertAfter(element);
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
                        phoneRegex:true,
                    },
                    // Optional advanced fields
                    work_email: {
                        email: true
                    },
                    website: {
                        url: true
                    },
                    birthday: {
                        dateISO: true
                    }
                }
            };
            if ($('#addContactForm').length) {
                $('#addContactForm').validate(validateOptions);
            }
            if ($('#editContactForm').length) {
                $('#editContactForm').validate(validateOptions);
            }
        }

        function initials(first, last) {
            return (String(first || '').charAt(0) + String(last || '').charAt(0)).toUpperCase() || 'A';
        }
        // Inject Work & About fields into a given form if not present (so we avoid editing modal templates)
        function ensureWorkAboutFields($form) {
            if ($form.find('[name=job_title]').length) return;
            const workHtml = `
          <hr class="my-2">
          <div class="row g-3">
            <div class="col-12"><div class="text-muted me-2 text-uppercase">Work Details</div></div>
            <div class="col-md-6">
              <label class="form-label">Job Title</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-briefcase"></i></span>
                <input type="text" name="job_title" class="form-control" placeholder="e.g., Software Engineer">
              </div>
            </div>
            <div class="col-md-6">
              <label class="form-label">Company</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-building"></i></span>
                <input type="text" name="company" class="form-control" placeholder="Company name">
              </div>
            </div>
            <div class="col-md-6">
              <label class="form-label">Department</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-diagram-3"></i></span>
                <input type="text" name="department" class="form-control" placeholder="Department">
              </div>
            </div>
            <div class="col-md-6">
              <label class="form-label">Work Email</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                <input type="email" name="work_email" class="form-control" placeholder="work@example.com">
              </div>
            </div>
            <div class="col-md-6">
              <label class="form-label">Work Phone</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                <input type="text" name="work_phone" class="form-control" placeholder="+91 98765 43210">
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
                <div class="col-12"><div class="text-muted me-2 text-uppercase">About</div></div>
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

        function contactItemTpl(c) {
            return `
        <div class="contact-item fade-in-up" data-id="${c.id}">
            <div class="contact-avatar">${c.photo_path ? `<img src="${STORAGE_BASE}/${c.photo_path}" alt="">` : initials(c.first_name, c.last_name)}</div>
            <div class="flex-grow-1">
                <div class="d-flex justify-content-between align-items-center gap-2">
                    <div class="contact-name">${c.first_name} ${c.last_name} ${c.city ? `<span class='badge-soft ms-2'>${c.city}</span>` : ''}</div>
                    <div class="d-flex align-items-center gap-2">
                        <div class="contact-meta d-none d-sm-block">${c.phone || ''}</div>
                        <button type="button" class="btn btn-sm btn-light fav-toggle ${c.is_favorite ? 'active' : ''}" data-id="${c.id}" aria-label="Toggle favorite">
                            <i class="bi ${c.is_favorite ? 'bi-star-fill text-warning' : 'bi-star'}"></i>
                        </button>
                    </div>
                </div>
                <div class="contact-sub">${c.email || ''}</div>
            </div>
        </div>`;
        }

        function displayName(c) {
            const name = `${(c.first_name||'').trim()} ${(c.last_name||'').trim()}`.trim();
            return name || c.email || c.phone || '';
        }

        function groupKeyFromName(name) {
            const m = String(name).match(/[A-Za-z]/);
            return m ? m[0].toUpperCase() : '#';
        }

        function renderList(list) {
            if (!list.length) {
                return renderEmptyState();
            }
            const sorted = [...list].sort((a, b) => displayName(a).localeCompare(displayName(b), undefined, {
                sensitivity: 'base'
            }));
            const groups = {};
            for (const c of sorted) {
                const g = groupKeyFromName(displayName(c));
                if (!groups[g]) groups[g] = [];
                groups[g].push(c);
            }
            let html = '';
            for (const g of Object.keys(groups).sort()) {
                html += `<div class="contact-group-title">${g}</div>`;
                html += groups[g].map(contactItemTpl).join('');
            }
            $('#contactList').html(html);
        }

        function renderEmptyState() {
            $('#contactList').html(`
          <div class="empty-state p-4 text-center">
            <div class="mb-2"><i class="bi bi-person-lines-fill text-primary" style="font-size: 1.5rem;"></i></div>
            <div class="fw-semibold">No contacts found</div>
            <div class="small">Try adjusting your search or create a new contact.</div>
          </div>
        `);
        }

        function renderSkeletons(n = 5) {
            let arr = [];
            for (let i = 0; i < n; i++) {
                arr.push(`
                <div class="skeleton">
                    <div class="d-flex align-items-center gap-3">
                        <div class="contact-avatar"></div>
                        <div class="flex-grow-1">
                            <div class="skeleton-line"></div>
                            <div class="skeleton-line short mt-2"></div>
                        </div>
                    </div>
                </div>
            `);
            }
            $('#contactList').html(arr.join(''));
        }

        function loadContacts(selectFirst = false) {
            renderSkeletons(5);
            $.get(`{{ route('contacts.datatable') }}`).done(function(res) {
                allContacts = res.data || [];
                renderFavorites();
                applyFilters(selectFirst);
            });
        }

        function applyFilters(selectFirst = false) {
            const q = searchQuery.toLowerCase();
            filtered = allContacts.filter(c => (
                `${c.first_name} ${c.last_name} ${c.email} ${c.phone} ${c.city} ${c.country}`.toLowerCase()
                .includes(q)));
            if (alphaFilter) {
                filtered = filtered.filter(c => groupKeyFromName(displayName(c)) === alphaFilter);
            }
            // sort and paginate
            const sorted = [...filtered].sort((a, b) => displayName(a).localeCompare(displayName(b), undefined, {
                sensitivity: 'base'
            }));
            totalPages = Math.max(1, Math.ceil(sorted.length / pageSize));
            if (currentPage > totalPages) currentPage = totalPages;
            const start = (currentPage - 1) * pageSize;
            const pageItems = sorted.slice(start, start + pageSize);
            renderList(pageItems);
            renderPager();
            const stillThere = filtered.some(c => c.id === selectedId);
            if (!stillThere) {
                selectedId = null;
                $('#detailPanel').addClass('d-none');
                $('#detailCol').addClass('d-none').removeClass('col-lg-4');
                $('#listCol').removeClass('col-lg-8').addClass('col-lg-12');
                $('#openEditBtn, #openDeleteBtn').prop('disabled', true);
            }
            if (selectFirst && pageItems.length) selectContact(pageItems[0].id);
        }

        function renderFavorites() {
            const favs = (allContacts || []).filter(c => !!c.is_favorite);
            const $bar = $('#favoritesBar');
            if (!favs.length) {
                $bar.html(`<div class="text-muted small">Add favorites to show here.</div>`);
                return;
            }
            const chips = favs
                .sort((a, b) => `${a.first_name} ${a.last_name}`.localeCompare(`${b.first_name} ${b.last_name}`))
                .map(c => `
                <button type="button" class="fav-chip" data-id="${c.id}">
                    <div class="contact-avatar">${initials(c.first_name, c.last_name)}</div>
                    <span class="fw-semibold">${(c.first_name||'') + ' ' + (c.last_name||'')}</span>
                </button>
            `).join('');
            $bar.html(chips);
        }

        function selectContact(id) {
            selectedId = id;
            $('.contact-item').removeClass('active');
            $(`.contact-item[data-id="${id}"]`).addClass('active');
            $.get(`{{ url('/contacts') }}/${id}`).done(function(res) {
                const c = res.data;
                if (c.photo_path) {
                    $('#detailAvatar').html(`<img src="${STORAGE_BASE}/${c.photo_path}" alt="">`);
                } else {
                    $('#detailAvatar').text(initials(c.first_name, c.last_name));
                }
                $('#detailName').text(`${c.first_name} ${c.last_name}`);
                $('#detailSubtitle').text(c.email || '');
                $('#detailPhone').text(c.phone || '—');
                $('#detailEmail').text(c.email || '—');
                $('#detailAddress').text(c.address || '—');
                $('#detailCity').text(c.city || '—');
                $('#detailState').text(c.state || '—');
                $('#detailCountry').text(c.country || '—');
                $('#detailPostal').text(c.postal_code || '—');
                // Work
                $('#detailJobTitle').text(c.job_title || '—');
                $('#detailCompany').text(c.company || '—');
                $('#detailDepartment').text(c.department || '—');
                $('#detailWorkEmail').text(c.work_email || '—');
                $('#detailWorkPhone').text(c.work_phone || '—');
                if (c.website) {
                    $('#detailWebsite').html(
                        `<a href="${c.website}" target="_blank" rel="noopener">${c.website}</a>`);
                } else {
                    $('#detailWebsite').text('—');
                }
                // About
                if (c.birthday) {
                    try {
                        $('#detailBirthday').text(new Date(c.birthday).toLocaleDateString());
                    } catch (e) {
                        $('#detailBirthday').text(c.birthday);
                    }
                } else {
                    $('#detailBirthday').text('—');
                }
                $('#detailNotes').text(c.notes || '—');
                $('#openEditBtn, #openDeleteBtn').prop('disabled', false).data('id', id);
                // show detail column and restore 8/4 layout
                $('#detailCol').removeClass('d-none').addClass('col-lg-4');
                $('#listCol').removeClass('col-lg-12').addClass('col-lg-8');
                $('#detailPanel').removeClass('d-none');
            });
        }

        // Search
        $('#contactSearch').on('input', function() {
            searchQuery = $(this).val();
            currentPage = 1;
            applyFilters();
        });

        // Delegate click to list
        $(document).on('click', '.contact-item', function() {
            const id = $(this).data('id');
            selectContact(id);
        });

        // Toggle favorite without opening detail
        $(document).on('click', '.fav-toggle', function(e) {
            e.stopPropagation();
            const id = $(this).data('id');
            $.ajax({
                    url: `{{ url('/contacts') }}/${id}/favorite`,
                    method: 'PATCH'
                })
                .done(function(res) {
                    const c = res.data;
                    if (!c) return;
                    const idx = allContacts.findIndex(x => x.id === c.id);
                    if (idx >= 0) allContacts[idx] = c;
                    else allContacts.push(c);
                    renderFavorites();
                    applyFilters();
                }).fail(function() {
                    alert('Failed to toggle favorite.');
                });
        });

        // Click on favorite chip selects contact
        $(document).on('click', '.fav-chip', function() {
            const id = $(this).data('id');
            selectContact(id);
        });

        // Inject advanced sections when modals are opened
        // document.getElementById('addContactModal')?.addEventListener('shown.bs.modal', function() {
        //     ensureWorkAboutFields($('#addContactForm'));
        // });
        document.getElementById('editContactModal')?.addEventListener('shown.bs.modal', function() {
            ensureWorkAboutFields($('#editContactForm'));
        });

        // Create
        $('#addContactForm').on('submit', function(e) {
            e.preventDefault();
            const form = $(this);
            if (!form.valid()) return;
            const fd = new FormData(this);
            $.ajax({
                    url: '{{ route('contacts.store') }}',
                    method: 'POST',
                    data: fd,
                    processData: false,
                    contentType: false
                })
                .done(function(res) {
                    bootstrap.Modal.getOrCreateInstance(document.getElementById('addContactModal')).hide();
                    form[0].reset();
                    loadContacts(true);
                }).fail(function(xhr) {
                    const msg = xhr.responseJSON?.message || 'Failed to create contact.';
                    $('#addContactErrors').removeClass('d-none').text(msg);
                });
        });

        // Open edit from detail
        $('#openEditBtn').on('click', function() {
            const id = $(this).data('id');
            if (!id) return;
            $('#editContactId').val(id);
            $.get(`{{ url('/contacts') }}/${id}`).done(function(res) {
                const c = res.data;
                const f = $('#editContactForm');
                ensureWorkAboutFields(f);
                f.find('[name=first_name]').val(c.first_name);
                f.find('[name=last_name]').val(c.last_name);
                f.find('[name=email]').val(c.email);
                f.find('[name=phone]').val(c.phone);
                f.find('[name=address]').val(c.address);
                f.find('[name=city]').val(c.city);
                f.find('[name=state]').val(c.state);
                f.find('[name=country]').val(c.country);
                f.find('[name=postal_code]').val(c.postal_code);
                // Work & About
                f.find('[name=job_title]').val(c.job_title || '');
                f.find('[name=company]').val(c.company || '');
                f.find('[name=department]').val(c.department || '');
                f.find('[name=work_email]').val(c.work_email || '');
                f.find('[name=work_phone]').val(c.work_phone || '');
                f.find('[name=website]').val(c.website || '');
                f.find('[name=birthday]').val(c.birthday || '');
                f.find('[name=notes]').val(c.notes || '');
                // Set existing photo preview for Edit
                const $prev = $('#editPhotoPreview');
                $prev.data('photo', c.photo_path || '');
                if (c.photo_path) {
                    $prev.html(`<img src="${STORAGE_BASE}/${c.photo_path}" alt="">`);
                } else {
                    $prev.text(initials(c.first_name, c.last_name));
                }
                new bootstrap.Modal(document.getElementById('editContactModal')).show();
            });
        });

        // Submit edit
        $('#editContactForm').on('submit', function(e) {
            e.preventDefault();
            const form = $(this);
            if (!form.valid()) return;
            const id = $('#editContactId').val();
            const fd = new FormData(this);
            fd.append('_method', 'PUT');
            $.ajax({
                    url: `{{ url('/contacts') }}/${id}`,
                    method: 'POST',
                    data: fd,
                    processData: false,
                    contentType: false
                })
                .done(function() {
                    bootstrap.Modal.getOrCreateInstance(document.getElementById('editContactModal')).hide();
                    loadContacts();
                    if (selectedId) selectContact(selectedId);
                }).fail(function(xhr) {
                    const msg = xhr.responseJSON?.message || 'Failed to update contact.';
                    $('#editContactErrors').removeClass('d-none').text(msg);
                });
        });

        // Delete from detail
        $('#openDeleteBtn').on('click', function() {
            const id = $(this).data('id');
            if (!id) return;
            window.deleteId = id;
            // Put selected contact name in the confirmation modal
            const name = $('#detailName').text() || 'this contact';
            $('#deleteContactName').text(name);
            new bootstrap.Modal(document.getElementById('deleteContactModal')).show();
        });
        $('#confirmDeleteBtn').on('click', function() {
            const id = window.deleteId;
            if (!id) return;
            const $btn = $(this);
            const originalHtml = $btn.html();
            $btn.prop('disabled', true).prepend(
                '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>');
            $.ajax({
                    url: `{{ url('/contacts') }}/${id}`,
                    method: 'DELETE'
                })
                .done(function() {
                    loadContacts(true);
                    window.deleteId = null;
                    selectedId = null;
                    bootstrap.Modal.getOrCreateInstance(document.getElementById('deleteContactModal')).hide();
                }).fail(function(xhr) {
                    alert(xhr.responseJSON?.message || 'Failed to delete contact.');
                }).always(function() {
                    $btn.prop('disabled', false).html(originalHtml);
                });
        });

        function buildAlphaRail() {
            const letters = ['All'].concat(Array.from({
                length: 26
            }, (_, i) => String.fromCharCode(65 + i))).concat(['#']);
            const $rail = $('#alphaRail');
            $rail.empty();
            letters.forEach(l => {
                const isAll = l === 'All';
                const btn = $(
                    `<button type="button" class="alpha-btn ${isAll ? 'active':''}" data-key="${isAll? '': l}">${l}</button>`
                    );
                btn.on('click', function() {
                    $rail.find('.alpha-btn').removeClass('active');
                    $(this).addClass('active');
                    alphaFilter = $(this).data('key') || null;
                    currentPage = 1;
                    applyFilters(true);
                    $('#contactList').scrollTop(0);
                });
                $rail.append(btn);
            });
        }

        function renderPager() {
            const $p = $('#contactPager');
            $p.empty();
            if (totalPages <= 1) return;
            const addItem = (label, page, disabled = false, active = false) => {
                const li = $(
                    `<li class="page-item ${disabled?'disabled':''} ${active?'active':''}"><a class="page-link" href="#" data-page="${page}">${label}</a></li>`
                    );
                if (!disabled) {
                    li.on('click', 'a', function(e) {
                        e.preventDefault();
                        currentPage = page;
                        applyFilters();
                        $('#contactList').scrollTop(0);
                    });
                }
                $p.append(li);
            };
            addItem('«', Math.max(1, currentPage - 1), currentPage === 1, false);
            let start = Math.max(1, currentPage - 2);
            let end = Math.min(totalPages, start + 4);
            start = Math.max(1, end - 4);
            for (let i = start; i <= end; i++) addItem(i, i, false, i === currentPage);
            addItem('»', Math.min(totalPages, currentPage + 1), currentPage === totalPages, false);
        }

        function init() {
            initFormValidation();
            buildAlphaRail();
            loadContacts(true);
        }
        init();
    </script>
@endpush
