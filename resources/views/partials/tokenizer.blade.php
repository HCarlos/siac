<!DOCTYPE html>
<html>
<body>
<form id="myForm" method="POST" action="/usuario">
    <input type="text" name="curp" id="curp">
    <button type="submit">Enviar</button>
</form>
{{--<h1>Resultado de búsqueda</h1>--}}
{{--<p>Nombre: {{ $usuario->nombre ?? '' }}</p>--}}
{{--<p>Email: {{ $usuario->email ?? ''  }}</p>--}}

<script>
    // Obtener el token CSRF desde Laravel
    fetch('/get-csrf-token')

        .then(response => response.json())
        .then(data => {
            // Crear campo oculto con el token
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = data.csrf_token;
            document.getElementById('myForm').appendChild(csrfInput);
        });

    function getCookie(name) {
        const value = `; ${document.cookie}`;
        const parts = value.split(`; ${name}=`);
        if (parts.length === 2) return parts.pop().split(';').shift();
    }

    // Agregar token al formulario
    const token = getCookie('XSRF-TOKEN');
    const form = document.querySelector('form');
    const csrfInput = document.createElement('input');
    csrfInput.type = 'hidden';
    csrfInput.name = '_token';
    csrfInput.value = token;
    form.appendChild(csrfInput);

</script>

<script>

document.getElementById('myForm').addEventListener('submit', function(e) {
e.preventDefault();
const curp = document.getElementById('curp').value;

fetch('usuario', {
method: 'POST',
headers: {
'Content-Type': 'application/json',
},
body: JSON.stringify({ curp: curp })
})
.then(response => response.json())
.then(data => {

    alert(data);
if (data.codigo === 200) {
// Mostrar datos en el HTML
document.getElementById('resultado').innerHTML = `
<p>Nombre: ${data.data.nombre}</p>
<p>Email: ${data.data.email}</p>
`;
} else {
alert(data.error);
}
})
.catch(error => console.error('Error :=> ', error));
});

</script>

</body>
</html>
