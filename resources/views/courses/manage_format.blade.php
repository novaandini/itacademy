@extends('layouts.main')

@section('konten')
    <br><br>
    <div class="container">
        <h1 class="mb-4 text-center">Student Data</h1>

        @if ($courseFormat->isNotEmpty())
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
                        @foreach ($courseFormat as $index => $format)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        {{ $format->name ?? '-' }}
                                    </div>
                                </td>
                                <td>{{ $format->email ?? '-' }}</td>
                                <td>{{ ucfirst($format->gender ?? '-') }}</td>
                                <td>{{ $format->address ?? '-' }}</td>
                                <td>{{ $format->phone ?? '-' }}</td>
                                <td>
                                    @php
                                        // Array to store unique course titles for the current student
                                        if ($format->transactions != null) {
                                            $courseTitles = []; 
                                            // Loop through the transactions of the student
                                            foreach ($format->transactions as $transaction) {
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
