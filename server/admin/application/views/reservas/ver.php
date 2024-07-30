<script>
    function confirmarClick(id) {
        if(confirm("Está seguro de borrar esta reservación?")) {
            document.location = "/admin/calendario/resetslot/"+id;
        }

    }
</script>
<form>
<table class="table">
<tr>
        <th>Reserva actualizada el:</th>
        <td><?=date("Y/m/d h:i", $reserva->reservedAt) ;?></td>
    </tr>
    <tr>
        <th>Nombre</th>
        <td><?= $reserva->name ;?></td>
    </tr>
    <tr>
        <th>Correo</th>
        <td><?= $reserva->email  ;?></td>
    </tr>
    <tr>
        <th>Teléfono</th>
        <td><?= $reserva->phone ;?><br/>
        <a href="https://wa.me/<?= $reserva->phone ;?>">Whatsapp</a><br/>
        <a href="tel:<?= $reserva->phone ;?>">Llamar</a><br/>
        </td>
    </tr>
    <tr>
        <th>Personas</th>
        <td><?= $reserva->people ;?></td>
    </tr>
    <tr>
        <th>Idioma</th>
        <td><?= $reserva->english =="1"?"Inglés":"Español" ;?></td>
    </tr>
    <tr>
        <th>Comentarios</th>
        <td><?= $reserva->comments ;?></td>
    </tr>
    <tr>
        <th></th>
        <td></td>
    </tr>
</table>
</form>
<button class="btn btn-danger" onclick="confirmarClick(<?=$reserva->id;?>)">Liberar espacio</button>