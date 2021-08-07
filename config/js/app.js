const formulario = document.querySelector('#formulario') || "";
const tabla = document.querySelector('#tabla') || "";
const ventanaModal = document.querySelector('#ventana-modal');
const contenidoModal = document.querySelector('#contenido-modal');
const listaProductos = document.querySelector('#lista-productos');
const pageName = window.location.pathname.split("/").pop();
const params = new URLSearchParams(location.search);
let articulosProductos = [];


class Usuario {
    loginRegistro(formData,url){
        $.ajax({
            type : "POST",
            url : `controllers/${url}.php`,
            data: formData,
            processData: false,
            contentType: false,
            cache : false,
            enctype: 'multipart/form-data',
            beforeSend: function () {},
            complete: function () {},                  
            success : function(response) {                
                const { successMessage, errores, url,tipo} = response;                                    
                if(!errores.length > 0){
                    if(tipo !== 'recuperar_contra' || tipo !== 'nueva_contra'){
                        Swal.fire({
                            icon: 'success',
                            title: successMessage,
                            confirmButtonColor: '#23a0e8',
                            confirmButtonText: 'Continuar'
                        }).then((result) => {
                            if (result.value) {
                                window.location.href = `${url}`;
                            }
                        }); 
                    }else{
                        Swal.fire({
                            icon: 'success',
                            title: successMessage,
                            confirmButtonColor: '#23a0e8',
                            confirmButtonText: 'Continuar'
                        }).then((result) => {
                            if (result.value) {
                                document.querySelector('#formulario').reset();
                            }
                        }); 
                        
                    }
                }else{
                    let msgErrores = "";
                    errores.forEach(error => {
                        msgErrores += error + '\n';
                    });

                    Swal.fire({
                        title: `${msgErrores}`,
                        icon: 'error'
                    }).then((result) => {
                        if (result.value) {
                            document.querySelector('#formulario').reset();                        
                        }
                    });
                }                
            },          
            error: function(error){                     
                console.log(error.responseText);
                Swal.fire({
                    title: 'Problemas al tratar de enviar el formulario!',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
            }
        }); 
    }
}

class Pedido {
    crudPedido (formData,action){
        $.ajax({
            type : "POST",
            url : `controllers/${action}PedidoController.php`,
            data: formData,
            processData: false,
            contentType: false,
            cache : false,
            enctype: 'multipart/form-data',
            beforeSend: function () {},
            complete: function () {},                  
            success : function(response){
                console.log(response);                            
                if(action == 'editar'){
                    const tr = document.querySelector(`#tabla-pedidos tbody tr[data-id="${id}"]`);
                } else if(action == 'borrar'){
                    document.querySelector(`#tabla-pedidos tbody tr[data-id="${response}"]`).remove();                        
                }
            },          
            error: function(error){                     
                console.log(error.responseText);
                Swal.fire({
                    title: 'Problemas al tratar de enviar el formulario!',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
            }
        });
    }
}

class Producto {
    comprarProducto (articulosProductos){
        let subTotal = 0;
        let total = 0;
        let subTotalTax = 0;
        articulosProductos.forEach((producto) => ( subTotal += parseFloat((producto.precio * producto.cantidad)),0));
        total = subTotal;
        subTotalTax = subTotal;
        const formData = new FormData();
        formData.append('productos',JSON.stringify(articulosProductos));
        formData.append('metodoPago', '1'); // 1 - Paypal
        formData.append('subTotal',subTotal);
        formData.append('subTotalTax',subTotalTax);
        formData.append('total',total);

        $.ajax({
            type : "POST",
            url : "controllers/pedidoController.php",
            data: formData,
            processData: false,
            contentType: false,
            cache : false,
            enctype: 'multipart/form-data',
            beforeSend: function () {},
            complete: function () {},                  
            success : function(response){
                console.log(response);
                Swal.fire({
                    icon: 'success',
                    html: '<p>Compra realizada con éxito, se le enviará un correo para dar seguimiento</p>',
                    confirmButtonColor: '#23a0e8',
                    confirmButtonText: 'Continuar'
                }).then((result) => {
                    if (result.value) {
                        vaciarCarrito(); 
                        window.location.href = "historial";
                    }
                });                                               
            },          
            error: function(error){                     
                console.log(error.responseText);
                Swal.fire({
                    title: 'Problemas al tratar de enviar el formulario!',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
            }
        });
    }

    borrarProducto (e){
        
        if(e.target.classList.contains('borrar-producto')){        
            const productoId = 
            e.target.parentElement.parentElement.getAttribute('data-id') || 
            e.target.parentElement.parentElement.parentElement.getAttribute('data-id') || 
            e.target.parentElement.parentElement.parentElement.parentElement.getAttribute('data-id');

            articulosProductos = articulosProductos.filter(producto => producto.idProducto !== productoId);
            setProductosSession(); 
            document.querySelector(`#tabla-carrito tbody tr[data-id="${productoId}"]`).remove();
            const ui = new UI();                   
            ui.carritoHTML();
        }
    }

    crudProducto (formData,action){
        $.ajax({
            type : "POST",
            url : "controllers/productoController.php",
            data: formData,
            processData: false,
            contentType: false,
            cache : false,
            enctype: 'multipart/form-data',
            beforeSend: function () {},
            complete: function () {},                  
            success : function(response){
                console.log(response);
                const { id, nombre, precio, marca, imagen } = response; 
                const producto = new Producto();
                if (action == 'agregar') {
                    const tr = document.createElement('tr');
                    tr.dataset.id = id;
                    const tdImagen = document.createElement('td');
                    tdImagen.classList.add('td-imagen');
                    tdImagen.innerHTML = `<img src="config/img/${imagen}" alt="${nombre}"> `;
                    const tdNombre = document.createElement('td');
                    tdNombre.classList.add('td-nombre');
                    tdNombre.textContent = nombre;

                    const tdPrecio = document.createElement('td');
                    tdPrecio.classList.add('td-precio');
                    tdPrecio.textContent = precio;

                    const tdMarca = document.createElement('td');
                    tdMarca.classList.add('td-marca');
                    tdMarca.textContent = marca;

                    const tdEditar = document.createElement('td');
                    tdEditar.classList.add('td-editar');
                    const btnEditar = document.createElement('button');  
                    btnEditar.classList.add('editar-producto', 'btn', 'btn-info', 'mr-2');            
                    btnEditar.innerHTML = `Editar 
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>`;
                    btnEditar.onclick = (e) => {
                        e.preventDefault();                        
                        producto.modalEditar(e);
                    };
                    tdEditar.appendChild(btnEditar);

                    const tdBorrar = document.createElement('td');
                    tdBorrar.classList.add('td-borrar');  
                    const btnBorrar = document.createElement('button');  
                    btnBorrar.classList.add('borrar-producto', 'btn', 'btn-danger');                
                    btnBorrar.innerHTML = `Eliminar 
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>`;
                    btnBorrar.onclick = (e) => {
                        e.preventDefault();
                        const formData = new FormData();
                        const action = 'borrar';
                        formData.append('data-id',id);
                        formData.append('data-action',action);
                        producto.crudProducto(formData,action);
                    };
                    tdBorrar.appendChild(btnBorrar);

                    tr.append(tdImagen);
                    tr.append(tdNombre);
                    tr.append(tdPrecio);
                    tr.append(tdMarca);
                    tr.append(tdEditar);
                    tr.append(tdBorrar);
                    document.querySelector('#tabla-productos tbody').appendChild(tr);
                    ventanaModal.style.display = "none";
                    limpiarHTML(contenidoModal);
                } else if(action == 'editar'){
                    const tr = document.querySelector(`#tabla-productos tbody tr[data-id="${id}"]`);
                    tr.querySelector('.td-imagen img').setAttribute('src',`config/img/${imagen}`);
                    tr.querySelector('.td-nombre').textContent = nombre;
                    tr.querySelector('.td-precio').textContent = precio;
                    ventanaModal.style.display = "none";
                    limpiarHTML(contenidoModal);
                } else if(action == 'borrar'){
                    document.querySelector(`#tabla-productos tbody tr[data-id="${response}"]`).remove();                        
                }
            },          
            error: function(error){                     
                console.log(error.responseText);
                Swal.fire({
                    title: 'Problemas al tratar de enviar el formulario!',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
            }
        });
    }

    modalAgregar (e){
        e.preventDefault();
        const contenedor = document.createElement('form');
        contenedor.innerHTML = `
            <h2> Agregar Producto </h2>
            <div class="form-group">
                <label>Nombre</label>        
                <input class="form-control" id="nombre-producto" type="text">
            </div>
            <div class="form-group">
                <label>Precio</label> 
                <input class="form-control" id="precio-producto" type="number">
            </div>    
            <div class="form-group">
                <label>Selecciona una imagen</label>
                <input class="form-control-file" type="file" name="foto" id="foto">
            </div>
        `;
        const btnGroup = document.createElement('div');
        btnGroup.classList.add('btn-group','blocks');
        btnGroup.dataset.toggle = 'buttons';
    
        const btnCerrar = document.createElement('button');
        btnCerrar.classList.add('btn','btn-danger','mr-1');
        btnCerrar.textContent = 'Cerrar';
        btnCerrar.setAttribute('type','button')
        btnCerrar.addEventListener('click', e =>{
            e.preventDefault();
            ventanaModal.style.display = "none";
            limpiarHTML(contenidoModal);
        });
    
        btnGroup.appendChild(btnCerrar);
    
        const btnAgregar = document.createElement('button');
        btnAgregar.classList.add('btn','btn-info');
        btnAgregar.textContent = 'Agregar';
    
        btnAgregar.addEventListener('click', e => {
            e.preventDefault();
            let nombre = contenedor.querySelector('#nombre-producto').value;
            let precio = contenedor.querySelector('#precio-producto').value;
            let file = contenedor.querySelector('#foto').files;

            if(nombre === '' || precio === ''){
                Swal.fire({
                    title: 'Por favor rellene todos los campos!',
                    icon: 'warning',
                    confirmButtonText: 'Aceptar',
                    confirmButtonColor: '#45bbff'
                });
                return;
            }else if(!file.length > 0){                
                Swal.fire({
                    title: 'Por favor seleccione una imagen!',
                    icon: 'warning',
                    confirmButtonText: 'Aceptar',
                    confirmButtonColor: '#45bbff'
                });
                return;                
            }
    
            const formData = new FormData();
            const action = 'agregar';
            formData.append('data-nombre',nombre);
            formData.append('data-precio',precio);
            formData.append('data-action',action);
            formData.append('files',file[0]); 
            const producto = new Producto();
            producto.crudProducto(formData,action);
        });
        btnGroup.appendChild(btnAgregar);
    
        contenedor.appendChild(btnGroup);
        
        contenidoModal.appendChild(contenedor);									
        ventanaModal.style.display = "flex";
    }

    modalEditar (e) {
        e.preventDefault();
        const id = 
        e.target.parentElement.parentElement.getAttribute('data-id') || 
        e.target.parentElement.parentElement.parentElement.getAttribute('data-id') || 
        e.target.parentElement.parentElement.parentElement.parentElement.getAttribute('data-id');
        if(id == null) {
            Swal.fire({
                title: 'Parece que hay un error, intente recargar la página!',
                icon: 'error',
                confirmButtonText: 'Aceptar'
            }).then((result) => {
                if (result.isConfirmed) {
                    location.reload;
                }
            });
            return;
        }
        const datos = getDatos(id,'getProducto');
        const {nombre, precio, marca} = datos; 
        const contenedor = document.createElement('form');
        
        contenedor.innerHTML = `
            <h2>Editar Producto</h2>
            <div class="form-group">
                <label>Nombre</label>        
                <input class="form-control" id="nombre-producto" type="text" value="${nombre}">
            </div>
            <div class="form-group">
                <label>Precio</label> 
                <input class="form-control" id="precio-producto" type="number" value="${precio}">
            </div>
            <div class="form-group">
                <label>Selecciona una imagen</label>
                <input class="form-control-file" type="file" name="foto" id="foto">
            </div>    

        `;
        // SELECT CONCAT(
        //     '[', 
        //     GROUP_CONCAT(JSON_OBJECT('id', id,'nombre', nombre)),
        //     ']' 
        // )  AS marcas 
        // FROM marcas
        // const select = document.createElement('select');
        // let option = document.createElement('option');
        // option.textContent = 'A';
        // select.appendChild(option);
        // contenedor.appendChild(select);

        const btnGroup = document.createElement('div');
        btnGroup.classList.add('btn-group','blocks');
        btnGroup.dataset.toggle = 'buttons';
    
        const btnCerrar = document.createElement('button');
        btnCerrar.classList.add('btn','btn-danger','mr-1');
        btnCerrar.textContent = 'Cerrar';
        btnCerrar.setAttribute('type','button')
        btnCerrar.addEventListener('click', e =>{
            e.preventDefault();
            ventanaModal.style.display = "none";
            limpiarHTML(contenidoModal);
        });
    
        btnGroup.appendChild(btnCerrar);
    
        const btnEditar = document.createElement('button');
        btnEditar.classList.add('btn','btn-info');
        btnEditar.textContent = 'Guardar';
    
        btnEditar.addEventListener('click', e => {
            e.preventDefault();
            let nombre = contenedor.querySelector('#nombre-producto').value;
            let precio = contenedor.querySelector('#precio-producto').value;
            let file = contenedor.querySelector('#foto').files;
   
            if(nombre === '' || precio === ''){
                Swal.fire({
                    title: 'Por favor rellene todos los campos!',
                    icon: 'warning',
                    confirmButtonText: 'Aceptar',
                    confirmButtonColor: '#45bbff'
                });
                return;
            }else if(!file.length > 0){                
                Swal.fire({
                    title: 'Por favor seleccione una imagen!',
                    icon: 'warning',
                    confirmButtonText: 'Aceptar',
                    confirmButtonColor: '#45bbff'
                });
                return;                
            }

            const formData = new FormData();
            const action = 'editar';
            formData.append('data-id',id);
            formData.append('data-nombre',nombre);
            formData.append('data-precio',precio);
            formData.append('data-action',action);       
            formData.append('files',file[0]); 
            const producto = new Producto();
            producto.crudProducto(formData,action);
        });

        btnGroup.appendChild(btnEditar);
    
        contenedor.appendChild(btnGroup);
        
        contenidoModal.appendChild(contenedor);									
        ventanaModal.style.display = "flex";
    }
}

class UI {
    showButton(e){
        const div = e.target.parentElement;
        let inputForm = div.querySelector('.input-form');
        if(inputForm.getAttribute('type') === 'password'){
            e.target.classList.remove('fa-eye');
            e.target.classList.add('fa-eye-slash');
            inputForm.setAttribute('type','text');
        }else{
            e.target.classList.remove('fa-eye-slash');
            e.target.classList.add('fa-eye');
            inputForm.setAttribute('type','password');
        }
    }

    carritoHTML (){
        // limpiarHTML(document.querySelector('#tabla-carrito tbody'));
        articulosProductos.forEach(producto => {
            const {idProducto,titulo,precio,cantidad} = producto;
            const row = document.createElement('tr');

            row.innerHTML = `
                <td>${idProducto}</td>
                <td>${titulo}</td>
                <td>${precio}</td>
                <td>${cantidad}</td>
                <td><a href="#" class="borrar-producto btn btn-danger" data-id="${idProducto}">X</a></td>
            `;
            row.querySelector('.borrar-producto').addEventListener('click', e => {
                e.preventDefault();
                const producto = new Producto();
                producto.borrarProducto(e);
            });
            // document.querySelector('#tabla-carrito tbody').appendChild(row);
        });
    }
}
const ui = new UI();   
eventListeners();

function eventListeners(){

    document.addEventListener('DOMContentLoaded', () => {
        setProductosSession('get');
        const ui = new UI();                   
        ui.carritoHTML();
    });

    if(document.querySelector('#vaciar-carrito') !== null){ 
        document.querySelector('#vaciar-carrito').addEventListener('click', (e) => {
            e.preventDefault();
            vaciarCarrito();
        });
    }


    if(document.querySelector('#tabla-carrito') != null){
        const tabla = document.querySelector('#tabla-carrito tbody');
        [...tabla.querySelectorAll('.borrar-producto')].forEach(boton => {
            boton.addEventListener('click', e => {
                e.preventDefault();
                const producto = new Producto();
                producto.borrarProducto(e);
            });
        })

    }

    if(listaProductos !== null){
        let buttonsAgregar = [...listaProductos.querySelectorAll('.agregar-carrito')];
        buttonsAgregar.forEach(boton => {
            boton.addEventListener('click', e => {
                agregarProducto(e);
            });
        });

        let buttonsComprarAhora = [...listaProductos.querySelectorAll('.comprar-ahora')];
        buttonsComprarAhora.forEach(boton => {
            boton.addEventListener('click', e => {
                comprarAhora(e);
            });
        });           
    }

    if(document.querySelector('#comprar-carrito') !== null){
        document.querySelector('#comprar-carrito').addEventListener('click',e => {
            e.preventDefault();
            new Producto().comprarProducto(articulosProductos);
        });
    }

    if(document.querySelector('#realizar-pago') !== null){
        document.querySelector('#realizar-pago').addEventListener('click',e => {
            e.preventDefault();
            if(articulosProductos.length === 0 ){
                Swal.fire({
                    title: 'Por favor agregue al menos un producto al carrito!',
                    icon: 'warning',
                    confirmButtonText: 'Aceptar',
                    confirmButtonColor: '#45bbff'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = `login`;
                    }
                });
            }else{
                window.location.href = "pagos";
            }
        });
    }

    if(formulario !== "" && formulario.querySelector('#send') !== null){
        formulario.querySelector('#send').addEventListener('click',loginRegistro);    
    }

    if(formulario !== "" && formulario.querySelectorAll('.show-button') != null ){
        let buttons = [...formulario.querySelectorAll('.show-button')];
        buttons.forEach(button => {
            button.addEventListener('click', (e) => {                            
                ui.showButton(e);
            });
        });        
    }

    document.addEventListener('DOMContentLoaded', () => {
        if (document.querySelector('#add-producto') !== null){
            document.querySelector('#add-producto').addEventListener('click',e => (new Producto).modalAgregar(e));            
        }

        [...document.querySelectorAll('#tabla-productos tbody tr')].forEach((e) => {
            const id = parseInt(e.getAttribute('data-id'));
            e.querySelector('.editar-producto').addEventListener('click', e => {
                e.preventDefault();
                const producto = new Producto();
                producto.modalEditar(e);
            });

            e.querySelector('.borrar-producto').addEventListener('click', e => {
                e.preventDefault();
                const formData = new FormData();
                const action = 'borrar';
                formData.append('data-id',id);
                formData.append('data-action',action);
                const producto = new Producto();
                producto.crudProducto(formData,action);
            });
        });   
        
        [...document.querySelectorAll('#tabla-pedidos tbody tr')].forEach((e) => {
            const id = parseInt(e.getAttribute('data-id'));
            // e.querySelector('.editar-pedido').addEventListener('click', e => {
            //     e.preventDefault();
            //     const pedido = new Pedido();
            //     // pedido.modalEditar(e);
            // });

            e.querySelector('.borrar-pedido').addEventListener('click', e => {
                e.preventDefault();
                const formData = new FormData();
                const action = 'borrar';
                formData.append('data-id',id);
                formData.append('data-action',action);
                const producto = new Pedido();
                producto.crudPedido(formData,action);
            });
        }); 

    });
}

function loginRegistro (e){
    e.preventDefault();
    const dataForm = e.target.parentElement.parentElement.getAttribute('data-form');
    const formData = new FormData();
    formData.append('dataForm',dataForm);

    let url = (dataForm == 'recuperar_contra' || dataForm == 'nueva_contra') ? 'correoController' : 'loginRegistro';
    if (dataForm == 'login') {
        let usuarioCorreo = formulario.querySelector('#usuario-correo').value;
        let pass = formulario.querySelector('#password').value;
        if (usuarioCorreo === "" || pass === ""){
            Swal.fire({
                title: 'Por favor rellene todos los campos!',
                icon: 'warning',
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '#45bbff'
            });
            return;
        }
        formData.append('usuario',usuarioCorreo);
        formData.append('pass',pass);
       
    } else if(dataForm == 'register') {
        let usuario = formulario.querySelector('#usuario').value;
        let correo = formulario.querySelector('#correo').value;
        let pass = formulario.querySelector('#password').value;
        let pass2 = formulario.querySelector('#password2').value;

        if (usuario === "" || correo === "" || pass === "" || pass2 === "" ){
            Swal.fire({
                title: 'Por favor rellene todos los campos!',
                icon: 'warning',
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '#45bbff'
            });
            return;
        }

        formData.append('usuario',usuario);
        formData.append('correo',correo);
        formData.append('pass',pass);
        formData.append('pass2',pass2);
        
    } else if(dataForm == 'recuperar_contra'){
        let correo = formulario.querySelector('#correo').value;
        if (correo === ""){
            Swal.fire({
                title: 'Por favor ingrese el correo!',
                icon: 'warning',
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '#45bbff'
            });
            return;
        }
        if(!isValidEmail(correo)){
            Swal.fire({
                title: 'Por favor introduzca un correo valido!',
                icon: 'warning',
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '#45bbff'
            });
            return;
        }
        formData.append('correo',correo);
    }else if(dataForm == 'nueva_contra'){
        let params = new URLSearchParams(location.search);
        const correo = params.get('email');
        let pass = formulario.querySelector('#password').value;
        let pass2 = formulario.querySelector('#password2').value;
        if (pass === "" || pass2 === ""){
            Swal.fire({
                title: 'Por favor rellene todos los campos!',
                icon: 'warning',
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '#45bbff'
            });
            return;
        } else if (pass != pass2){
            Swal.fire({
                title: 'Las contraseñas no son iguales!',
                icon: 'warning',
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '#45bbff'
            });
            return
        }
        formData.append('correo',correo);
        formData.append('pass',pass);
        formData.append('pass2',pass2);
    } else{
        Swal.fire({
            title: 'Problemas al tratar de enviar el formulario, recargue la pagina!',
            icon: 'error',
            confirmButtonText: 'Aceptar'
        });
        return false;
    }

    const usuario = new Usuario();
    usuario.loginRegistro(formData,url);
}

function getDatos (id,action) {
    const formData = new FormData();
    formData.append('id',id);
    formData.append('data-action',action);
    const datos = 
        $.ajax({
            async : false,
            type : "POST",
            url : "controllers/productoController.php",
            data: formData ,
            processData: false,
            contentType: false,
            cache : false,
            enctype: 'multipart/form-data',
            beforeSend: function () {},
            complete: function () {},                  
            success : function(response){},          
            error: function(error){                     
                Swal.fire({
                    title: 'Problemas al tratar de enviar el formulario!',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
            }
        }).responseJSON;
    ;
    return datos;
}

function comprarAhora(e){
    e.preventDefault();
    if(e.target.classList.contains('comprar-ahora')) {
        const producto = e.target.parentElement.parentElement;
        const productos = leerDatosProducto(producto);
        window.location.href = "pagos";
    }
}

function agregarProducto(e){
    e.preventDefault();
    if(e.target.classList.contains('agregar-carrito')) {
        const producto = e.target.parentElement.parentElement;        
        const productos = leerDatosProducto(producto);
        ui.carritoHTML();
    }
}

function leerDatosProducto(producto){
    
    const infoProducto = {
        idProducto : producto.parentElement.getAttribute('data-id'),
        titulo : producto.querySelector('h4').textContent,
        precio : producto.querySelector('.precio').getAttribute('data-precio'),
        imagen: producto.parentElement.querySelector('.imagen-producto').src,
        cantidad: 1,
        idTipoProducto : 1
    }

    const existe = articulosProductos.some(producto => producto.idProducto === infoProducto.idProducto); //Validar si existen el producto dentro del carrito
    if(existe){ //Valida si existe dentro del articulosProductos
        const productos = articulosProductos.map(producto => {
            if(producto.idProducto === infoProducto.idProducto){
                producto.cantidad++;
                return producto; //retorna objeto actualizado
            }else{
                return producto; // retorna objetos que no son duplicados
            }
        });
        articulosProductos = [...productos]
    }else{
        articulosProductos = [...articulosProductos,infoProducto]; 
    }
    setProductosSession();
    console.log(articulosProductos);
    return articulosProductos;
}

function setProductosSession(action = 'set'){
    const formData = new FormData();
    formData.append('productos',JSON.stringify(articulosProductos));
    formData.append('action',action);
    $.ajax({
        type : "POST",
        url : `controllers/setProductosSessionController.php`,
        data: formData,
        processData: false,
        contentType: false,
        cache : false,
        enctype: 'multipart/form-data',
        beforeSend: function () {},
        complete: function () {},                  
        success : function(response) {                
            articulosProductos = [...response];                                          
        },          
        error: function(error){                     
            console.log(error.responseText);
            Swal.fire({
                title: 'Problemas al tratar de enviar el formulario!',
                icon: 'error',
                confirmButtonText: 'Aceptar'
            });
        }
    }); 
}

function vaciarCarrito(){
    articulosProductos = [];
    setProductosSession();
    limpiarHTML(document.querySelector('#tabla-carrito tbody'));
}

function limpiarHTML(contenedor) {
    if(contenedor !== null){
        while (contenedor.firstChild) {
            contenedor.removeChild(contenedor.firstChild);
        }
    }
}

function isValidEmail(mail) { 
    return /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/.test(mail); 
}