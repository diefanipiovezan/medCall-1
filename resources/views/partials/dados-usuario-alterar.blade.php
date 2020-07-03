<h3>Dados de Usuário</h3>
<hr />
<div class="form-group">
    <label for="txtUsuario" class="col-md-2 control-label">Usuário</label>
    <div class="col-md-3">
        <input type="text" class="form-control" readonly value="{{ $dados['usuario']->username }}" />
    </div>
</div>
<div class="form-group">
    <label for="txtEmail" class="col-md-2 control-label">Email</label>
    <div class="col-md-3">
        <input type="email" class="form-control" name="txtEmail" placeholder="email" maxlength="64" required value="{{ $dados['usuario']->email }}" />
    </div>
</div>
<div class="row">
    <button class="btn btn-primary" id="btnRedefinirSenha"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>&nbsp;Redefinir Senha</button>
</div>
<div id="div-inputs-senha" style="display: none;">
    <div class="row">
        <button class="btn btn-danger" id="btnRedefinirSenhaCancelar"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span>&nbsp;Cancelar Redifinição de Senha</button>
    </div>
    <br />
    <div class="form-group">
        <label for="txtSenha" class="col-md-2 control-label">Senha</label>
        <div class="col-md-3">
            <input type="password" class="form-control" name="txtSenha" id="txtSenha" placeholder="senha" maxlength="255" />
        </div>
    </div>
    <div class="form-group">
        <label for="txtSenhaConfirma" class="col-md-2 control-label">Confirmação</label>
        <div class="col-md-3">
            <input type="password" class="form-control" name="txtSenhaConfirma" id="txtSenhaConfirma" placeholder="digite a senha novamente" />
        </div>
    </div>

</div>
@push('scripts-footer')
    <script src="{{ asset('js/partials/dados-usuario-alterar.js') }}"></script>
@endpush
