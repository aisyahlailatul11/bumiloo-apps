@extends('layouts.masterBumil')

@section('title', 'Reminder')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css" rel="stylesheet">

<style>
.text-pink {
    color: #f062a6;
}

.reminder-card {
    border-radius: 24px;
    border: none;
    box-shadow: 0 8px 24px rgba(233, 30, 140, 0.12);
}

.jadwal-item {
    background: #fae5f1;
    border-left: 6px solid #28a745;
    border-radius: 20px;
    border: 1px solid #e9ecef;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
}

.jadwal-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 28px rgba(0, 0, 0, 0.12);
}

#calendar {
    background: #fff;
    border-radius: 20px;
    padding: 14px;
}

.fc .fc-toolbar {
    margin-bottom: 16px;
}

.fc .fc-toolbar-title {
    font-size: 20px;
    font-weight: 800;
    color: #e91e8c;
}

.fc .fc-button {
    border-radius: 22px !important;
    padding: 6px 14px !important;
    font-size: 13px !important;
    font-weight: 700 !important;
}

.fc .fc-button-primary {
    background-color: #f062a6 !important;
    border-color: #f062a6 !important;
}

.fc .fc-button-primary:hover {
    background-color: #e91e8c !important;
    border-color: #e91e8c !important;
}

.fc-scroller {
    overflow-y: auto !important;
    overflow-x: hidden !important;
}

.fc-scroller::-webkit-scrollbar {
    width: 8px;
}

.fc-scroller::-webkit-scrollbar-track {
    background: #ffeaf4;
    border-radius: 10px;
}

.fc-scroller::-webkit-scrollbar-thumb {
    background: #f062a6;
    border-radius: 10px;
}

.fc-scroller::-webkit-scrollbar-thumb:hover {
    background: #e91e8c;
}

.fc .fc-col-header-cell {
    background: #fff0f7;
    padding: 10px 0;
}

.fc .fc-col-header-cell-cushion {
    color: #e91e8c;
    font-size: 13px;
    font-weight: 800;
    text-decoration: none;
}

.fc .fc-daygrid-day-number {
    color: #444;
    font-size: 14px;
    text-decoration: none;
    padding: 8px;
}

.fc .fc-day-today {
    background: #fff5fa !important;
}

.fc .fc-daygrid-event {
    background: #f062a6 !important;
    border: none !important;
    border-radius: 14px;
    padding: 4px 7px;
    font-size: 11px;
    font-weight: 700;
}

.fc-theme-standard td,
.fc-theme-standard th {
    border-color: #f8d7e8;
}

.fc .fc-scrollgrid {
    border-radius: 18px;
    overflow: hidden;
    border-color: #f8d7e8;
}

.tips-box {
    background: #ffffff;
    border-left: 6px solid #f062a6;
    border-radius: 22px;
    box-shadow: 0 8px 24px rgba(233, 30, 140, 0.14);
}

.badge-green {
    background-color: #28a745;
    color: #fff;
}
</style>
@endsection

@section('content')

<div class="container-fluid py-3">

    <div class="mb-4">
        <h4 class="fw-bold mb-1">Reminder</h4>
        <p class="text-muted mb-0">
            Pengingat jadwal penting kehamilan Bunda
        </p>
    </div>

    <div class="row g-4">

        <div class="col-lg-5">
            <div class="card reminder-card">
                <div class="card-body">
                    <h5 class="fw-bold text-pink mb-3">
                        Kalender Jadwal
                    </h5>

                    <div id="calendar"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card reminder-card h-100">
                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold text-pink mb-0">
                            Daftar Pengingat
                        </h5>

                        <span class="badge badge-green rounded-pill px-3 py-2">
                            {{ count($jadwals) }} Jadwal
                        </span>
                    </div>

                    @forelse($jadwals as $jadwal)
                    <div class="card border-0 shadow-sm mb-3 jadwal-item">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center gap-3">

                                <div>
                                    <h6 class="fw-bold mb-1">
                                        {{ $jadwal->keterangan ?? 'Jadwal Konsultasi' }}
                                    </h6>

                                    <p class="text-muted mb-1">
                                        Konsultasi dengan Bidan
                                    </p>

                                    <small>
                                        <i class="bi bi-calendar-event"></i>
                                        {{ \Carbon\Carbon::parse($jadwal->tgl_pemeriksaan)->format('d M Y') }}

                                        &nbsp; | &nbsp;

                                        <i class="bi bi-clock"></i>
                                        {{ \Carbon\Carbon::parse($jadwal->jam)->format('H:i') }} WIB
                                    </small>
                                </div>

                                <span class="badge badge-green rounded-pill px-3 py-2">
                                    Janji Temu
                                </span>

                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="alert alert-warning rounded-4">
                        <i class="bi bi-exclamation-triangle"></i>
                        Belum ada jadwal konsultasi.
                    </div>
                    @endforelse

                </div>
            </div>
        </div>

    </div>

    <div class="tips-box mt-4 p-4">
        <h6 class="fw-bold text-pink mb-2">
            Tips Kehamilan
        </h6>

        <p class="mb-0">
            Rutin mengikuti jadwal kontrol dan mengonsumsi vitamin sesuai anjuran bidan dapat membantu menjaga kesehatan
            ibu dan janin selama masa kehamilan.
        </p>
    </div>

</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let calendarEl = document.getElementById('calendar');

    let calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'id',
        height: 430,

        headerToolbar: {
            left: 'prev,next',
            center: 'title',
            right: 'today'
        },

        buttonText: {
            today: 'Hari Ini'
        },

        events: @json($events ?? []),

        eventClick: function(info) {
            Swal.fire({
                title: info.event.title,
                html: `
                    <b>Tanggal:</b> ${info.event.start.toLocaleDateString('id-ID')}<br>
                    <b>Jam:</b> ${info.event.extendedProps.jam ?? '-'} WIB<br>
                    <b>Keterangan:</b> ${info.event.extendedProps.keterangan ?? '-'}
                `,
                icon: 'info',
                confirmButtonColor: '#f062a6'
            });
        }
    });

    calendar.render();
});
</script>
@endsection