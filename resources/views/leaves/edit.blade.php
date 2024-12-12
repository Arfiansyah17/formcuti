<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pengajuan Cuti</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .signature img {
            max-width: 150px; /* Lebar maksimum gambar */
            height: auto; /* Menjaga rasio aspek gambar */
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto py-8">
        <h1 class="text-3xl font-bold mb-6 text-center">Edit Pengajuan Cuti</h1>

        <div class="bg-white p-6 rounded-lg shadow-lg">
            <form action="{{ route('leaves.update', $leave->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-5">
                    <label for="full_name" class="block mb-2 text-sm font-medium text-gray-900">Nama Lengkap:</label>
                    <input type="text" name="full_name" id="full_name" value="{{ $leave->full_name }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                </div>

                <div class="mb-5">
                    <label for="section" class="block mb-2 text-sm font-medium text-gray-900">Seksi:</label>
                    <input type="text" name="section" id="section" value="{{ $leave->section }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                </div>

                <div class="mb-5">
                    <label for="duration" class="block mb-2 text-sm font-medium text-gray-900">Durasi Cuti (hari):</label>
                    <input type="text" name="duration" id="duration" value="{{ $leave->duration }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                </div>

                <div class="mb-5">
                    <label for="reason" class="block mb-2 text-sm font-medium text-gray-900">Alasan Pengajuan Cuti:</label>
                    <input type="text" name="reason" id="reason" value="{{ $leave->reason }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                </div>

                <div class="mb-5">
                    <label for="letter_date" class="block mb-2 text-sm font-medium text-gray-900">Tanggal Pembuatan Surat:</label>
                    <input type="date" name="letter_date" id="letter_date" value="{{ $leave->letter_date }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                </div>

                <div class="mb-5">
                    <label for="signature1" class="block mb-2 text-sm font-medium text-gray-900">Tanda Tangan 1:</label>
                    <input type="file" name="signature1" id="signature1" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    @if($leave->signature1)
                        <div class="signature mt-2">
                            <img src="{{ Storage::url($leave->signature1) }}" alt="Signature 1">
                        </div>
                    @endif
                </div>

                <div class="mb-5">
                    <label for="signature2" class="block mb-2 text-sm font-medium text-gray-900">Tanda Tangan 2:</label>
                    <input type="file" name="signature2" id="signature2" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    @if($leave->signature2)
                        <div class="signature mt-2">
                            <img src="{{ Storage::url($leave->signature2) }}" alt="Signature 2">
                        </div>
                    @endif
                </div>

                <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-lg">Update</button>
            </form>
        </div>
    </div>
</body>
</html>
