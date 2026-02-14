@extends('layouts.admin')

@section('content')
<div class="admin-registrations-page">
    <!-- Header -->
    <div class="page-header">
        <div>
            <a href="{{ route('admin.events.index') }}" class="back-link">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                Retour aux événements
            </a>
            <h1 class="page-title">Inscriptions</h1>
            <p class="page-subtitle">{{ $event->title }}</p>
        </div>

        <div class="header-actions">
            <a href="{{ route('events.show', $event->slug) }}" class="btn btn-secondary" target="_blank">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                    <polyline points="15 3 21 3 21 9"></polyline>
                    <line x1="10" y1="14" x2="21" y2="3"></line>
                </svg>
                Voir l'événement
            </a>
        </div>
    </div>

    <!-- Event Summary Card -->
    <div class="summary-card">
        <div class="summary-grid">
            <div class="summary-item">
                <div class="summary-icon summary-date">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                </div>
                <div>
                    <p class="summary-label">Date</p>
                    <h4 class="summary-value">{{ $event->event_date->translatedFormat('d F Y à H:i') }}</h4>
                </div>
            </div>

            <div class="summary-item">
                <div class="summary-icon summary-duration">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                </div>
                <div>
                    <p class="summary-label">Durée</p>
                    <h4 class="summary-value">{{ $event->duration }}</h4>
                </div>
            </div>

            <div class="summary-item">
                <div class="summary-icon summary-location">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                        <circle cx="12" cy="10" r="3"></circle>
                    </svg>
                </div>
                <div>
                    <p class="summary-label">Lieu</p>
                    <h4 class="summary-value">{{ $event->location }}</h4>
                </div>
            </div>

            <div class="summary-item">
                <div class="summary-icon summary-participants">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                </div>
                <div>
                    <p class="summary-label">Inscriptions</p>
                    <h4 class="summary-value">
                        {{ $event->registered_count }}
                        @if($event->max_participants)
                            <span class="max">/ {{ $event->max_participants }}</span>
                        @endif
                    </h4>
                </div>
            </div>
        </div>

        @if($event->max_participants)
            <div class="capacity-bar">
                <div class="capacity-fill" style="width: {{ ($event->registered_count / $event->max_participants) * 100 }}%"></div>
            </div>
        @endif
    </div>

    <!-- Registrations Table -->
    <div class="table-container">
        <div class="table-header">
            <div>
                <h2 class="table-title">Liste des participants</h2>
                <p class="table-subtitle">{{ $registrations->count() }} inscription(s)</p>
            </div>
            <div class="header-actions">
                <button class="btn btn-primary" onclick="exportToCSV()">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                        <polyline points="7 10 12 15 17 10"></polyline>
                        <line x1="12" y1="15" x2="12" y2="3"></line>
                    </svg>
                    Exporter CSV
                </button>
            </div>
        </div>

        @if($registrations->isEmpty())
            <div class="empty-state">
                <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
                <h3>Aucune inscription</h3>
                <p>Personne ne s'est encore inscrit à cet événement</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="data-table" id="registrationsTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Participant</th>
                            <th>Email</th>
                            <th>Date d'inscription</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($registrations as $index => $registration)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <div class="user-info">
                                        <div class="user-avatar">
                                            {{ strtoupper(substr($registration->user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <h4 class="user-name">{{ $registration->user->name }}</h4>
                                            <span class="user-id">ID: {{ $registration->user->id }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <a href="mailto:{{ $registration->user->email }}" class="email-link">
                                        {{ $registration->user->email }}
                                    </a>
                                </td>
                                <td>
                                    <div class="date-info">
                                        <span class="date">{{ $registration->created_at->format('d/m/Y') }}</span>
                                        <span class="time">{{ $registration->created_at->format('H:i') }}</span>
                                    </div>
                                </td>
                                <td>
                                    @if($registration->status === 'confirmed')
                                        <span class="status status-confirmed">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                <polyline points="20 6 9 17 4 12"></polyline>
                                            </svg>
                                            Confirmé
                                        </span>
                                    @elseif($registration->status === 'pending')
                                        <span class="status status-pending">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                <circle cx="12" cy="12" r="10"></circle>
                                                <polyline points="12 6 12 12 16 14"></polyline>
                                            </svg>
                                            En attente
                                        </span>
                                    @else
                                        <span class="status status-cancelled">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                <circle cx="12" cy="12" r="10"></circle>
                                                <line x1="15" y1="9" x2="9" y2="15"></line>
                                                <line x1="9" y1="9" x2="15" y2="15"></line>
                                            </svg>
                                            Annulé
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

<style>
:root {
    --primary: #6366f1;
    --secondary: #8b5cf6;
    --success: #10b981;
    --warning: #f59e0b;
    --danger: #ef4444;
    --dark-bg: #0f172a;
    --card-bg: #1e293b;
    --text-primary: #f1f5f9;
    --text-secondary: #94a3b8;
    --border: #334155;
}

.admin-registrations-page {
    padding: 32px;
    background: var(--dark-bg);
    min-height: 100vh;
}

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 32px;
}

.back-link {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    color: var(--text-secondary);
    font-size: 14px;
    font-weight: 500;
    text-decoration: none;
    margin-bottom: 12px;
    transition: all 0.2s ease;
}

.back-link:hover {
    color: var(--primary);
    transform: translateX(-4px);
}

.page-title {
    font-size: 32px;
    font-weight: 800;
    color: var(--text-primary);
    margin-bottom: 8px;
}

.page-subtitle {
    font-size: 16px;
    color: var(--text-secondary);
}

/* Summary Card */
.summary-card {
    background: var(--card-bg);
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 32px;
    margin-bottom: 32px;
}

.summary-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 24px;
    margin-bottom: 24px;
}

.summary-item {
    display: flex;
    align-items: center;
    gap: 16px;
}

.summary-icon {
    width: 56px;
    height: 56px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
}

.summary-icon svg {
    stroke-width: 2;
}

.summary-date {
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    color: white;
}

.summary-duration {
    background: linear-gradient(135deg, #3b82f6, #06b6d4);
    color: white;
}

.summary-location {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
}

.summary-participants {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: white;
}

.summary-label {
    font-size: 13px;
    color: var(--text-secondary);
    margin-bottom: 4px;
}

.summary-value {
    font-size: 20px;
    font-weight: 700;
    color: var(--text-primary);
}

.summary-value .max {
    font-size: 14px;
    color: var(--text-secondary);
}

.capacity-bar {
    height: 8px;
    background: var(--border);
    border-radius: 4px;
    overflow: hidden;
}

.capacity-fill {
    height: 100%;
    background: linear-gradient(90deg, var(--success), var(--primary));
    transition: width 0.3s ease;
}

/* Table */
.table-container {
    background: var(--card-bg);
    border: 1px solid var(--border);
    border-radius: 16px;
    overflow: hidden;
}

.table-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 24px;
    border-bottom: 1px solid var(--border);
}

.table-title {
    font-size: 20px;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 4px;
}

.table-subtitle {
    font-size: 14px;
    color: var(--text-secondary);
}

.header-actions {
    display: flex;
    gap: 12px;
}

.btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    border-radius: 10px;
    font-weight: 600;
    font-size: 14px;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
}

.btn svg {
    stroke-width: 2;
}

.btn-primary {
    background: var(--primary);
    color: white;
}

.btn-primary:hover {
    background: var(--secondary);
    transform: translateY(-2px);
    box-shadow: 0 8px 16px rgba(99, 102, 241, 0.3);
}

.btn-secondary {
    background: transparent;
    color: var(--text-secondary);
    border: 2px solid var(--border);
}

.btn-secondary:hover {
    border-color: var(--primary);
    color: var(--primary);
}

.table-responsive {
    overflow-x: auto;
}

.data-table {
    width: 100%;
    border-collapse: collapse;
}

.data-table thead th {
    padding: 16px 20px;
    text-align: left;
    font-size: 13px;
    font-weight: 600;
    color: var(--text-secondary);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 1px solid var(--border);
}

.data-table tbody tr {
    border-bottom: 1px solid var(--border);
    transition: all 0.2s ease;
}

.data-table tbody tr:hover {
    background: rgba(99, 102, 241, 0.05);
}

.data-table tbody td {
    padding: 16px 20px;
    font-size: 14px;
}

.user-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.user-avatar {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    border-radius: 10px;
    color: white;
    font-weight: 700;
    font-size: 16px;
}

.user-name {
    font-size: 15px;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 2px;
}

.user-id {
    font-size: 12px;
    color: var(--text-secondary);
}

.email-link {
    color: var(--primary);
    text-decoration: none;
    transition: all 0.2s ease;
}

.email-link:hover {
    text-decoration: underline;
}

.date-info {
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.date {
    font-weight: 600;
    color: var(--text-primary);
}

.time {
    font-size: 12px;
    color: var(--text-secondary);
}

.status {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 600;
}

.status svg {
    stroke-width: 2.5;
}

.status-confirmed {
    background: rgba(16, 185, 129, 0.1);
    color: var(--success);
}

.status-pending {
    background: rgba(245, 158, 11, 0.1);
    color: var(--warning);
}

.status-cancelled {
    background: rgba(239, 68, 68, 0.1);
    color: var(--danger);
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 80px 20px;
}

.empty-state svg {
    stroke-width: 1.5;
    color: var(--text-secondary);
    margin-bottom: 20px;
}

.empty-state h3 {
    font-size: 20px;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 8px;
}

.empty-state p {
    font-size: 14px;
    color: var(--text-secondary);
}

/* Responsive */
@media (max-width: 768px) {
    .admin-registrations-page {
        padding: 16px;
    }

    .page-header {
        flex-direction: column;
        gap: 16px;
    }

    .summary-grid {
        grid-template-columns: 1fr;
    }

    .table-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 16px;
    }
}
</style>

<script>
function exportToCSV() {
    const table = document.getElementById('registrationsTable');
    const rows = table.querySelectorAll('tr');
    let csv = [];

    for (let i = 0; i < rows.length; i++) {
        const row = [];
        const cols = rows[i].querySelectorAll('td, th');

        for (let j = 0; j < cols.length; j++) {
            let data = cols[j].innerText.replace(/(\r\n|\n|\r)/gm, '').replace(/\s+/g, ' ').trim();
            data = data.replace(/"/g, '""');
            row.push('"' + data + '"');
        }

        csv.push(row.join(','));
    }

    const csvFile = new Blob([csv.join('\n')], { type: 'text/csv' });
    const downloadLink = document.createElement('a');
    downloadLink.download = 'inscriptions_{{ $event->slug }}_{{ date("Y-m-d") }}.csv';
    downloadLink.href = window.URL.createObjectURL(csvFile);
    downloadLink.style.display = 'none';
    document.body.appendChild(downloadLink);
    downloadLink.click();
    document.body.removeChild(downloadLink);
}
</script>
@endsection
