<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk Parkir</title>
    <style>
        body { font-family: monospace; width: 280px; margin: 0 auto; padding: 16px; font-size: 13px; }
        h2 { text-align: center; margin: 0 0 4px; font-size: 16px; }
        .center { text-align: center; }
        hr { border: none; border-top: 1px dashed #000; margin: 8px 0; }
        table { width: 100%; }
        td { padding: 2px 0; }
        .right { text-align: right; }
        .total { font-weight: bold; font-size: 14px; }

            .struk-wrap { position: relative; }
            .struk-content { position: relative; z-index: 1; }
            .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 300px;
            opacity: 0.50;
            z-index: 10;
            pointer-events: none;
}
        

        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <!-- Logo atas -->
    <img src="{{ asset('image/kabasa.png') }}" alt="Parkir Kabasa"
         style="display: block; margin: 0 auto -50px; width: 160px; height: auto;">

    <div class="struk-wrap">
        <!-- Watermark di belakang -->
        <img src="{{ asset('image/parkir.png') }}" class="watermark" alt="">
        

        <div class="struk-content">
            <p class="center">Pagelaran Malang</p>
            <p class="center">Tlp. 0812-3456-7890</p>
            <hr>
            <table>
                <tr><td>No. Booking</td><td class="right">#{{ $booking->id }}</td></tr>
                <tr><td>Plat Kendaraan</td><td class="right">{{ $booking->plat_kendaraan }}</td></tr>
                @if($booking->nama_kendaraan)
                <tr><td>Nama Kendaraan</td><td class="right">{{ $booking->nama_kendaraan }}</td></tr>
                @endif
                @if($booking->slot)
                <tr><td>Slot</td><td class="right">{{ $booking->slot->kode_slot }}</td></tr>
                @endif
                <tr><td>Jam Masuk</td><td class="right">{{ optional($booking->waktu_masuk)->format('d/m/Y H:i') ?? '-' }}</td></tr>
                <tr><td>Jam Keluar</td><td class="right">{{ optional($booking->waktu_keluar)->format('d/m/Y H:i') ?? '-' }}</td></tr>
                <tr><td>Status</td><td class="right">{{ ucfirst($booking->status) }}</td></tr>
            </table>
            <hr>
            <table>
                <tr><td>Metode Bayar</td><td class="right">{{ $booking->payment->metode ?? '-' }}</td></tr>
                <tr><td>Status Bayar</td><td class="right">{{ ucfirst($booking->payment->status ?? '-') }}</td></tr>
                <tr class="total"><td>Total Bayar</td><td class="right">Rp{{ number_format($booking->payment->jumlah ?? 0, 0, ',', '.') }}</td></tr>
            </table>
            <hr>
            <p class="center">Terimakasih sudah parkir di Kabasa mohon untuk hati-hati di jalan dan tetap patuhi peraturan lalulintas:)</p>
            <p class="center">@kabasa_parkir_yuk</p>
        </div>
    </div>

    <!-- Tombol cetak di luar wrapper -->
    <div class="no-print center" style="margin-top:16px;">
        <button onclick="window.print()">Cetak</button>
    </div>
</body>
</html>