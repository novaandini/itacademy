@extends('layouts.backend.admin')

@section('konten')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Submission</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Submission</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h1 class="card-title">{{ $title }}</h1>
                </div>
                <div class="card-body">
                    <div class="mb-2" id="userName" style="text-align: right;">
                        <p>Name : {{ Auth::user()->name }}</p> <!-- Nama User -->
                    </div>
            
                    <!-- Tombol Print -->
                    <div class="d-flex justify-content-between mb-4">
                        <button onclick="window.print()" class="btn btn-primary"><i class="bi bi-printer"></i> Print</button>
                    </div>
            
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered align-middle" id="assignmentTable">
                            <thead class="bg-primary text-white">
                                <tr class="text-center">
                                    <th>Course</th>
                                    <th>Title</th>
                                    <th>Deadline</th>
                                    <th>File/Image</th>
                                    <th>Status</th>
                                    <th>Grade</th>
                                    <th class="action-column">Action</th> <!-- Action Column -->
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                @foreach ($assignments->groupBy('course.title') as $courseTitle => $courseAssignments)
                                    <!-- Baris untuk Judul Course -->
                                    <tr>
                                        <td colspan="7" class="font-weight-bold">
                                            <h4>{{ $courseTitle }}</h4>
                                        </td>
                                    </tr>
            
                                    <!-- Baris untuk masing-masing Assignment dalam Course tersebut -->
                                    @foreach ($courseAssignments as $assignment)
                                        <tr>
                                            <td></td> <!-- Kosong karena sudah ada judul course di atas -->
                                            <td>{{ $assignment->title }}</td>
            
                                            <!-- Tampilkan Deadline -->
                                            <td class="text-center">
                                                {{ \Carbon\Carbon::parse($assignment->deadline)->format('d M Y, H:i') }}
                                            </td>
            
                                            <!-- Tampilkan File atau Gambar jika ada -->
                                            <td class="text-center">
                                                @if ($assignment->file_path)
                                                    <a href="{{ asset('storage/' . $assignment->file_path) }}" target="_blank">View File</a>
                                                @else
                                                    No File
                                                @endif
                                            </td>
            
                                            <!-- Tampilkan Status Submission -->
                                            <td class="text-center">
                                                {{ $assignment->submission->status ?? 'Not Submitted' }}
                                            </td>
            
                                            <!-- Tampilkan Nilai jika ada -->
                                            <td class="text-center">
                                                {{ $assignment->submission->grade ?? 'Not Graded' }}
                                            </td>
            
                                            <!-- Tampilkan Action -->
                                            <td class="text-center action-column">
                                                @php
                                                    $deadlinePassed = \Carbon\Carbon::now()->isAfter($assignment->deadline);
                                                @endphp
            
                                                @if ($assignment->submission)
                                                    <a href="{{ route('user.assignments.submit', $assignment->id) }}"
                                                        class="btn disabled btn-success btn-sm rounded-pill text-white">Done</a>
                                                @elseif ($deadlinePassed)
                                                    <button class="btn disabled btn-danger btn-sm rounded-pill">Deadline Passed</button>
                                                @else
                                                    <a href="{{ route('user.assignments.submit', $assignment->id) }}"
                                                        class="btn btn-primary btn-sm rounded-pill">Submit Answer</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection
