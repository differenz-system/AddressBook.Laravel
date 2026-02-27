@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3 fade-in-up">
        <h4 class="mb-0"><i class="bi bi-star-fill text-warning me-2"></i>Favorites</h4>
        <a href="{{ route('contacts.index') }}" class="btn btn-outline-secondary"><i class="bi bi-person-lines-fill me-1"></i>
            All Contacts</a>
    </div>

    <div class="card shadow-sm border-0 fade-in-up">
        <div class="card-body">
            <div class="row g-3" id="favoritesGrid">
                <!-- Filled by JS -->
            </div>
        </div>
    </div>
@endsection

@include('contacts.modals')

@push('scripts')
    <script>
        window.STORAGE_BASE = window.STORAGE_BASE || `{{ asset('storage') }}`;
        $(function() {
            $.get(`{{ route('favorites.datatable') }}`).done(function(res) {
                const list = res.data || [];
                if (!list.length) {
                    $('#favoritesGrid').html(
                        `<div class=\"text-center text-muted py-5\">No favorites yet. Go to Contacts and star a few!</div>`
                    );
                    return;
                }
                const cards = list.map(c => favCardTpl(c)).join('');
                $('#favoritesGrid').html(cards);
            });
        });

        function initials(first, last) {
            return (String(first || '').charAt(0) + String(last || '').charAt(0)).toUpperCase() || 'A';
        }

        function favCardTpl(c) {
            return `
    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
      <div class="card h-100 border-0 shadow-sm fav-card" data-id="${c.id}" style="cursor:pointer;">
        <div class="card-body d-flex flex-column align-items-center text-center p-4">
          <div class="contact-avatar mb-2" style="width:56px;height:56px;">${c.photo_path ? `<img src="${window.STORAGE_BASE}/${c.photo_path}" alt="">` : initials(c.first_name, c.last_name)}</div>
          <div class="fw-semibold">${c.first_name || ''} ${c.last_name || ''}</div>
          <div class="text-muted small">${c.email || ''}</div>
          ${c.city ? `<div class=\"badge-soft mt-2\">${c.city}</div>` : ''}
          <div class="mt-3 d-flex gap-2">
            <a href="mailto:${c.email || ''}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-envelope"></i></a>
            ${c.phone ? `<a href=\"tel:${c.phone}\" class=\"btn btn-sm btn-outline-secondary\"><i class=\"bi bi-telephone\"></i></a>`: ''}
          </div>
        </div>
      </div>
    </div>`;
        }

        function fillAndShowViewModal(c) {
            const val = (v) => (v && String(v).trim().length ? v : '-');
            const init = (f, l) => ((String(f || '').charAt(0) + String(l || '').charAt(0)) || 'A').toUpperCase();
            // Header
            if (c.photo_path) {
                $('#viewAvatar').html(`<img src="${window.STORAGE_BASE}/${c.photo_path}" alt="">`);
            } else {
                $('#viewAvatar').text(init(c.first_name, c.last_name));
            }
            $('#viewFullName').text(val(`${c.first_name||''} ${c.last_name||''}`.trim()));
            $('#viewEmail').text(val(c.email));
            // Toggle remove-photo action visibility
            $('#removePhotoBtn').toggleClass('d-none', !c.photo_path).data('id', c.id);
            // Contact
            $('#viewPhone').text(val(c.phone));
            $('#viewAddress').text(val(c.address));
            $('#viewCity').text(val(c.city));
            $('#viewState').text(val(c.state));
            $('#viewCountry').text(val(c.country));
            $('#viewPostalCode').text(val(c.postal_code));
            // Work
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
            // About
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

            // Reuse instance and ensure backdrops are cleaned
            const el = document.getElementById('viewContactModal');
            // Remove any stray backdrops before showing (in case of previous leak)
            document.querySelectorAll('.modal-backdrop').forEach(n => n.parentNode && n.parentNode.removeChild(n));
            const modal = bootstrap.Modal.getOrCreateInstance(el);
            el.addEventListener('hidden.bs.modal', function onHidden() {
                document.querySelectorAll('.modal-backdrop').forEach(n => n.parentNode && n.parentNode.removeChild(n));
                document.body.classList.remove('modal-open');
            }, {
                once: true
            });
            modal.show();
        }

        // open modal from card or button
        $(document).on('click', '.fav-card, .fav-view', function(e) {
            e.preventDefault();
            const id = $(this).data('id');
            if (!id) return;
            $.get(`{{ url('/contacts') }}/${id}`).done(function(res) {
                fillAndShowViewModal(res.data || {});
            });
        });

        // remove photo from View modal
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
                    bootstrap.Modal.getOrCreateInstance(document.getElementById('viewContactModal')).hide();
                    // refresh favorites grid
                    $.get(`{{ route('favorites.datatable') }}`).done(function(res) {
                        const list = res.data || [];
                        const cards = list.map(c => favCardTpl(c)).join('');
                        $('#favoritesGrid').html(cards);
                    });
                });
        });
    </script>
@endpush
