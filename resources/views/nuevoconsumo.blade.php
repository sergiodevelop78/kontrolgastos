@extends('layouts.app')

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/material_blue.css">

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>



<script>
    $(document).ready(function(e) {

        $(".allownumericwithoutdecimal").on("keypress keyup blur", function(event) {
            $(this).val($(this).val().replace(/[^\d].+/, ""));
            if ((event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
        });

        var hoy = new Date()

        flatpickr('#fecha_consumo', {
            locale: 'es',
            dateFormat: 'Y-m-d',
            allowInput: false,
            ariaDateFormat: "F j, Y",
            clickOpens: true,
            defaultDate: null,
            enableTime: false,
            minDate: "2023-01",
            maxDate: hoy
        });
    });
</script>




@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="container mt-4">
                @if(session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
                @endif


                <div class="card">
                    <div class="card-header">{{ __('Nuevo Consumo') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('store-form') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="consumo_soles" class="col-md-4 col-form-label text-md-end">{{ __('Consumo Soles') }}</label>

                                <div class="col-md-6">
                                    <input id="consumo_soles" inputmode="decimal" type="decimal" class="form-control @error('consumo_soles') is-invalid @enderror" name="consumo_soles" value="{{ old('consumo_soles') }}" required autocomplete="consumo_soles" autofocus oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">

                                    @error('consumo_soles')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="concepto" class="col-md-4 col-form-label text-md-end">{{ __('Concepto') }}</label>

                                <div class="col-md-6">
                                    <input id="concepto" type="text" class="form-control @error('concepto') is-invalid @enderror" name="concepto" value="{{ old('concepto') }}" required autocomplete="concepto">

                                    @error('concepto')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="fecha_consumo" class="col-md-4 col-form-label text-md-end">{{ __('Fecha Consumo') }}</label>

                                <div class="col-md-6">
                                    <input id="fecha_consumo" type="text" class="form-control @error('fecha_consumo') is-invalid @enderror" name="fecha_consumo" value="{{ old('fecha_consumo') }}" required autocomplete="fecha_consumo">

                                    @error('fecha_consumo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary show_confirm">
                                        {{ __('Registrar consumo') }}
                                    </button>


                                    <a href="home" class="btn btn-secondary">Volver</a>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="javascript">
    document.onsubmit=function(){
           return confirm('Sure?');
       }
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
<script type="text/javascript">
    $('.show_confirm').click(function(event) {
        var form = $(this).closest("form");
        var name = $(this).data("name");
        event.preventDefault();

        swal({
                title: `Seguro de guardar los datos?`,
                text: "",
                buttons: true,
                buttons: ["Cancelar", "Ok"],
                dangerMode: false,
            })
            .then((willDelete) => {
                if (willDelete) {
                    form.submit();
                }
            });
    });
</script>




@endsection