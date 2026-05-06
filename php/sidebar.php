<?php

function añadirSideBar() {
echo '<ul class="navbar-nav bg-gradient-success sidebar sidebar-dark accordion" id="accordionSidebar">
    <div class="nav-item">
            <span class="titSideBar"><b>Administrador</b></span>
        <div id="collapseTelefonos" class="collapse show" aria-labelledby="headingTelefonos" data-parent="#accordionSidebar">
            <div class="py-2 collapse-inner rounded mx-2 d-flex flex-column">
                <a class="nav-link active" href="apartamentosTotales.php"><i class="fa-solid fa-table-list"></i> Apartamentos</a>
                <a class="nav-link" href="usuarios.php"><i class="fa-solid fa-users"></i> Usuarios</a>
                <a class="nav-link" href="reservas.php"><i class="fa-solid fa-calendar-check"></i> Reservas</a>
            </div>
        </div>
    </div>
</ul>';
}