<h3>Dados Pessoa Jurídica</h3>
<hr />
<div class="form-group">
    <label for="txtNome" class="col-md-2 control-label">Nome</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="txtNome" placeholder="nome completo" required value="{{ $dados['pessoa']->nome }}" />
    </div>
</div>
<div class="form-group">
    <label for="txtRazaoSocial" class="col-md-2 control-label">Razão Social</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="txtRazaoSocial" placeholder="razão social" required maxlength="60" value="{{ $dados['pessoajuridica']->razao_social }}" />
    </div>
</div>
<div class="form-group">
    <label for="txtNomeFantasia" class="col-md-2 control-label">Nome Fantasia</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="txtNomeFantasia" placeholder="nome fantasia" required maxlength="60" value="{{ $dados['pessoajuridica']->nome_fantasia }}" />
    </div>
</div>
<div class="form-group">
    <label for="txtCnpj" class="col-md-2 control-label">CNPJ</label>
    <div class="col-md-3">
        <input type="text" class="form-control" name="txtCnpj" placeholder="CNPJ" required maxlength="14" value="{{ $dados['pessoajuridica']->cnpj }}" />
    </div>
</div>
<div class="form-group">
    <label for="txtRegistro" class="col-md-2 control-label">Registro</label>
    <div class="col-md-2">
        <input type="text" class="form-control" name="txtRegistro" required maxlength="20" value="{{ $dados['pessoajuridica']->registro }}" />
    </div>
</div>
