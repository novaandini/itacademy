<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Certificate of Completion</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0; /* Remove default body margin */
        }
        .container {
            text-align: center;
            position: relative; /* Allow absolute positioning of child elements */
            width: 100%; /* Ensure full width */
            height: 100vh; /* Full height of the viewport */
        }
        .certificate-background {
            background: url('{{ public_path('assets/img/SERTIF.png') }}') no-repeat center center;
            background-size: cover; /* Cover entire area */
            position: absolute; /* Position absolutely to fill the container */
            top: 0; /* Align to top */
            left: 0; /* Align to left */
            right: 0; /* Align to right */
            bottom: 0; /* Align to bottom */
            padding: 140px; /* Adjust padding to desired amount */
            box-sizing: border-box; /* Include padding in width/height calculations */
        }
        .certificate-header {
            font-size: 2.2rem; /* Adjust font size */
            color: #2c3e50;
            text-shadow: 1.5px 1.5px #ddd; /* Adjust shadow */
            margin: 5px 0; /* Decrease top and bottom margin */
        }
        .recipient-name {
            text-transform: uppercase;
            color: #1a73e8;
            font-size: 2.5rem; /* Adjust font size */
            border-bottom: 1.5px solid #2c3e50; /* Border size */
            display: inline-block;
            padding-bottom: 4px; /* Padding */
            margin: 5px 0 10px; /* Decrease top margin and adjust bottom margin */
        }
        .course-title {
            font-size: 1.6rem; /* Adjust font size */
            color: #444;
            font-weight: bold;
            margin: 5px 0; /* Decrease top and bottom margin */
        }
        .signature {
            width: 100px; /* Adjust signature width */
            margin-top: 10px; /* Adjust margin above signature */
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="certificate-background">
            <h2 class="certificate-header">Certificate of Completion</h2>
            <p>Presented to</p>
            <h1 class="recipient-name">
                {{ $certification->user->name ?? 'Unknown Recipient' }}
            </h1>
            <p>In recognition of successfully completing the program:</p>
            <h3 class="course-title">
                {{ $certification->course->title ?? 'No Course' }}
            </h3>
            <p>{{ $certification->description }}</p>
            <p>{{ $certification->certificate_number ?? 'Not Available' }}</p>
            <p>Bali, {{ $certification->date ? \Carbon\Carbon::parse($certification->date)->format('j F, Y') : 'No Date' }}</p>
            <img src="{{ public_path('assets/img/TTD.png') }}" alt="Signature" class="signature">
        </div>
    </div>
</body>
</html>
