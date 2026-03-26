<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Fisioterapi</title>
    <style>
        body { font-family: sans-serif; line-height: 1.6; color: #333; }
        .header { text-align: center; border-bottom: 2px solid #2563eb; padding-bottom: 10px; margin-bottom: 20px; }
        .patient-info { margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th { background-color: #eff6ff; color: #1e40af; text-align: left; padding: 10px; border: 1px solid #d1d5db; }
        td { padding: 10px; border: 1px solid #d1d5db; }
        .footer { margin-top: 30px; font-size: 10px; text-align: center; color: #666; }
    </style>
</head>
<body>
    <div class="header">
        <h1 style="margin:0; color: #1e40af;">PhysioWeb Report</h1>
        <p style="margin:0;">Laporan Rekapitulasi Sesi Rehabilitasi Mandiri</p>
    </div>

    <div class="patient-info">
        <p><strong>Nama Pasien:</strong> {{ $patient->user->name }}</p>
        <p><strong>Diagnosis:</strong> {{ $patient->medical_diagnosis }}</p>
        <p><strong>Tanggal Cetak:</strong> {{ $date }}</p>
    </div>

    <h3>Riwayat Sesi Latihan AI</h3>
    <table>
        <thead>
            <tr>
                <th>Tanggal Sesi</th>
                <th>Jenis Latihan</th>
                <th>Repetisi</th>
                <th>Skor Akurasi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($sessions as $session)
                <tr>
                    <td>{{ $session->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $session->assignment->exercise->name ?? 'Latihan Umum' }}</td>
                    <td>{{ $session->achieved_reps }} Reps</td>
                    <td>{{ $session->accuracy_score }}%</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center;">Belum ada data latihan yang tersimpan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Dokumen ini dihasilkan secara otomatis oleh Sistem AI PhysioWeb pada {{ date('Y-m-d H:i:s') }}</p>
    </div>
</body>
</html>