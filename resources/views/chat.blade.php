

@section('title', env('APP_NAME'))

@include('layouts.title')

<body>

  <!-- ======= Header ======= -->
@include('layouts.header')

  <!-- ======= Sidebar ======= -->
 @include('layouts.sidebar')

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

      <div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card h-100">
                <div class="card-header bg-primary text-white">
                    Chat
                </div>
                <div class="card-body">
                <div class="chat-container overflow-auto" id="chatContainer">

                        <div class="chat-box" id="chatBox">
                            <!-- Messages will appear here -->
                            @foreach($messages as $message) <!-- Reverse the order of messages -->
                            <div class="message{{ $message->user->id == Auth::user()->id ? ' outgoing' : ' incoming' }}">
                                <div class="message-details{{ $message->user->id == Auth::user()->id ? ' text-end' : '' }}">
                                    <span class="message-sender"><strong>{{ $message->user->fullname }}</strong></span>
                                    <span class="message-time">{{ $message->created_at->format('M d, Y H:i A') }} <i class="bi bi-clock"></i> </span>
                                </div>
                                <div class="message-content{{ $message->user->id == Auth::user()->id ? ' outgoing' : ' incoming' }}">{{ $message->message }}</div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <form action="{{ route('chat.store') }}" method="post">
                        @csrf
                        <div class="input-group">
                            <input type="text" class="form-control chat-input" placeholder="Type your message..." id="messageInput" name="message">
                            <button type="submit" class="btn btn-primary"><i class="bi bi-send"></i>Send</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    // Function to scroll chat container to the bottom
    function scrollToBottom() {
        var chatContainer = document.getElementById('chatContainer');
        chatContainer.scrollTop = chatContainer.scrollHeight;
    }

    // Call the function when the page loads and whenever new messages are added
    window.onload = scrollToBottom;
</script>


      </div>
    </section>

  </main><!-- End #main -->

 @include('layouts.footer')
</body>

</html>