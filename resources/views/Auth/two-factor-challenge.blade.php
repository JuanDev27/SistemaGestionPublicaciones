<h2>Verificación en dos pasos</h2>

@if ($errors->any())
    <div>
        @foreach ($errors->all() as $error)
            <p style="color:red;">{{ $error }}</p>
        @endforeach
    </div>
@endif

<form method="POST" action="{{ url('/two-factor-challenge') }}">
    @csrf
    <input type="text" name="code" placeholder="Código 2FA" autofocus>
    <input type="text" name="recovery_code" placeholder="Código de recuperación">
    <button type="submit">Verificar</button>
</form>
