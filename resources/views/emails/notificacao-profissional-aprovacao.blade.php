<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Notificação</title>
    </head>
    <body>
        Olá, {{$notificacao->paciente}}
        <br />Seu agendamento foi confirmado!
        <br />Profissional: {{$notificacao->profissional}}
        <br />Data: {{$notificacao->dia}}
        <br />Dia da Semana: {{$notificacao->dia_semana}}
        <br />Horário: {{$notificacao->horario}}
        <br />Procedimento: {{$notificacao->procedimento}}
        @if ($notificacao->convenio)
            <br />Convênio: {{$notificacao->convenio}}
        @else
            <br />Pagamento: {{$notificacao->pagamento}}
            <br />Valor: {{$notificacao->valor}}
        @endif
    </body>
</html>
