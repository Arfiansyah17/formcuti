<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Surat Cuti</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-6">
        <h1 class="text-2xl font-bold mb-6">Daftar Surat Cuti</h1>
        <p class="text-lg font-semibold mb-4">Total Surat Cuti Disetujui: {{ $approvedLeaves }}</p>
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Lengkap</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Durasi Cuti</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alasan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Surat</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanda Tangan 1</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanda Tangan 2</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($leaves as $leave)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $leave->full_name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $leave->duration }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $leave->reason }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $leave->letter_date }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if ($leave->signature1)
                                <img src="{{ Storage::url($leave->signature1) }}" alt="Signature 1" class="h-10">
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if ($leave->signature2)
                                <img src="{{ Storage::url($leave->signature2) }}" alt="Signature 2" class="h-10">
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="{{ route('leaves.pdf', $leave->id) }}" class="text-blue-600 hover:text-blue-900" target="_blank">Lihat PDF</a> |
                            <a href="#" onclick="event.preventDefault(); deleteLeave({{ $leave->id }});" class="text-red-600 hover:text-red-900">Hapus</a>
                            <form id="delete-form-{{ $leave->id }}" action="{{ route('leaves.destroy', $leave->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center">No leaves found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <script>
        function deleteLeave(id) {
            Swal.fire({
                title: 'Konfirmasi Penghapusan',
                text: "Apakah Anda yakin ingin menghapus data ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>
</body>
</html>
