@extends('layouts.app')

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/fontawesome.min.css" />

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css" />

<style type="text/css">
    i {
        font-size: 35px !important;
        padding: 1px;

    }
</style>


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8" style="padding-bottom: 2em">
            <form action="verPeriodos" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="d-flex justify-content-center mb-4">

                    <div class="form-outline me-3" style="width: 14rem">
                        <select class="form-control form-select" id="comboYear" name="comboYear">
                            <option value="2023">2023</option>
                            <option value="2024">2024</option>
                        </select>
                    </div>
                    <input type="submit" class="btn btn-primary" value="Buscar">
                </div>
            </form>

        </div>


        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Listado de consumos por periodos') }}</div>
                <div class="card-body">
                    <table class="table table-striped table-bordered table-sm">
                        <thead class="table-dark">
                            <tr>
                                <th class="text-center">Id Periodo</th>
                                <th class="text-center">Año</th>
                                <th class="text-center">Mes Inicial</th>
                                <th class="text-center">Mes Final</th>
                                <th class="text-center">Total</th>
                                <th class="text-center">Ver detalle</th>
                            </tr>
                        </thead>
                        <tbody class="table-group-divider">
                            @foreach ($listadoPeriodos as $row)
                            <tr>
                                <td class="text-center align-middle">{{ $row->idperiodo }}</td>
                                <td class="text-center align-middle">{{ $row->anyo }}</td>
                                <td class="text-center align-middle">{{ $row->fecIni }}</td>
                                <td class="text-center align-middle">{{ $row->fecFin }}</td>
                                <td class="text-center align-middle">S/. {{ $row->consumoPeriodo }}</td>
                                <td class="text-center align-middle">
                                    <a href="verconsumo_periodo/{{ $row->anyo }}/{{ $row->idperiodo }}"><i class="fas fa-binoculars"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="text-center">
                        <a href="home" class="btn btn-primary">Volver</a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>




@endsection