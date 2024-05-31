@include('layouts.title')

<!-- Include Header -->
@include('layouts.header')

<!-- Include Sidebar -->
@include('layouts.sidebar')



@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

@if (session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif

<main id="main" class="main">
    
    

    <section class="section">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Traffic Adjudication Service</h5>
                <table id="officers-table" class="table table-striped table-bordered">
                    <!-- Table header -->
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">Apprehending Officer</th>
                            <th scope="col">Department</th>
                        </tr>
                    </thead>
                    <!-- Table body -->
                    <tbody>
                        @foreach ($officers as $officer)
                        <tr data-bs-toggle="modal" data-bs-target="#exampleModal{{ $officer->id }}">
                            <td>{{ $officer->officer ?? 'N/A' }}</td>
                            <td>{{ $officer->department ?? 'N/A'  }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    @foreach ($officers as $officer)
<div class="modal fade" id="exampleModal{{ $officer->id }}" tabindex="-1" aria-labelledby="exampleModalLabel{{ $officer->id }}" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel{{ $officer->id }}">Details for {{ $officer->officer ?? 'N/A' }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modal-body-{{ $officer->id }}">
                <!-- Placeholder content -->
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                  </div><strong>Loading...</strong>
            </div>
        </div>
    </div>
</div>


@endforeach

</main>
<script>
    const fetchViolationUrl = @json(route('fetchingofficer', ['id' => 'id']));

    document.querySelectorAll('.modal').forEach(modal => {
        modal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget; // Button that triggered the modal
            var modalId = modal.getAttribute('id').replace('exampleModal', ''); 
            var modalBody = modal.querySelector('.modal-body');
            
            // Generate the URL for fetching violation details
            var fetchUrl = fetchViolationUrl.replace('id', modalId);
            console.log(fetchUrl);

            // Delay the fetch request by 1.5 seconds
            setTimeout(() => {
                // Fetch content for the modal via AJAX or a fetch request
                fetch(fetchUrl)
                    .then(response => response.text())
                    .then(html => {
                        modalBody.innerHTML = html;
                    })
                    .catch(err => {
                        console.error('Failed to load modal content', err);
                        modalBody.innerHTML = '<p>Error loading content</p>';
                    });
            }, 1500); // 1.5 seconds delay
        });
    });
</script>
<!-- Initialize DataTables -->
<script>
    $(document).ready(function () {
        $('#officers-table').DataTable();
    });
</script>
<!-- Bootstrap CSS -->


<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<!-- Bootstrap JS Bundle (popper.js included) -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>

<!-- DataTables JS -->
<script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<!-- Loading Screen CSS -->
@include('layouts.footer')
</body>

</html>
