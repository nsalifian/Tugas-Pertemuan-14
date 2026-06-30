<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Buku') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>
        <i class="bi bi-book"></i>
        Daftar Buku
    </h1>
        <div class="d-flex gap-2">
        <button type="submit" form="bulk-delete-form" class="btn btn-danger" id="btn-bulk-delete" style="display: none;">
            <i class="bi bi-trash"></i> Hapus Terpilih (<span id="selected-count">0</span>)
        </button>
        {{-- Tombol Export CSV --}}
        <a href="{{ route('buku.export') }}" class="btn btn-success">
            <i class="bi bi-download"></i> Export CSV
        </a>
        <a href="{{ route('buku.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Buku
        </a>
    </div>
</div>

 
{{-- Statistik Cards --}}
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card border-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Total Buku</h6>
                        <h2 class="mb-0">{{ $totalBuku }}</h2>
                    </div>
                    <div class="text-primary">
                        <i class="bi bi-book-fill" style="font-size: 3rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card border-success">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Buku Tersedia</h6>
                        <h2 class="mb-0">{{ $bukuTersedia }}</h2>
                    </div>
                    <div class="text-success">
                        <i class="bi bi-check-circle-fill" style="font-size: 3rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card border-danger">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Buku Habis</h6>
                        <h2 class="mb-0">{{ $bukuHabis }}</h2>
                    </div>
                    <div class="text-danger">
                        <i class="bi bi-x-circle-fill" style="font-size: 3rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
 
<!-- Form Search & Filter Advanced -->
<div class="card mb-4 border-0 shadow-sm">
    <div class="card-body">
        <h6 class="card-title fw-bold mb-3">
            <i class="bi bi-search"></i> Pencarian & Filter Advanced
        </h6>
        <form action="{{ route('buku.search') }}" method="GET">
            <div class="row g-3">
                <div class="col-md-3">
                    <label for="keyword" class="form-label small text-muted">Cari Keyword</label>
                    <input type="text" name="keyword" id="keyword" class="form-control" 
                           placeholder="Judul, pengarang, penerbit..." 
                           value="{{ request('keyword') }}">
                </div>

                <!-- Dropdown Kategori -->
                <div class="col-md-3">
                    <label for="kategori" class="form-label small text-muted">Kategori</label>
                    <select name="kategori" id="kategori" class="form-select">
                        <option value="">-- Semua Kategori --</option>
                        <option value="Programming" {{ request('kategori') == 'Programming' ? 'selected' : '' }}>Programming</option>
                        <option value="Database" {{ request('kategori') == 'Database' ? 'selected' : '' }}>Database</option>
                        <option value="Web Design" {{ request('kategori') == 'Web Design' ? 'selected' : '' }}>Web Design</option>
                        <option value="Networking" {{ request('kategori') == 'Networking' ? 'selected' : '' }}>Networking</option>
                        <option value="Data Science" {{ request('kategori') == 'Data Science' ? 'selected' : '' }}>Data Science</option>
                    </select>
                </div>

                <!-- Dropdown Tahun -->
                <div class="col-md-2">
                    <label for="tahun" class="form-label small text-muted">Tahun Terbit</label>
                    <select name="tahun" id="tahun" class="form-select">
                        <option value="">-- Semua Tahun --</option>
                        @for($t = date('Y'); $t >= 2015; $t--)
                            <option value="{{ $t }}" {{ request('tahun') == $t ? 'selected' : '' }}>{{ $t }}</option>
                        @endfor
                    </select>
                </div>

                <!-- Dropdown Ketersediaan -->
                <div class="col-md-2">
                    <label for="ketersediaan" class="form-label small text-muted">Ketersediaan</label>
                    <select name="ketersediaan" id="ketersediaan" class="form-select">
                        <option value="">Semua</option>
                        <option value="tersedia" {{ request('ketersediaan') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                        <option value="habis" {{ request('ketersediaan') == 'habis' ? 'selected' : '' }}>Habis</option>
                    </select>
                </div>

                <!-- Tombol Aksi -->
                <div class="col-md-2 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary flex-fill">
                        <i class="bi bi-search"></i> Cari
                    </button>
                    <a href="{{ route('buku.index') }}" class="btn btn-outline-secondary flex-fill">
                        <i class="bi bi-arrow-counterclockwise"></i> Reset
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>


{{-- Filter Kategori --}}
<div class="card mb-4">
    <div class="card-body">
        <h6 class="card-title">
            <i class="bi bi-funnel"></i> Filter Kategori:
        </h6>
        <div class="btn-group" role="group">
            <a href="{{ route('buku.index') }}" class="btn btn-sm {{ !isset($kategori) ? 'btn-primary' : 'btn-outline-primary' }}">
                Semua
            </a>
            <a href="{{ route('buku.kategori', 'Programming') }}" class="btn btn-sm {{ isset($kategori) && $kategori == 'Programming' ? 'btn-primary' : 'btn-outline-primary' }}">
                Programming
            </a>
            <a href="{{ route('buku.kategori', 'Database') }}" class="btn btn-sm {{ isset($kategori) && $kategori == 'Database' ? 'btn-primary' : 'btn-outline-primary' }}">
                Database
            </a>
            <a href="{{ route('buku.kategori', 'Web Design') }}" class="btn btn-sm {{ isset($kategori) && $kategori == 'Web Design' ? 'btn-primary' : 'btn-outline-primary' }}">
                Web Design
            </a>
            <a href="{{ route('buku.kategori', 'Networking') }}" class="btn btn-sm {{ isset($kategori) && $kategori == 'Networking' ? 'btn-primary' : 'btn-outline-primary' }}">
                Networking
            </a>
            <a href="{{ route('buku.kategori', 'Data Science') }}" class="btn btn-sm {{ isset($kategori) && $kategori == 'Data Science' ? 'btn-primary' : 'btn-outline-primary' }}">
                Data Science
            </a>
        </div>
    </div>
</div>
 
{{-- Form Bulk Delete (terpisah agar tidak nested dengan form delete individual) --}}
<form id="bulk-delete-form" action="{{ route('buku.bulk-delete') }}" method="POST" style="display: none;">
    @csrf
</form>

{{-- Checkbox Select All --}}
@if($bukus->count() > 0)
<div class="mb-3">
    <div class="form-check">
        <input type="checkbox" class="form-check-input" id="select-all">
        <label class="form-check-label fw-bold" for="select-all">Pilih Semua</label>
    </div>
</div>
@endif

{{-- Daftar Buku --}}
@forelse ($bukus as $buku)
    <div class="card mb-3">
        <div class="card-body">
            <div class="row">
                <div class="col-md-2 text-center">
                    {{-- Checkbox untuk bulk delete --}}
                    <div class="form-check d-flex justify-content-center mb-2">
                        <input type="checkbox" name="buku_ids[]" value="{{ $buku->id }}" class="form-check-input buku-checkbox">
                    </div>
                    <i class="bi bi-book text-primary" style="font-size: 4rem;"></i>
                    <div class="mt-2">
                        <span class="badge bg-{{ $buku->kategori == 'Programming' ? 'primary' : ($buku->kategori == 'Database' ? 'success' : ($buku->kategori == 'Web Design' ? 'info' : ($buku->kategori == 'Networking' ? 'warning' : 'danger'))) }}">
                            {{ $buku->kategori }}
                        </span>
                    </div>
                </div>
                
                <div class="col-md-7">
                    <h5 class="card-title">
                        <a href="{{ route('buku.show', $buku->id) }}" class="text-decoration-none">
                            {{ $buku->judul }}
                        </a>
                    </h5>
                    
                    <p class="card-text text-muted mb-2">
                        <i class="bi bi-person"></i> {{ $buku->pengarang }} | 
                        <i class="bi bi-building"></i> {{ $buku->penerbit }} | 
                        <i class="bi bi-calendar"></i> {{ $buku->tahun_terbit }}
                    </p>
                    
                    @if ($buku->isbn)
                        <p class="card-text small text-muted mb-1">
                            <i class="bi bi-upc"></i> ISBN: {{ $buku->isbn }}
                        </p>
                    @endif
                    
                    @if ($buku->deskripsi)
                        <p class="card-text">
                            {{ Str::limit($buku->deskripsi, 150) }}
                        </p>
                    @endif
                </div>
                
                <div class="col-md-3 text-end">
                    <h4 class="text-primary mb-2">
                        {{ $buku->harga_format }}
                    </h4>
                    
                    <div class="mb-3">
                        @if ($buku->stok > 0)
                            <span class="badge bg-success">
                                <i class="bi bi-check-circle"></i> Tersedia
                            </span>
                            <div class="text-muted small mt-1">
                                Stok: {{ $buku->stok }} buku
                            </div>
                        @else
                            <span class="badge bg-danger">
                                <i class="bi bi-x-circle"></i> Habis
                            </span>
                        @endif
                    </div>
                    
                    <div class="btn-group-vertical d-grid gap-2">
                        <a href="{{ route('buku.show', $buku->id) }}" class="btn btn-sm btn-info text-white">
                            <i class="bi bi-eye"></i> Detail
                        </a>
                        <a href="{{ route('buku.edit', $buku->id) }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i> Edit
                        </a>

                        {{-- Delete Button dengan SweetAlert --}}
                        <form action="{{ route('buku.destroy', $buku->id) }}" 
                            method="POST" 
                            class="d-inline delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-sm btn-danger w-100 btn-delete" 
                                    data-judul="{{ $buku->judul }}">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@empty
    <div class="alert alert-info">
        <i class="bi bi-info-circle"></i>
        Tidak ada data buku
        @isset($kategori)
            dengan kategori <strong>{{ $kategori }}</strong>
        @endisset
    </div>
@endforelse

 
@if ($bukus->count() > 0)
    <div class="text-center mt-4">
        <p class="text-muted">
            Menampilkan {{ $bukus->count() }} buku
            @isset($kategori)
                dari kategori <strong>{{ $kategori }}</strong>
            @endisset
        </p>
    </div>
@endif

@push('scripts')
<script>
    // SweetAlert confirmation untuk delete
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('form');
            const judul = this.getAttribute('data-judul');
            
            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: `Apakah Anda yakin ingin menghapus buku "${judul}"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    // Loading state saat submit form (kecuali delete-form)
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function() {
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn && !this.classList.contains('delete-form')) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...';
            }
        });
    });

        // Fungsi Select All checkbox
    document.getElementById('select-all')?.addEventListener('change', function() {
        // Centang/uncentang semua checkbox buku
        document.querySelectorAll('input[name="buku_ids[]"]').forEach(cb => {
            cb.checked = this.checked;
        });
        updateSelectedCount();
    });

    document.querySelectorAll('input[name="buku_ids[]"]').forEach(cb => {
        cb.addEventListener('change', function() {
            updateSelectedCount();

            const allCheckboxes = document.querySelectorAll('input[name="buku_ids[]"]');
            const checkedCheckboxes = document.querySelectorAll('input[name="buku_ids[]"]:checked');
            const selectAll = document.getElementById('select-all');
            if (selectAll) {
                selectAll.checked = allCheckboxes.length === checkedCheckboxes.length;
            }
        });
    });

    function updateSelectedCount() {
        const checkedCount = document.querySelectorAll('input[name="buku_ids[]"]:checked').length;
        const btnBulkDelete = document.getElementById('btn-bulk-delete');
        const selectedCount = document.getElementById('selected-count');

        if (btnBulkDelete) {
            btnBulkDelete.style.display = checkedCount > 0 ? 'inline-block' : 'none';
        }
        if (selectedCount) {
            selectedCount.textContent = checkedCount;
        }
    }

    // SweetAlert konfirmasi untuk bulk delete
    document.getElementById('bulk-delete-form')?.addEventListener('submit', function(e) {
        e.preventDefault();
        const form = this;
        const checked = document.querySelectorAll('input[name="buku_ids[]"]:checked');

        if (checked.length === 0) {
            Swal.fire('Peringatan', 'Pilih minimal satu buku untuk dihapus.', 'warning');
            return;
        }

        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: `Apakah Anda yakin ingin menghapus ${checked.length} buku yang dipilih?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Hapus hidden input lama jika ada
                form.querySelectorAll('input[name="buku_ids[]"]').forEach(el => el.remove());

                // Tambahkan hidden input dari checkbox yang tercentang
                checked.forEach(cb => {
                    const hidden = document.createElement('input');
                    hidden.type = 'hidden';
                    hidden.name = 'buku_ids[]';
                    hidden.value = cb.value;
                    form.appendChild(hidden);
                });

                form.submit();
            }
        });
    });

</script>
@endpush
        </div>
    </div>
</x-app-layout>