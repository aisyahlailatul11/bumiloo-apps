@extends('layouts.masterBumil')

@section('title', 'Reminder')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css" rel="stylesheet">

<style>
.text-pink {
    color: #f062a6;
}

.reminder-card {
    border-radius: 22px;
    border: none;
    box-shadow: 0 6px 20px rgba(233, 30, 140, 0.10);
}

.jadwal-item {
    border-left: 5px solid #f062a6;
    border-radius: 16px;
}

#calendar {
    background: #fff;
    border-radius: 18px;
    padding: 12px;
}

.fc .fc-toolbar {
    margin-bottom: 14px;
}

.fc .fc-toolbar-title {
    font-size: 18px;
    font-weight: 700;
    color: #e91e8c;
}

.fc .fc-button {
    border-radius: 20px !important;
    padding: 5px 10px !important;
    font-size: 12px !important;
    font-weight: 600 !important;
}

.fc .fc-button-primary {
    background-color: #f062a6 !important;
    border-color: #f062a6 !important;
}

.fc .fc-button-primary:hover {
    background-color: #e91e8c !important;
    border-color: #e91e8c !important;
}

.fc .fc-col-header-cell {
    background: #fff0f7;
    padding: 8px 0;
}

.fc .fc-col-header-cell-cushion {
    color: #e91e8c;
    font-size: 12px;
    font-weight: 700;
    text-decoration: none;
}

.fc .fc-daygrid-day {
    background: #fff;
}

.fc .fc-daygrid-day-number {
    color: #444;
    font-size: 13px;
    text-decoration: none;
    padding: 8px;
}

.fc .fc-day-today {
    background: #fff0f7 !important;
}

.fc .fc-daygrid-event {
    background: #f062a6 !important;
    border: none !important;
    border-radius: 12px;
    padding: 3px 6px;
    font-size: 11px;
    font-weight: 600;
}

.fc-theme-standard td,
.fc-theme-standard th {
    border-color: #f8d7e8;
}

.fc .fc-scrollgrid {
    border-radius: 16px;
    overflow: hidden;
    border-color: #f8d7e8;
}

.tips-box {
    background: #fff0f7;
    border-radius: 22px;
    box-shadow: 0 6px 20px rgba(233, 30, 140, 0.08);
}
</style>
@endsection

@section('content')

<div class="container-fluid">

    <div class="mb-4">
        <h2 class="fw-bold">Reminder</h2>
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

                        <span class="badge bg-danger rounded-pill px-3 py-2">
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

                                <span class="badge bg-danger rounded-pill px-3 py-2">
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
        <h6 class="fw-bold text-danger mb-2">
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