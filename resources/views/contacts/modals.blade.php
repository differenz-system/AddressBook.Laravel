<!-- Add Contact Modal -->
<div class="modal fade" id="addContactModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title"><i class="bi bi-person-plus me-2"></i>Add Contact</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-2">
                <div id="addContactErrors" class="alert alert-danger d-none"></div>
                <form id="addContactForm" enctype="multipart/form-data">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Photo</label>
                            <div class="photo-uploader d-flex align-items-center gap-3">
                                <div id="addPhotoPreview" class="avatar-preview avatar-lg">A</div>
                                <div class="flex-grow-1">
                                    <input type="file" name="photo" accept="image/*" class="form-control">
                                    <div class="form-text">PNG, JPG or WEBP up to 2MB.</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">First Name</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input type="text" name="first_name" class="form-control" required placeholder="e.g. John">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Last Name</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input type="text" name="last_name" class="form-control" required placeholder="e.g. Doe">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" name="email" class="form-control" required placeholder="e.g. name@example.com">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Phone</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                <input type="text" name="phone" class="form-control" required placeholder="e.g. +91 98765 43210">
                            </div>
                        </div>
                        <div class="col-12">
                            <hr class="my-1">
                            <div class="text-muted me-2 text-uppercase">Address Details</div>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Address</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                                <input type="text" name="address" class="form-control" placeholder="Street, area, etc.">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">City</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-buildings"></i></span>
                                <input type="text" name="city" class="form-control" placeholder="City">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">State</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-geo"></i></span>
                                <input type="text" name="state" class="form-control" placeholder="State">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Country</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-globe"></i></span>
                                <input type="text" name="country" class="form-control" placeholder="Country">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Postal Code</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-mailbox"></i></span>
                                <input type="text" name="postal_code" class="form-control" placeholder="ZIP / PIN">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="addContactForm" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        // Initialize Bootstrap-friendly jQuery Validation for Add/Edit modals
        $.validator.addMethod("phoneRegex", function(value, element) {
            // This regex allows: (123) 456-7890, 123-456-7890, or 1234567890
            return this.optional(element) || /^(\+?\d{1,3}[- ]?)?\d{10}$/.test(value);
        }, "Please enter a valid phone number.");
        function initModalValidation() {
            const opts = {
                errorElement: 'div',
                errorClass: 'invalid-feedback',
                highlight: function(el) {
                    $(el).addClass('is-invalid');
                },
                unhighlight: function(el) {
                    $(el).removeClass('is-invalid');
                },
                errorPlacement: function(error, element) {
                    // Place error after input-group wrapper when present
                    if (element.parent('.input-group').length) {
                        error.insertAfter(element.parent());
                    } else {
                        error.insertAfter(element);
                    }
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
                        phoneRegex: true,
                        minlength: 10,
                    },
                    work_email: {
                        email: true
                    },
                    website: {
                        url: true
                    },
                    birthday: {
                        dateISO: true
                    }
                },
                messages: {
                    first_name:{
                        required:"Please enter first name",
                        maxlength:"First name cannot exceed 100 characters"
                    },
                    last_name:{
                        required:"Please enter last name",
                        maxlength: "Last name cannot exceed 100 characters"
                    },
                    email:{
                        required:"Please enter email",
                        email:"Please enter valid email",
                        maxlength:"Email cannot exceed 150 characters"
                    },
                    phone:{
                        required:"Please enter phone",
                        phoneRegex:"Phone must be a number",
                        minlength:"Phone cannot be less than 10 characters"
                    }
                }
            };

            const $add = $('#addContactForm');
            if ($add.length && !$add.data('validator')) {
                $add.validate(opts);
            }
            const $edit = $('#editContactForm');
            if ($edit.length && !$edit.data('validator')) {
                $edit.validate(opts);
            }
        }

        // Initialize when modals are shown to ensure elements exist
        document.getElementById('addContactModal')?.addEventListener('shown.bs.modal', initModalValidation);
        document.getElementById('editContactModal')?.addEventListener('shown.bs.modal', initModalValidation);

        // Extra guard: block submit if invalid (coexists with page-specific AJAX handlers)
        $(document).on('submit', '#addContactForm, #editContactForm', function(e) {
            const $f = $(this);
            initModalValidation();
            if (!$f.valid()) {
                e.preventDefault();
            }
        });

        // =============================
        // Image preview (Add/Edit)
        // =============================
        const STORAGE_BASE = `{{ asset('storage') }}`;

        function initialsFrom($form) {
            const f = ($form.find('[name=first_name]').val() || '').toString();
            const l = ($form.find('[name=last_name]').val() || '').toString();
            const init = (f.charAt(0) + l.charAt(0)).toUpperCase();
            return init || 'A';
        }

        function setPreview($el, file, fallbackText, existingPath) {
            if (file) {
                const reader = new FileReader();
                reader.onload = e => {
                    $el.html(`<img src="${e.target.result}" alt="">`);
                };
                reader.readAsDataURL(file);
                return;
            }
            if (existingPath) {
                $el.html(`<img src="${STORAGE_BASE}/${existingPath}" alt="">`);
                return;
            }
            $el.text(fallbackText || 'A');
        }

        function bindPreview(formSel, previewSel) {
            const $form = $(formSel);
            const $preview = $(previewSel);
            const $file = $form.find('input[name=photo]');
            const $remove = $form.find('input[name=remove_photo]');
            // Default on show
            const onShow = () => {
                const existing = $preview.data('photo') || '';
                setPreview($preview, null, initialsFrom($form), existing);
            };
            document.querySelector(formSel)?.closest('.modal')?.addEventListener('shown.bs.modal', onShow);
            // On file change
            $file.on('change', function() {
                const file = this.files && this.files[0] ? this.files[0] : null;
                if ($remove.length) $remove.prop('checked', false);
                setPreview($preview, file, initialsFrom($form), null);
            });
            // On name change (if no file chosen and no existing photo)
            $form.on('input', '[name=first_name],[name=last_name]', function() {
                const hasFile = $file[0] && $file[0].files && $file[0].files.length;
                const existing = $preview.data('photo') || '';
                if (!hasFile && !existing) setPreview($preview, null, initialsFrom($form), null);
            });
            // On remove toggle
            if ($remove.length) {
                $remove.on('change', function() {
                    if ($(this).is(':checked')) {
                        if ($file.val()) {
                            $file.val('');
                        }
                        $preview.data('photo', '');
                        setPreview($preview, null, initialsFrom($form), null);
                    }
                });
            }
        }
        // Bind for both forms
        bindPreview('#addContactForm', '#addPhotoPreview');
        bindPreview('#editContactForm', '#editPhotoPreview');
    </script>
@endpush

<!-- Edit Contact Modal -->
<div class="modal fade" id="editContactModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title"><i class="bi bi-pencil-square me-2"></i>Edit Contact</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-2">
                <div id="editContactErrors" class="alert alert-danger d-none"></div>
                <form id="editContactForm" enctype="multipart/form-data">
                    <input type="hidden" id="editContactId">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Photo</label>
                            <div class="photo-uploader d-flex align-items-center gap-3">
                                <div id="editPhotoPreview" class="avatar-preview avatar-lg">A</div>
                                <div class="flex-grow-1">
                                    <input type="file" name="photo" accept="image/*" class="form-control">
                                    <div class="d-flex justify-content-between align-items-center mt-2">
                                        <div class="form-text">PNG, JPG or WEBP up to 2MB.</div>
                                        <div class="form-check ms-2">
                                            <input class="form-check-input" type="checkbox" name="remove_photo"
                                                value="1" id="removePhotoChk">
                                            <label class="form-check-label" for="removePhotoChk">Remove current
                                                photo</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">First Name</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input type="text" name="first_name" class="form-control" required
                                    placeholder="e.g. John">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Last Name</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input type="text" name="last_name" class="form-control" required
                                    placeholder="e.g. Doe">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" name="email" class="form-control" required
                                    placeholder="e.g. name@example.com">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Phone</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                <input type="text" name="phone" class="form-control" required
                                    placeholder="e.g. +91 98765 43210">
                            </div>
                        </div>
                        <div class="col-12">
                            <hr class="my-1">
                            <div class="text-muted me-2 text-uppercase">Address</div>
                            <hr class="my-1">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Address</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                                <input type="text" name="address" class="form-control"
                                    placeholder="Street, area, etc.">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">City</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-buildings"></i></span>
                                <input type="text" name="city" class="form-control" placeholder="City">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">State</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-geo"></i></span>
                                <input type="text" name="state" class="form-control" placeholder="State">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Country</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-globe"></i></span>
                                <input type="text" name="country" class="form-control" placeholder="Country">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Postal Code</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-mailbox"></i></span>
                                <input type="text" name="postal_code" class="form-control"
                                    placeholder="ZIP / PIN">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="editContactForm" class="btn btn-primary">Update</button>
            </div>
        </div>
    </div>
</div>

<!-- View Contact Modal -->
<div class="modal fade" id="viewContactModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title">Contact Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-2">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div id="viewAvatar" class="contact-avatar">AB</div>
                    {{-- <button type="button" id="removePhotoBtn" class="btn btn-sm btn-outline-danger d-none"><i class="bi bi-image-alt me-1"></i> Remove Photo</button> --}}
                    <div>
                        <div id="viewFullName" class="fw-semibold">-</div>
                        <div id="viewEmail" class="text-muted small">-</div>
                    </div>
                </div>

                <ul class="nav nav-pills detail-pills mb-3" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="vc-tab-contact" data-bs-toggle="pill"
                            data-bs-target="#vcContact" type="button" role="tab">Contact</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="vc-tab-work" data-bs-toggle="pill" data-bs-target="#vcWork"
                            type="button" role="tab">Work</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="vc-tab-about" data-bs-toggle="pill" data-bs-target="#vcAbout"
                            type="button" role="tab">About</button>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="vcContact" role="tabpanel"
                        aria-labelledby="vc-tab-contact">
                        <dl class="row mb-0">
                            <dt class="col-4 text-muted">Phone</dt>
                            <dd id="viewPhone" class="col-8">-</dd>
                            <dt class="col-4 text-muted">Address</dt>
                            <dd id="viewAddress" class="col-8">-</dd>
                            <dt class="col-4 text-muted">City</dt>
                            <dd id="viewCity" class="col-8">-</dd>
                            <dt class="col-4 text-muted">State</dt>
                            <dd id="viewState" class="col-8">-</dd>
                            <dt class="col-4 text-muted">Country</dt>
                            <dd id="viewCountry" class="col-8">-</dd>
                            <dt class="col-4 text-muted">Postal Code</dt>
                            <dd id="viewPostalCode" class="col-8">-</dd>
                        </dl>
                    </div>
                    <div class="tab-pane fade" id="vcWork" role="tabpanel" aria-labelledby="vc-tab-work">
                        <dl class="row mb-0">
                            <dt class="col-4 text-muted">Job title</dt>
                            <dd id="viewJobTitle" class="col-8">-</dd>
                            <dt class="col-4 text-muted">Company</dt>
                            <dd id="viewCompany" class="col-8">-</dd>
                            <dt class="col-4 text-muted">Department</dt>
                            <dd id="viewDepartment" class="col-8">-</dd>
                            <dt class="col-4 text-muted">Work email</dt>
                            <dd id="viewWorkEmail" class="col-8">-</dd>
                            <dt class="col-4 text-muted">Work phone</dt>
                            <dd id="viewWorkPhone" class="col-8">-</dd>
                            <dt class="col-4 text-muted">Website</dt>
                            <dd id="viewWebsite" class="col-8">-</dd>
                        </dl>
                    </div>
                    <div class="tab-pane fade" id="vcAbout" role="tabpanel" aria-labelledby="vc-tab-about">
                        <dl class="row mb-0">
                            <dt class="col-4 text-muted">Birthday</dt>
                            <dd id="viewBirthday" class="col-8">-</dd>
                            <dt class="col-4 text-muted">Notes</dt>
                            <dd id="viewNotes" class="col-8">-</dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteContactModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center py-4">
                <div class="danger-icon mb-3">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                </div>
                <h5 class="mb-1">Delete contact?</h5>
                <p class="text-muted mb-0">This will permanently remove <strong id="deleteContactName">this
                        contact</strong>. This action cannot be undone.</p>
            </div>
            <div class="modal-footer border-0 justify-content-center pb-4 pt-2">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="confirmDeleteBtn" class="btn btn-danger">
                    <i class="bi bi-trash me-1"></i>
                    <span class="btn-text">Delete</span>
                </button>
            </div>
        </div>
    </div>
</div>
