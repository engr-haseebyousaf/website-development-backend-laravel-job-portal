@if(session()->has('success'))
    <div id="message" class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@if(session()->has('fail'))
    <div id="message" class="alert alert-danger alert-dismissible fade show">
        {{ session('fail') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@if(session()->has('warn'))
    <div id="message" class="alert alert-warning alert-dismissible fade show">
        {{ session('warn') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
