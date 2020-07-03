<h3>Dados Pessoa Física</h3>
<hr />
<div class="form-group">
    <label for="txtNome" class="col-md-2 control-label">Nome</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="txtNome" placeholder="nome completo" required />
    </div>
</div>
<div class="form-group">
    <label for="txtCpf" class="col-md-2 control-label">CPF</label>
    <div class="col-md-3">
        <input type="text" class="form-control" name="txtCpf" placeholder="CPF" required pattern="\d{3}\.\d{3}\.\d{3}-\d{2}" title="Formato: 999.999.999-99" />
    </div>
</div>
<div class="form-group">
    <label for="txtRg" class="col-md-2 control-label">RG</label>
    <div class="col-md-3">
        <input type="text" class="form-control" name="txtRg" placeholder="RG" required maxlength="12" />
    </div>
</div>
<div class="form-group">
    <label for="txtRegistro" class="col-md-2 control-label">Registro</label>
    <div class="col-md-2">
        <input type="text" class="form-control" name="txtRegistro" required maxlength="20" />
    </div>
</div>
