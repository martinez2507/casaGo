let btnEliminar = document.querySelectorAll('.btn-borrar');


btnEliminar.forEach(boton => {
    boton.addEventListener('click', function() {
        let id = this.dataset.id; 
        
        console.log("El ID del apartamento a eliminar es:", id);

        alertify.confirm("Eliminar Apartamento", "¿Estás seguro de que quieres eliminar este alojamiento?",
            function() {
                $.ajax({
                     url: "./php/gestionarUnApartamento.php",
                    type: "POST",
                    data: {
                        motivo: "borrar",
                        idApartamento: id,
                    },
                    success: function(){
                        alertify.success("Apartamento borrado");
                        setTimeout(function(){
                            location.reload();
                        }, 1000);
                    },
                    error: function() {
                        alertify.error("Error al procesar la solicitud");
                    }
                });
            },
            function() {
                alertify.error('Cancelado');
            }
        );
    });
});