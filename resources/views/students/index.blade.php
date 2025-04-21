@extends('layouts.main')

@section('konten')
    <br><br>
    <div class="container">
        <h1 class="mb-4 text-center">Student Data</h1>

        <div class="d-flex justify-content-between mb-3">
            <div class="form-group">
                <label for="courseFilter">Filter by Program:</label>
                <form action="{{ route('students.index') }}" method="GET">
                    <select id="courseFilter" name="course" class="form-select" onchange="this.form.submit()">
                        <option value="">All Program</option>
                        @foreach ($courses as $course)
                            <option value="{{ $course->title }}" {{ $selectedCourse == $course->title ? 'selected' : '' }}>
                                {{ $course->title }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>
            <button onclick="window.print()" class="btn btn-primary"><i class="bi bi-printer"></i> Print</button>
        </div>

        @if ($students->isNotEmpty())
            <div class="table-responsive">
                <table class="table table-hover table-striped table-bordered align-middle" id="studentTable">
                    <thead class="bg-primary text-white">
                        <tr style="text-align: center">
                            <th scope="col" class="text-center">No</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Gender</th>
                            <th scope="col">Address</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Program</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $index => $student)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        {{ $student->name ?? '-' }}
                                    </div>
                                </td>
                                <td>{{ $student->email ?? '-' }}</td>
                                <td>{{ ucfirst($student->gender ?? '-') }}</td>
                                <td>{{ $student->address ?? '-' }}</td>
                                <td>{{ $student->phone ?? '-' }}</td>
                                <td>
                                    @php
                                        // Array to store unique course titles for the current student
                                        if ($student->transactions != null) {
                                            $courseTitles = []; 
                                            // Loop through the transactions of the student
                                            foreach ($student->transactions as $transaction) {
                                                // Check if the transaction is completed
                                                if ($transaction->status === 'settlement') {
                                                    foreach ($transaction->transactionItems as $item) {
                                                        // If 'All Program' is selected, add all checked out courses
                                                        if ($selectedCourse === '' || $item->course->title === $selectedCourse) {
                                                            $courseTitles[] = $item->course->title; // Add course title to the array
                                                        }
                                                    }
                                                }
                                            }
                                        
                                        // Remove duplicate course titles
                                        $uniqueCourseTitles = array_unique($courseTitles);
                                        // Display the results
                                        $courseDisplay = !empty($uniqueCourseTitles) ? implode(', ', $uniqueCourseTitles) : 'N/A';
                                        }
                                    @endphp
                                    {{ $courseDisplay }} <!-- Display unique course titles -->
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    
                </table>
            </div>
        @else
            <div class="alert alert-info text-center">Tidak ada siswa yang ditemukan.</div>
        @endif
    </div>
@endsection

<!-- Custom CSS to handle print behavior -->
<style>
    @media print {
        /* Hide everything except the table */
        body * {
            visibility: hidden;
        }

        #studentTable,
        #studentTable * {
            visibility: visible;
        }

        #studentTable {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
    }
</style>
