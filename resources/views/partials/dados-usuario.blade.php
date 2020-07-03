<h3>Dados de Usuário</h3>
<hr />
<div class="form-group">
    <label for="txtUsuario" class="col-md-2 control-label">Usuário</label>
    <div class="col-md-3">
        <input type="text" class="form-control" name="txtUsuario" id="txtUsuario" placeholder="usuário" maxlength="20" required />
    </div>
</div>
<div class="form-group">
    <label for="txtEmail" class="col-md-2 control-label">Email</label>
    <div class="col-md-3">
        <input type="email" class="form-control" name="txtEmail" placeholder="email" maxlength="64" required />
    </div>
</div>
<div class="form-group">
    <label for="txtSenha" class="col-md-2 control-label">Senha</label>
    <div class="col-md-3">
        <input type="password" class="form-control" name="txtSenha" id="txtSenha" placeholder="senha" maxlength="255" required />
    </div>
</div>
<div class="form-group">
    <label for="txtSenhaConfirma" class="col-md-2 control-label">Confirmação</label>
    <div class="col-md-3">
        <input type="password" class="form-control" name="txtSenhaConfirma" id="txtSenhaConfirma" placeholder="digite a senha novamente" required />
    </div>
</div>
@push('scripts-footer')
    <script src="{{ asset('js/partials/dados-usuario.js') }}"></script>
@endpush
