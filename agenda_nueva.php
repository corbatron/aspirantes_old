<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalreferencias" id="referencias">Referencias</button>
<hr>
<table class="table" >
    <tr>
        <td>
        </td>
        <td  align='center' nowrap>Lunes
            <input type="checkbox" id="c_1">
        </td>
        <td align='center' nowrap>Martes
            <input type="checkbox" id="c_2">
        </td>
        <td align='center' nowrap>Mi&eacute;coles
            <input type="checkbox" id="c_3">
        </td>
        <td align='center' nowrap>Jueves
            <input type="checkbox" id="c_4">
        </td>
        <td align='center' nowrap>Viernes
            <input type="checkbox" id="c_5">
        </td>
        <td align='center' nowrap>S&aacute;bado
            <input type="checkbox" id="c_6">
        </td>
        <td align='center' nowrap>Domingo
            <input type="checkbox" id="c_7">  
        </td>
    </tr>
    <?php
    /*
     * glyphicon glyphicon-wrench
     * glyphicon glyphicon-briefcase
     * glyphicon glyphicon-book
     * glyphicon glyphicon-headphones

     *      */

    for ($var = 0; $var <= 18; $var++) {
        $hora = 5;
        $hora = $hora + $var;
        echo "<tr>";
        for ($i = 0; $i <= 7; $i++) {
		$hidden="";
            if ($i == 0) {
                $valor = $hora . " a " . ($hora + 1) . "&nbsp;Hs.";
                $align = "right";
            } else {
                $valor = "<button type='button' class='btn btn-default btn-agenda' data-toggle='tooltip' data-placement='bottom' title='Estudio fuera de la facu'  valo='0' id='" . $var . "_" . $i . "' name='" . $var . "_" . $i . "'>"
                        . "<span class='glyphicon glyphicon-book' ></span>"
                        . "</button>";
                $hidden = "<input type='hidden' value='0' id='h_" . $var . "_" . $i . "' name='i_" . $var . "_" . $i . "'></input>";
                $align = "center";
            }
            echo "<td align='" . $align . "'>" . $valor ." ".$hidden."</td>";
        }
        echo "</tr>";
    }
    ?>



</table>
<input type='hidden' name='agenda' id='agenda' value='agenda'></input>

<?php
include("modalReferencias.php");

?>
