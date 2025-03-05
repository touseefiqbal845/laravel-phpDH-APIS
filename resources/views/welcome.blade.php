<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/YOUR_KIT_CODE.js" crossorigin="anonymous"></script>
<
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

       
                    </head>

                    <main class="mt-6">
                

<div class="container">
    <div class="d-flex justify-content-between align-items-center my-4">
        <h2 class="text-primary"><i class="fas fa-user-md"></i> Doctors List</h2>
        <a href="#" class="btn btn-success"><i class="fas fa-plus"></i> Add New Doctor</a>
    </div>

    <!-- Search Form -->
    <form method="GET" action="{{ route('doctors.index') }}" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search by name, career, or specialty..." value="{{ request()->search }}">
            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
        </div>
    </form>

    <table class="table table-hover shadow-sm bg-white rounded">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Career</th>
                    <th>Speciality</th>
                    <th>Experience</th>
                    <th>Rating</th>
                    <th>Hourly Rate</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($doctors as $doctor)
                <tr>
                    <td><strong>#{{ $doctor->id }}</strong></td>
                    <td>{{ $doctor->name }}</td>
                    <td>{{ $doctor->career }}</td>
                    <td>{{ $doctor->speciality }}</td>
                    <td>{{ $doctor->experience }}</td>
                    <td>
                        <span class="badge bg-warning text-dark"><i class="fas fa-star"></i> {{ $doctor->rating }}</span>
                    </td>
                    <td><strong>${{ number_format($doctor->hour_rate, 2) }}</strong></td>
                    <td>
                        <!-- <a href="{{ route('doctors.show', $doctor->id) }}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a> -->
                        <!-- <a href="{{ route('edit', $doctor->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a> -->
                        <!-- <form action="{{ route('destroy', $doctor->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form> -->
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    <!-- Pagination -->
    
</div>

                    </main>

                    <footer class="py-16 text-center text-sm text-black dark:text-white/70">
                        Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
                    </footer>
                </div>
            </div>
        </div>
    </body>
</html>
