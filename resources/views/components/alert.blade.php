{{-- Mensagens de sucesso --}}
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

{{-- Mensagens de aviso --}}
@if (session('warning'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        {{ session('warning') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

{{-- Mensagens de error --}}
@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif


{{-- Mensagens de errors de validação --}}
@if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            @foreach ($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>


        {{--
        @php
            $message = '';
            foreach ($errors->all() as $error) {
                $message .= $error.'<br>';
            }
        @endphp

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                Swal.fire({
                    title: "Error!",
                    html: '{!! $message !!}',
                    icon: 'error'
                });
            })
        </script>
        --}}

@endif


