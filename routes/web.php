<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

use App\Models\Estado;

// Root
Route::get('/', function () {
    $estados = Estado::all();

    if (Auth::check()) {
        if (session()->get('TIPO_PESSOA') === 'PP') {
            return view('home', ['estados' => $estados]);
        } else {
            return redirect('/agenda/profissional');
        }
    }

    return view('home', ['estados' => $estados]);

})->name('home');

// Login/Logout
Route::get('login', 'AutenticacaoController@getLogin')->name('login');
Route::post('login', 'AutenticacaoController@postLogin');
Route::get('logout', 'AutenticacaoController@getLogout')->name('logout');

// Cadastros (Pacientes, Profissionais PF, Profissionais PJ)
Route::group(['prefix' => 'cadastro'], function() {
    Route::get('username/check', 'PessoaController@checkUniqueLogin');

    Route::get('paciente', 'PacienteController@getCreate');
    Route::get('pessoafisica', 'PessoaFisicaController@getCreate');
    Route::get('pessoajuridica', 'PessoaJuridicaController@getCreate');

    Route::post('paciente/store', 'PacienteController@postStore');
    Route::post('pessoafisica/store', 'PessoaFisicaController@postStore');
    Route::post('pessoajuridica/store', 'PessoaJuridicaController@postStore');

    // Buscas (cidade, bairro, convenios, especialidades)
    Route::group(['prefix' => 'busca'], function() {
        Route::get('cidades', 'PessoaController@getCidadesByEstado');
        Route::get('bairros', 'PessoaController@getBairrosByCidade');
        Route::get('convenios', 'ProfissionalController@getConvenios');
        Route::get('especialidades', 'ProfissionalController@getEspecialidades');
        Route::get('procedimentos', 'ProfissionalController@getProcedimentos');
    });

    // Salvar cidade e bairro
    Route::group(['prefix' => 'salvar'], function() {
        Route::post('cidade', 'PessoaController@postAddCidade');
        Route::post('bairro', 'PessoaController@postAddBairro');
    });
});

// Cadastros Profissional Logado
Route::group(['prefix' => 'cadastro', 'middleware' => ['auth']], function() {
    Route::get('profissional', 'ProfissionalController@getProfissional');
    Route::get('profissional/convenios', 'ProfissionalController@getConveniosProfissional');
    Route::post('profissional/convenio/add', 'ProfissionalController@addConvenioProfissional');
    Route::post('profissional/convenio/drop', 'ProfissionalController@dropConvenioProfissional');
    Route::post('profissional/convenio/new', 'ProfissionalController@addNewConvenioProfissional');

    Route::get('profissional/especialidades', 'ProfissionalController@getEspecialidadesProfissional');
    Route::post('profissional/especialidade/add', 'ProfissionalController@addEspecialidadeProfissional');
    Route::post('profissional/especialidade/drop', 'ProfissionalController@dropEspecialidadeProfissional');
    Route::post('profissional/especialidade/new', 'ProfissionalController@addNewEspecialidadeProfissional');

    Route::get('profissional/procedimentos', 'ProfissionalController@getProcedimentosProfissional');
    Route::post('profissional/procedimento/add', 'ProfissionalController@addProcedimentoProfissional');
    Route::post('profissional/procedimento/drop', 'ProfissionalController@dropProcedimentoProfissional');
    Route::post('profissional/procedimento/new', 'ProfissionalController@addNewProcedimentoProfissional');
    Route::post('profissional/procedimento/alter', 'ProfissionalController@alterProcedimentoProfissional');

    Route::get('/profissional/disponibilidade', 'ProfissionalDisponibilidadeController@getDisponibilidadeProfissional');
    Route::get('/profissional/disponibilidade/horarios', 'ProfissionalDisponibilidadeController@getHorariosDisponibilidadeProfissional');
    Route::post('/profissional/disponibilidade/add', 'ProfissionalDisponibilidadeController@addDisponibilidadeProfissional');
    Route::post('/profissional/disponibilidade/drop', 'ProfissionalDisponibilidadeController@dropDisponibilidadeProfissional');

    Route::get('/profissional/assistentes', 'ProfissionalController@getAssistentes');
    Route::get('/profissional/assistente/list', 'ProfissionalController@getAssistentesList');
    Route::get('/profissional/assistente', 'ProfissionalController@addAssistente');
    Route::post('/profissional/assistente/store', 'ProfissionalController@postAssistenteStore');
    Route::post('/profissional/assistente/update', 'ProfissionalController@postAssistenteUpdate');

    Route::get('/dados/atualizar', 'PessoaController@getUpdateInformacoesUsuario');
    Route::post('/dados/atualizar', 'PessoaController@postUpdateInformacoesUsuario');

});

// Agenda
Route::group(['prefix' => 'agenda'], function() {
    Route::get('profissional/especialidades', 'AgendaController@getEspecialidadesByCidade');
    Route::get('profissional/procedimentos', 'AgendaController@getProcedimentosByCidade');
    Route::get('profissional/convenios', 'AgendaController@getConveniosByCidade');
    Route::get('profissional/disponiveis', 'AgendaController@getProfissionaisDisponiveis');
    Route::get('profissional/disponivel/horarios', 'AgendaController@getHorariosDisponiveisByProfissional');
    Route::get('profissional/detalhes', 'AgendaController@getDetalhesProfissional');
    Route::get('profissional/agendamento', 'AgendaController@getAgendamentoProfissional');
    Route::post('profissional/agendamento/add', 'AgendaController@addAgendamentoProfissional');

    // Autenticado
    Route::group(['middleware' => ['auth']], function() {
        Route::get('profissional', 'AgendaController@getAgendaProfissional');
        Route::get('profissional/list', 'AgendaController@getDadosAgendaProfissional');
        Route::get('profissional/details', 'AgendaController@getDetalhesAgendamentoProfissional');
        Route::post('profissional/approve', 'AgendaController@alterAgendamentoProfissionalStatus');
        Route::post('profissional/cancel', 'AgendaController@alterAgendamentoProfissionalStatus');
        Route::get('paciente', 'AgendaController@getAgendaPaciente');
        Route::get('paciente/list', 'AgendaController@getDadosAgendaPaciente');
        Route::get('paciente/details', 'AgendaController@getDetalhesAgendamentoPaciente');
        Route::post('paciente/cancel', 'AgendaController@alterAgendamentoPacienteStatus');
    });
});
