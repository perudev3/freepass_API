<div>
    <h1>Gracias por adquirir la entrada con freepass</h1>
    <h2>{{ $invitado->lista->evento->nombre }}</h2>
    <p>Usuario: {{ $invitado->nombre }} - {{ $invitado->apellido }}</p>
    <p>Zona: {{ $invitado->lista->zona->nombre}}</p>
    <img src="{{ $invitado->lista->evento->portada_img }}" alt="">
    <p>No pierda el codigo QR (Se solicitara al ingresar)</p>
    <img src="{!!$message->embedData(QrCode::format('png')->generate($invitado->codigo_invitacion), 'QrCode.png', 'image/png')!!}">
</div>