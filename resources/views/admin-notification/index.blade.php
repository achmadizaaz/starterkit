@extends('layouts.app')

@section('title','Notifikasi Admin')

@section('content')
    <div class="container-fluid">
        <div class="page-heading">
            <div>
                <span class="dashboard-kicker">Alerts</span>
                <h4 class="mb-1">Notifikasi Admin</h4>
                <p class="text-muted mb-0">Aktivitas penting yang perlu diperhatikan administrator.</p>
            </div>
            <form method="POST" action="{{ route('notifications.read-all') }}">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn btn-light-modern">
                    <i class="bi bi-check2-all"></i>
                    Tandai Semua Dibaca
                </button>
            </form>
        </div>

        <div class="card card-modern">
            <div class="card-body">
                <div class="notification-list">
                    @forelse($notifications as $notification)
                        <form method="POST" action="{{ route('notifications.read', $notification) }}" class="notification-item {{ $notification->read_at ? '' : 'unread' }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit">
                                <span class="notification-icon notification-{{ $notification->type }}"><i class="bi bi-bell"></i></span>
                                <span>
                                    <strong>{{ $notification->title }}</strong>
                                    <small>{{ $notification->message }}</small>
                                    <em>{{ optional($notification->created_at)->diffForHumans() }}</em>
                                </span>
                            </button>
                        </form>
                    @empty
                        <div class="empty-state py-5">
                            <i class="bi bi-bell"></i>
                            <p>Belum ada notifikasi.</p>
                        </div>
                    @endforelse
                </div>
                <div class="pagination-wrapper mt-4">
                    {{ $notifications->links('vendor.pagination.modern-bootstrap') }}
                </div>
            </div>
        </div>
    </div>
@endsection
