@include('layouts.title')
<!-- Include jQuery from CDN -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<body>

  <!-- Include Header -->
  @include('layouts.header')

  <!-- Include Sidebar -->
  @include('layouts.sidebar')

  <main id="main" class="main">
  
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <h1>User Management</h1>
            </div>
            <div class="col-md-5 text-end">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                    Add User
                </button>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->fullname }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if ($user->role == 1)
                            <span class="text-primary">Administrator</span>
                            @else
                            <span class="text-success">Employee</span>
                            @endif
                        </td>
                        <td>
                            @if ($user->isactive == 1)
                            <span class="text-success">Online</span>
                            @else
                            <span class="text-danger">Offline</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-primary">Edit</a>
    
                            <form action="{{ route('users.destroy', $user) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                            
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Add User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addUserForm">
                        @csrf
                        <div class="mb-3">
                            <label for="fullname" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="fullname" name="fullname" required>
                            <div class="invalid-tooltip">
                                Please enter a valid full name.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                            <div class="invalid-tooltip">
                                Please enter a valid username.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                            <div class="invalid-tooltip">
                                Please enter a valid email address.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                            <div class="invalid-tooltip">
                                Please enter a valid password (at least 8 characters).
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select class="form-control" id="role" name="role" required>
                                <option selected="selected" disabled="disabled">Select Role</option>
                                <option value="0">Employee</option>
                                <option value="1">Administrator</option>
                            </select>
                            <div class="invalid-tooltip">
                                Please select a role.
                            </div>
                        </div>
                        <button type="button" id="addUserBtn" class="btn btn-primary">Add User</button>
                    </form>
                                 
                </div>
            </div>
        </div>
    </div>
    
</main>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        $("#addUserBtn").click(function(event) {
            event.preventDefault();

            // Validation for required fields
            if ($("#fullname").val() === '' || $("#username").val() === '' || $("#email").val() === '' || $("#password").val() === '' || $("#role").val() === '') {
                if ($("#fullname").val() === '') {
                    $("#fullname").addClass("is-invalid");
                    $("#fullname").next(".invalid-tooltip").text("Please enter a valid full name.");
                }
                if ($("#username").val() === '') {
                    $("#username").addClass("is-invalid");
                    $("#username").next(".invalid-tooltip").text("Please enter a valid username.");
                }
                if ($("#email").val() === '') {
                    $("#email").addClass("is-invalid");
                    $("#email").next(".invalid-tooltip").text("Please enter a valid email address.");
                }
                if ($("#password").val() === '') {
                    $("#password").addClass("is-invalid");
                    $("#password").next(".invalid-tooltip").text("Please enter a valid password (at least 8 characters).");
                }
                if ($("#role").val() === '') {
                    $("#role").addClass("is-invalid");
                    $("#role").next(".invalid-tooltip").text("Please select a role.");
                }
                return false;
            }

            var formData = {
                fullname: $("#fullname").val(),
                username: $("#username").val(),
                email: $("#email").val(),
                password: $("#password").val(),
                role: $("#role").val(),
                _token: $('input[name="_token"]').val()
            };

            $.ajax({
                url: "{{route('store.user')}}",
                type: 'POST',
                data: formData,
                success: function(response) {
                    $('#addUserModal').modal('hide');
                    alert('User added successfully!');
                    location.reload();
                },
                error: function(xhr, status, error) {
                    // Show the error message from the server
                    var errorMessage = xhr.responseJSON.message;
                    alert('Error: ' + errorMessage);
                }
            });
        });

        // Clear validation classes and messages on focus
        $("#fullname, #username, #email, #password, #role").focus(function() {
            $(this).removeClass("is-invalid").next(".invalid-tooltip").text("");
        });
    });
</script>






  <!-- Include Footer -->
  @include('layouts.footer')
</body>

</html>