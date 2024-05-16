@include('layouts.title')

<body>

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
        <h5 class="card-title">Traffic Adjudication Service<span></span></h5>
        <table class="table table-borderless datatable">
            <!-- Table header -->
            <thead class="thead-light ">
                <tr>
                    <th scope="col">Apprehending Officer</th>
                    <th scope="col">Department</th>
                </tr>
            </thead>
            <!-- Table body -->
            <tbody>
                @foreach ($officers as $officer)
                <tr class="table-row" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $officer->id }}">
                    <td>{{ $officer->officer ?? 'N/A' }}</td>
                    <td>
                        {{$officer->department}}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</section>

@foreach($officers as $officer) 
<div class="modal fade" id="exampleModal{{ $officer->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <p>
                            <strong>Apprehending Officer:</strong> {{ $officer->officer ? $officer->officer : 'N/A' }}
                        </p>
                        <p>
                            <strong>Department</strong> {{ $officer->department }}
                        </p>
                    </div>    
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach
  </main>
  <!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Include DataTables library -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

<!-- Initialize DataTable -->

  <!-- Include Footer -->
  @include('layouts.footer')
</body>

</html> 

