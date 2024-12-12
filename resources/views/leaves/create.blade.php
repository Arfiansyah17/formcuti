<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta dan resource lainnya -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pengajuan Cuti</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="icon" href="{{ asset('logo.png') }}" type="image/png">
    <style>
        /* Gaya custom */
        body {
            margin: 0;
            height: 100vh;
            background-image: url('{{ asset('jakartaa.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            overflow: hidden;
        }
        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: -1;
        }
        .wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
            padding: 2rem;
            box-sizing: border-box;
        }
        .text-container {
            max-width: 600px;
            padding: 2rem;
            background-color: rgba(0, 0, 0, 0.5);
            border-radius: 8px;
            margin-right: 6rem;
            color: white;
            flex: 1;
            text-align: left;
        }
        .form-wrapper {
            flex: 1;
            max-width: 600px;
            padding: 2rem;
        }
        .form-wrapper .form-content {
            background: rgba(255, 255, 255, 0.8);
            border-radius: 8px;
            padding: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        @media (max-width: 768px) {
            .wrapper {
                flex-direction: column;
                align-items: center;
                padding: 1rem;
            }
            .text-container {
                margin-right: 0;
                margin-left: 0;
                max-width: 100%;
                text-align: center;
            }
            .form-wrapper {
                margin-left: 0;
                max-width: 100%;
                padding: 1rem;
            }
            .form-content {
                padding: 1rem;
                box-shadow: none;
            }
        }
    </style>
</head>
<body>
    <div class="background-image"></div>
    <div class="overlay"></div>
    <div class="wrapper">
        <div class="text-container">
            <h1 class="text-6xl font-light mb-2">Lengkapkan Datamu Untuk Ajukan</h1>
            <h2 class="text-6xl font-semibold">Surat Cuti</h2>
            <p class="mt-2 text-lg">Pengisian data ini berguna untuk mempermudah kamu mendapatkan Surat Cuti</p>
        </div>
        <div class="form-wrapper">
            <div class="form-content">
                <!-- Alert setelah Submit -->
                <div id="alertMessage" class="bg-blue-100 border-t border-b border-blue-500 text-blue-700 px-4 py-3 mb-4 hidden" role="alert">
                    <p class="font-bold">Surat Cutimu sedang dalam proses pembuatan</p>
                    <p class="text-sm">Terima Kasih!</p>
                </div>

                <form id="leaveForm" action="{{ route('leaves.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Dropdown Nama Lengkap -->
                    <div class="mb-5">
                        <label for="full_name" class="block mb-2 text-sm font-medium text-gray-900">Nama Lengkap:</label>
                        <select name="full_name" id="full_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                            <option value="">Pilih Nama Lengkap</option>
                            @foreach ($names as $name)
                                <option value="{{ $name }}">{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Dropdown Seksi -->
                    <div class="mb-5">
                        <label for="section" class="block mb-2 text-sm font-medium text-gray-900">Seksi:</label>
                        <select name="section" id="section" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                            <option value="">Pilih Seksi</option>
                            <option value="HRD">HRD</option>
                            <option value="IT">IT</option>
                            <option value="Finance">Finance</option>
                            <option value="Marketing">Marketing</option>
                        </select>
                    </div>

                    <!-- Durasi Cuti -->
                    <div class="mb-5">
                        <label for="duration" class="block mb-2 text-sm font-medium text-gray-900">Durasi Cuti (hari):</label>
                        <input type="text" name="duration" id="duration" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                        <small class="text-gray-600">* Durasi cuti dihitung dari tanggal pembuatan surat.</small>
                    </div>

                    <!-- Alasan Pengajuan Cuti -->
                    <div class="mb-5">
                        <label for="reason" class="block mb-2 text-sm font-medium text-gray-900">Alasan Pengajuan Cuti:</label>
                        <input type="text" name="reason" id="reason" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                    </div>

                    <!-- Tanggal Pembuatan Surat -->
                    <div class="mb-5">
                        <label for="letter_date" class="block mb-2 text-sm font-medium text-gray-900">Tanggal Pembuatan Surat:</label>
                        <input type="date" name="letter_date" id="letter_date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                    </div>

                    <!-- Tanda Tangan 1 -->
                    <div class="mb-5">
                        <label for="signature1" class="block mb-2 text-sm font-medium text-gray-900">Tanda Tangan 1:</label>
                        <input type="file" name="signature1" id="signature1" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" accept="image/*" required>
                    </div>

                    <!-- Tanda Tangan 2 -->
                    <div class="mb-5">
                        <label for="signature2" class="block mb-2 text-sm font-medium text-gray-900">Tanda Tangan 2:</label>
                        <input type="file" name="signature2" id="signature2" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" accept="image/*" required>
                    </div>

                    <!-- Tombol Submit -->
                    <button type="submit" class="text-white bg-black focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full px-5 py-2.5 text-center">Submit</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script>
        document.getElementById('leaveForm').addEventListener('submit', function(event) {
            event.preventDefault();

            Swal.fire({
                title: 'Konfirmasi Pengiriman',
                text: 'Apakah Anda yakin ingin mengirimkan form ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, kirim!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Kirim formulir
                    const form = document.getElementById('leaveForm');
                    const formData = new FormData(form);

                    // Debugging: Log FormData
                    console.log('FormData:', [...formData.entries()]);

                    fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        }
                    }).then(response => {
                        console.log('Server Response:', response); // Debugging: Log response
                        if (response.ok) {
                            return response.json(); // Asumsi server mengirimkan response JSON
                        } else {
                            return response.text().then(text => { // Ambil respons dalam format teks untuk debugging
                                console.error('Server Error:', text);
                                throw new Error('Gagal mengirim data.');
                            });
                        }
                    }).then(data => {
                        Swal.fire({
                            title: 'Surat Cutimu sedang dalam proses pembuatan',
                            text: 'Terima Kasih!',
                            icon: 'success',
                            confirmButtonText: 'Ok'
                        });
                        form.reset();
                    }).catch(error => {
                        Swal.fire({
                            title: 'Terjadi Kesalahan',
                            text: 'Gagal mengirim data. Silakan coba lagi.',
                            icon: 'error',
                            confirmButtonText: 'Ok'
                        });
                        console.error('Fetch Error:', error); // Debugging: Log error
                    });
                }
            });
        });
    </script>
</body>
</html>