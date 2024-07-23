<x-mail::message>
# Bem vindo ao nosso sistema!

Olá {{ $user->name }}, ficamos felizes por tê-lo em nosso sistema, para acessar o sistema, use a sua credencial abaixo:

<br>

Login: {{ $user->email }} <br>

Senha: secret

<x-mail::button :url="'/login'">
Fazer Login
</x-mail::button>

Saudações,<br>
{{ config('app.name') }}
</x-mail::message>
