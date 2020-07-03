<h3>Dados Pessoais</h3>
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
    <label for="txtDataNascimento" class="col-md-2 control-label">Nascimento</label>
    <div class="col-md-2">
        <input type="date" class="form-control" name="txtDataNascimento" required />
    </div>
</div>
<div class="form-group">
    <div class="col-md-12">
        <label class="col-md-12">
            Possui Deficiência Auditiva?&nbsp;&nbsp;<input type="checkbox" name="chkDeficiencia" />
        </label>
        <p class="help-block">&nbsp;&nbsp;&nbsp;&nbsp;Os profissionais sempre serão avisados para contatá-lo via e-mail ou mensagem.</p>
    </div>
</div>
