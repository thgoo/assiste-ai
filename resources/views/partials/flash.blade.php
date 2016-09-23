@if(session()->has('flash_message'))
    <script>
        swal({
            title: '{!! session('flash_message.title') !!}',
            text: '{!! session('flash_message.message') !!}',
            type: '{!! session('flash_message.type') !!}',
            timer: 1700,
            showConfirmButton: false,
            html: true
        });
    </script>
@endif

@if(session()->has('flash_message_overlay'))
    <script>
        swal({
            title: '{!! session('flash_message_overlay.title') !!}',
            text: '{!! session('flash_message_overlay.message') !!}',
            type: '{!! session('flash_message_overlay.type') !!}',
            confirmButtonText: "Entendi",
            html: true
        });
    </script>
@endif

@if (count($errors) > 0)
    <script>
        swal({
            title: 'Ops!',
            text: '@foreach ($errors->all() as $error) <p>{{ $error }}</p> @endforeach',
            type: 'error',
            confirmButtonText: "Entendi",
            html: true
        });
    </script>
@endif