<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Details</title>
    <!-- Bootstrap CSS (Optional, for styling) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>

    <div class="container mt-5">
        <h1 class="text-center">Doctor Details</h1>
        
        <div class="card mt-4">
            <div class="card-body">
                <h2 class="card-title">{{ $doctor->name }}</h2>
                <p><strong>Specialty:</strong> {{ $doctor->specialty }}</p>
                <p><strong>Experience:</strong> {{ $doctor->experience }} years</p>
                <p><strong>Email:</strong> {{ $doctor->email }}</p>
                <p><strong>Phone:</strong> {{ $doctor->phone }}</p>

                <a href="{{ route('doctors.index') }}" class="btn btn-primary">
                    <i class="fas fa-arrow-left"></i> Back to List
                </a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (Optional, for interactive components) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
