<!DOCTYPE html>
<html>
<head>
    <title>Leave Request PDF</title>
    <style>
        @page {
            size: A4 portrait; /* Menetapkan ukuran A4 potrait */
            margin: 20mm; /* Menetapkan margin untuk PDF */
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            padding: 20px;
            box-sizing: border-box;
        }
        h1 {
            text-align: center;
            margin-top: 0;
        }
        .signature {
            margin-top: 20px;
        }
        .signature-image {
            max-width: 200px;
            height: auto;
            display: block;
            margin: 10px auto;
        }
        .letter {
            margin-top: 20px;
            line-height: 1.6;
        }
        .letter p {
            margin: 5px 0;
        }
        .signature-section {
            margin-top: 40px;
        }
        .signature-section div {
            margin-bottom: 30px;
        }
        .signature-section span {
            display: inline-block;
            width: 45%;
        }
        .data-bold {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>SURAT PENGAJUAN CUTI FINANCE</h1>

        <div class="letter">
            <p>Jakarta, {{ $leave->letter_date }}</p>
            <p>Kepada,</p>
            <p>Yth. Plt. Kepala Suku Dinas Komunikasi, Informatika dan Statistik Kota Administrasi Jakarta Selatan di Jakarta</p>
            <p>Hal: Permohonan Cuti</p>

            <p>Dengan hormat,</p>
            <p>Saya yang bertanda tangan di bawah ini:</p>
            <p><strong>Nama:</strong> <span class="data-bold">{{ $leave->full_name }}</span></p>
            <p><strong>Jabatan:</strong> <span class="data-bold">{{ $leave->position }}</span></p>
            <p>Bermaksud mengajukan permohonan cuti kerja selama <span class="data-bold">{{ $leave->duration }}</span> hari pada tanggal {{ $leave->letter_date }} <span class="data-bold">{{ $leave->start_date }}</span> {{ $leave->start_date }}<span class="data-bold">{{ $leave->end_date }}</span>. Waktu cuti selama <span class="data-bold">{{ $leave->duration }}</span> hari tersebut, saya pergunakan untuk urusan keluarga.</p>
            <p>Demikian permohonan ini saya buat untuk dapat dipertimbangkan sebagaimana mestinya.</p>
            <p>Selama Menjalankan Cuti Hormat Saya,</p>
            <p>Semua Tugas Pekerjaan</p>
            <p>Diwakilkan,</p>
            <p><span class="data-bold">{{ $leave->representative_name }}</span></p>
            <p><span class="data-bold">{{ $leave->full_name }} ({{ $leave->position }})</span></p>

            <div class="signature-section">
                <div>
                    <span>Mengetahui,</span>
                    <span>Menyetujui,</span>
                </div>
                <div>
                    <span>Plt. Kepala Suku Dinas Komunikasi, Informatika dan Statistik Kota Administrasi Jakarta Selatan</span>
                    <span>Plt. Kepala Seksi Infrastruktur Digital Sudin Komunikasi, Informatika dan Statistik Kota Administrasi Jakarta Selatan</span>
                </div>
                <div>
                    <span>Nuruning Septarida</span>
                    <span>Arief Darmanto</span>
                </div>
                <div>
                    <span>NIP 197309081993022001</span>
                    <span>NIP 198408112011011016</span>
                </div>
            </div>

            <p>Tembusan:</p>
            <p>Kepala Sub Bagian Tata Usaha Suku Dinas Kominfotik Kota Administrasi Jakarta Selatan</p>
        </div>

        <div class="signature">
            @if ($leave->signature1)
            
                <img src="{{ Storage::url($leave->signature1) }}" alt="Signature 1">
            @endif
            @if ($leave->signature2)
    
                <img src="{{ Storage::url($leave->signature2) }}" alt="Signature 2" >
            @endif
        </div>
    </div>
</body>
</html>
