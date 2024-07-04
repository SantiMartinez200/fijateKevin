@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
                <h2>Movimientos Registrados</h2>
            </div>
            <div class="float-left ml-3 mt-2" >
                <button type="button" class="btn btn-success btn-sm my-2 " data-toggle="modal"
                    data-target="#modalRegistrarMovimiento">
                    <i class="bi bi-plus-circle"></i> Registrar Movimiento
                </button>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="modalRegistrarMovimiento" tabindex="-1" role="dialog"
                aria-labelledby="modalRegistrarMovimientoLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalRegistrarMovimientoLabel">Registrar Movimiento</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('caja.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="usuario_id" value="{{ Auth::user()->id }}">

                                <div class="form-group">
                                    <label for="fecha">Fecha:</label>
                                    <input type="date" class="form-control" id="fecha" name="fecha" required>
                                </div>
                                <div class="form-group">
                                    <label for="tipo">Tipo de Movimiento:</label>
                                    <select class="form-control" id="tipo" name="tipo" required>
                                        <option value="apertura">Apertura</option>
                                        <option value="venta">Venta</option>
                                        <option value="compra">Compra</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="monto">Monto:</label>
                                    <input type="number" class="form-control" id="monto" name="monto" step="0.01"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="comentario">Comentario:</label>
                                    <textarea class="form-control" id="comentario" name="comentario"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Guardar Movimiento</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <table class="table table-bordered mt-4">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Tipo</th>
                            <th>Monto</th>
                            <th>Comentario</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($movimientos as $movimiento)
                            <tr>
                                <td>{{ $movimiento->fecha }}</td>
                                <td>{{ $movimiento->tipo }}</td>
                                <td>{{ $movimiento->monto }}</td>
                                <td>{{ $movimiento->comentario }}</td>
                                <td>
                                    <a href="{{ route('caja.edit', $movimiento->id) }}" class="btn btn-primary">Editar</a>
                                    <a href="{{ route('caja.destroy', $movimiento->id) }}"
                                        class="btn btn-danger">Eliminar</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS y jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"
        integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous">
    </script>
@endsection
