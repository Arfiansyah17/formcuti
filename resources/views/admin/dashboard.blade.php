<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.8.162/pdf.min.js"></script>
    <style>
        .signature-image {
            width: 50px;
            height: auto;
            border-radius: 4px;
        }
        #pdf-preview-modal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.75);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
        #pdf-preview-container {
            width: 595px; /* A4 width in pixels */
            height: 842px; /* A4 height in pixels */
            background: white;
            border-radius: 8px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }
        #pdf-preview {
            width: 100%;
            height: 100%;
        }
        #close-preview {
            position: absolute;
            top: 40px;
            right: 10px;
            cursor: pointer;
            background: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
        }
    </style>
</head>
<body 
class="bg-gray-100">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-6">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Admin Dashboard</h1>
        <div class="mb-6 p-4 bg-white rounded-lg shadow-md">
            <p class="text-lg font-semibold text-gray-700">Total Surat Cuti: <span class="text-blue-600">{{ $totalLeaves }}</span></p>
        </div>
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Lengkap</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Seksi</th> <!-- Kolom Seksi -->
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Durasi Cuti</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alasan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Surat</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Berakhir Cuti</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanda Tangan 1</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanda Tangan 2</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($leaves as $leave)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $leave->full_name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $leave->section }}</td> <!-- Data Seksi -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $leave->duration }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $leave->reason }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $leave->letter_date }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $leave->end_date }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($leave->signature1)
                                    <img src="{{ Storage::url($leave->signature1) }}" alt="Signature 1" class="signature-image">
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($leave->signature2)
                                    <img src="{{ Storage::url($leave->signature2) }}" alt="Signature 2" class="signature-image">
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="#" onclick="openPdfPreview('{{ route('leaves.pdf', $leave->id) }}');" class="text-blue-600 hover:text-blue-800">Preview PDF</a> |
                                <a href="{{ route('leaves.edit', $leave->id) }}" class="text-green-600 hover:text-green-800">Edit</a> |
                                <a href="#" onclick="event.preventDefault(); deleteLeave({{ $leave->id }});" class="text-red-600 hover:text-red-800">Hapus</a>
                                <form id="delete-form-{{ $leave->id }}" action="{{ route('leaves.destroy', $leave->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-4 text-center text-gray-500">No leaves found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal for PDF Preview -->
    <div id="pdf-preview-modal" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center">
        <div id="pdf-preview-container" class="relative">
            <button id="close-preview" class="text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            <canvas id="pdf-preview"></canvas>
        </div>
    </div>

    <script>
        async function openPdfPreview(url) {
            const modal = document.getElementById('pdf-preview-modal');
            const canvas = document.getElementById('pdf-preview');
            const context = canvas.getContext('2d');

            modal.style.display = 'flex';

            try {
                const loadingTask = pdfjsLib.getDocument({ url });
                const pdf = await loadingTask.promise;
                const page = await pdf.getPage(1);
                const scale = 1.0; // Adjust scale if needed for A4 size
                const viewport = page.getViewport({ scale });

                canvas.height = viewport.height;
                canvas.width = viewport.width;

                const renderContext = {
                    canvasContext: context,
                    viewport: viewport
                };
                const renderTask = page.render(renderContext);
                await renderTask.promise;
            } catch (error) {
                console.error('Error loading PDF:', error);
                Swal.fire('Error', 'Unable to load PDF preview.', 'error');
            }
        }

        document.getElementById('close-preview').addEventListener('click', () => {
            document.getElementById('pdf-preview-modal').style.display = 'none';
        });

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
            }).catch(error => {
                console.error('Error in deleteLeave function:', error);
            });
        }
    </script>
</body>
</html>