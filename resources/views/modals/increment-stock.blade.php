<form action="incrementar-stock" method="POST">
    @method('POST')
    @csrf
  <div class="modal fade" id="incrementar-stock" tabindex="-1" aria-labelledby="incrementar-stockLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="incrementar-stockLabel">Incrementar Stock</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body mx-auto">
            <div class="form-group">
                <input type="number" value="" name="id" hidden readonly id="id">
                <label for="old_stock">Stock actual</label>
                <input type="number" value="" class="d-block" id="old_stock" name="old_stock">
                <div class="m-1"></div>
                <label for="new_stock">Sumar stock</label>
                <input type="number" placeholder="Expresar en unidades" value="" class="d-block" id="new_stock" name="new_stock">
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Actualizar Stock</button>
        </div>
      </div>
    </div>
  </div>
</form>

<script>
    function enviarMonto(cantidad,id){
        console.log(cantidad);
        console.log(id);
        let input = document.getElementById("old_stock")
        input.value = cantidad;
        let inputId = document.getElementById("id")
        inputId.value = id;
    }
</script>