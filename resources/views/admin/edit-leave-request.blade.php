<!DOCTYPE html>
<html>
<head>
    <title>Edit Leave Request</title>
</head>
<body>
    <h1>Edit Leave Request</h1>
    <form action="{{ route('admin.leaveRequest.update', $leave->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('POST')
        
        <label for="full_name">Nama:</label>
        <input type="text" id="full_name" name="full_name" value="{{ $leave->full_name }}" required><br>

        <label for="section">Bagian:</label>
<input type="text" id="section" name="section" value="{{ $leave->section }}" required><br>


        <label for="duration">Durasi:</label>
        <input type="number" id="duration" name="duration" value="{{ $leave->duration }}" required><br>

        <label for="start_date">Tanggal Mulai:</label>
        <input type="date" id="start_date" name="start_date" value="{{ $leave->start_date }}" required><br>

        <label for="end_date">Tanggal Akhir:</label>
        <input type="date" id="end_date" name="end_date" value="{{ $leave->end_date }}" required><br>

        <label for="creation_date">Tanggal Pembuatan Surat:</label>
        <input type="date" id="creation_date" name="creation_date" value="{{ $leave->creation_date }}" required><br>

        <label for="representative_name">Nama Wakil:</label>
        <input type="text" id="representative_name" name="representative_name" value="{{ $leave->representative_name }}" required><br>

        <button type="submit">Update</button>
    </form>
</body>
</html>
