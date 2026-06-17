<form method="GET" action="{{ route('reports.users') }}" class="row g-3 align-items-end">
    <input type="hidden" name="format" value="html">
    <div class="col-lg-3 col-md-6">
        <label for="reportUserSearch" class="form-label">Cari User</label>
        <div class="input-group input-group-modern">
            <span class="input-group-text"><i class="bi bi-search"></i></span>
            <input type="text" name="search" id="reportUserSearch" class="form-control" value="{{ request('search') }}" placeholder="Nama, username, email">
        </div>
    </div>
    <div class="col-lg-2 col-md-6">
        <label for="reportUserStatus" class="form-label">Status</label>
        <select name="status" id="reportUserStatus" class="form-select">
            <option value="">Semua Status</option>
            <option value="active" @selected(request('status') === 'active')>Active</option>
            <option value="inactive" @selected(request('status') === 'inactive')>Inactive</option>
        </select>
    </div>
    <div class="col-lg-2 col-md-6">
        <label for="reportUserRole" class="form-label">Role</label>
        <select name="role" id="reportUserRole" class="form-select js-select2" data-placeholder="Semua Role">
            <option value="">Semua Role</option>
            @foreach($roles as $role)
                <option value="{{ $role->id }}" @selected(request('role') === $role->id)>{{ $role->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-lg-2 col-md-6">
        <label for="reportUserVerified" class="form-label">Email</label>
        <select name="email_verified" id="reportUserVerified" class="form-select">
            <option value="">Semua Email</option>
            <option value="verified" @selected(request('email_verified') === 'verified')>Terverifikasi</option>
            <option value="unverified" @selected(request('email_verified') === 'unverified')>Belum Verifikasi</option>
        </select>
    </div>
    <div class="col-lg-3 col-md-12">
        <label class="form-label">Tanggal Daftar</label>
        <div class="input-group input-group-modern">
            <input type="date" name="registered_from" class="form-control" value="{{ request('registered_from') }}">
            <span class="input-group-text px-2">s/d</span>
            <input type="date" name="registered_to" class="form-control" value="{{ request('registered_to') }}">
        </div>
    </div>
    <div class="col-12 d-flex justify-content-end gap-2">
        <a href="{{ route('reports.users') }}" class="btn btn-light-modern">
            <i class="bi bi-arrow-counterclockwise"></i>
            Reset
        </a>
        <button type="submit" class="btn btn-primary-modern">
            <i class="bi bi-funnel"></i>
            Terapkan Filter
        </button>
    </div>
</form>
