@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <p class="fs-5">Fecha de hoy: {{ now()->format("d-m-Y"); }}</p>

                    <p class="fs-4">
                        Consumido hasta hoy:
                        <span class="badge rounded-pill text-bg-danger">S/. {{ App\Http\Controllers\NuevoConsumoController::getConsumidoPeriodo() }}
                        </span>
                    </p>

                    <p class="fs-6">Período: {{ App\Http\Controllers\NuevoConsumoController::showPeriodo() }}</p>
                    <p>
                        <a href="nuevoconsumo" class="btn btn-primary">Agregar nuevo consumo</a>
                        <a href="verconsumo_periodo" class="btn btn-info">Ver consumo del período</a>
                        <a href="{{route('verPeriodosRoute')}}" class="btn btn-dark">Ver periodos por Año</a>

                    </p>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection