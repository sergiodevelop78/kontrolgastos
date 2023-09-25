@extends('layouts.app')

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js">
</script>

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js">
</script>
<script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js">
</script>


<title>Ver Consumos de periodo</title>
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">{{ __('Listado de consumo del periodo actual...') }}</div>

                <div class="card-body">
                    <table class="table table-striped table-bordered table-sm" id="sortTable">
                        <thead class="table-dark">
                            <tr>
                                <th class="text-center">Concepto</th>
                                <th class="text-center">Monto Soles</th>
                                <th class="text-center">Fecha</th>
                                <th class="text-center">Usuario</th>
                            </tr>
                        </thead>
                        <tbody class="table-group-divider">
                            @foreach ($registrosPeriodo as $row)
                            <tr>
                                <td>{{ $row->concepto }}</td>
                                <td class="text-center">{{ $row->total }}</td>
                                <td class="text-center">{{ $row->fecha_consumo }}</td>
                                <td class="text-center">{{ $row->name }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Total:</th>
                                <th class="text-center">S/. {{ $totalConsumoPeriodo }}</th>
                            </tr>
                        </tfoot>
                    </table>

                    <script>
                        $('#sortTable').DataTable({
                            lengthMenu: [
                                [20, 25, 50, -1],
                                [20, 25, 50, 'All'],
                            ],
                            order: [
                                [2, 'desc']
                            ],
                            language: {
                                decimal: '.',
                                thousands: ',',
                            },
                        });
                    </script>

                    <div class="text-center">
                        <a href="{{route('home')}}" class="btn btn-primary">Pagina Inicio</a>
                        <a href="{{route('verPeriodosRoute')}}" class="btn btn-danger">Volver</a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>




@endsection