{{-- Mensagens de error de exception --}}
@if (session('error-exception'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fa-solid fa-triangle-exclamation" style="font-size: 20px"></i>
        {{ session('error-exception') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

