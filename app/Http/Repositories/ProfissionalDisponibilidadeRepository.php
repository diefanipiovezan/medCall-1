<?php

namespace App\Http\Repositories;

use App\Models\Pessoa;
use App\Models\Disponibilidade;
use Illuminate\Support\Facades\DB;

class ProfissionalDisponibilidadeRepository
{
    public function getHorariosDisponiveis($idUsuario)
    {
        $pessoa = Pessoa::where('id_usuario', $idUsuario)->first();

        $result = [
            'dia01' => $this->getHorariosByDay(1, $pessoa->id),
            'dia02' => $this->getHorariosByDay(2, $pessoa->id),
            'dia03' => $this->getHorariosByDay(3, $pessoa->id),
            'dia04' => $this->getHorariosByDay(4, $pessoa->id),
            'dia05' => $this->getHorariosByDay(5, $pessoa->id),
            'dia06' => $this->getHorariosByDay(6, $pessoa->id),
            'dia07' => $this->getHorariosByDay(7, $pessoa->id)
        ];

        return $result;
    }

    public function addDisponibilidadeProfissional($dia, $horario, $idUsuario)
    {
        $pessoa = Pessoa::where('id_usuario', $idUsuario)->first();

        $disponibilidade = new Disponibilidade;
        $disponibilidade->dia_semana = $dia;
        $disponibilidade->horario = $horario;
        $disponibilidade->id_pessoa = $pessoa->id;
        $disponibilidade->save();

        return $disponibilidade;
    }

    public function dropDisponibilidadeProfissional($idDisponibilidade, $idUsuario)
    {
        $pessoa = Pessoa::where('id_usuario', $idUsuario)->first();
        $disponibilidade = Disponibilidade::find($idDisponibilidade);

        // Apaga somente se o registro for do usuário.
        if ((int)$disponibilidade->id_pessoa === $pessoa->id ) {
            $disponibilidade->delete();

            $result =  [
                'status'  => 'OK',
                'message' => 'Registro excluído.'
            ];
        } else {
            $result =  [
                'status'  => 'NOK',
                'message' => 'Não é possível excluir o registro! Está associado a outro usuário.'
            ];
        }

        return $result;
    }

    private function getHorariosByDay($dia, $idPessoa)
    {
        $horarios = Disponibilidade::where([ 'dia_semana' => $dia, 'id_pessoa'  => $idPessoa ])
            ->orderBy('horario', 'asc')
            ->get();

        return $horarios;
    }

}
