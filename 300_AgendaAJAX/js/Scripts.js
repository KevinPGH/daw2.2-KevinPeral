
// TODO Quedaría pendiente poner un timer para actualizar lo local si actualizan el servidor. Una solución óptima sería poner timestamp de modificación en la tabla y pedir categoriaObtenerModificadasDesde(timestamp), donde timestamp es la última vez que he pedido algo.



window.onload = function () {
    inicializarCategorias();
    inicializarPersonas();
}

var divCategoriasDatos;
var inputCategoriaNombre;

var divPersonasDatos;
var inputPersonaNombre;
var inputPersonaApellidos;



// ---------- VARIOS DE BASE/UTILIDADES ----------

function notificarUsuario(texto) {
    // TODO En lugar del alert, habría que añadir una línea en una zona de notificaciones, arriba, con un temporizador para que se borre solo en ¿5? segundos.
    alert(texto);
}

function llamadaAjax(url, parametros, manejadorOK, manejadorError) {
    //TODO PARA DEPURACIÓN: alert("Haciendo ajax a " + url + "\nCon parámetros " + parametros);

    var request = new XMLHttpRequest();

    request.open("POST", url);
    request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    request.onreadystatechange = function() {
        if (this.readyState == 4 && request.status == 200) {
            manejadorOK(request.responseText);
        }
        if (manejadorError != null && request.readyState == 4 && this.status != 200) {
            manejadorError(request.responseText);
        }
    };

    request.send(parametros);
}

function extraerId(texto) {
    return texto.split('-')[1];
}

function objetoAParametrosParaRequest(objeto) {
    // Esto convierte un objeto JS en un listado de clave1=valor1&clave2=valor2&clave3=valor3
    return new URLSearchParams(objeto).toString();
}

function debug() {
    // Esto es útil durante el desarrollo para programar el disparado de acciones concretas mediante un simple botón.
}



// ---------- MANEJADORES DE EVENTOS / COMUNICACIÓN CON PHP ----------

function inicializarCategorias() {
    divCategoriasDatos = document.getElementById("categoriasDatos");
    inputCategoriaNombre = document.getElementById("categoriaNombre");

    document.getElementById('btnCategoriaCrear').addEventListener('click', clickCategoriaCrear);

    llamadaAjax("CategoriaObtenerTodas.php", "",
        function(texto) {
            var categorias = JSON.parse(texto);

            for (var i=0; i<categorias.length; i++) {
                // No se fuerza la ordenación, ya que PHP nos habrá dado los elementos en orden correcto y sería una pérdida de tiempo.
                domCategoriaInsertar(categorias[i], false);
            }
        }
    );
}

function clickCategoriaCrear() {
    inputCategoriaNombre.disabled = true;

    llamadaAjax("CategoriaCrear.php", "nombre=" + inputCategoriaNombre.value,
        function(texto) {
            // Se re-crean los datos por si han modificado/normalizado algún valor en el servidor.
            var categoria = JSON.parse(texto);

            // Se fuerza la ordenación, ya que este elemento podría no quedar ordenado si se pone al final.
            domCategoriaInsertar(categoria, true);

            inputCategoriaNombre.value = "";
            inputCategoriaNombre.disabled = false;
        },
        function(texto) {
            notificarUsuario("Error Ajax al crear: " + texto);
            inputCategoriaNombre.disabled = false;
        }
    );
}

function blurCategoriaModificar(input) {
    let divCategoria = input.parentElement.parentElement;
    let id = extraerId(divCategoria.id);
    let nombre = input.value;

    let categoria = { "id":  id, "nombre": nombre};

    llamadaAjax("CategoriaActualizar.php", objetoAParametrosParaRequest(categoria),
        function(texto) {
            if (texto != "null") {
                // Se re-crean los datos por si han modificado/normalizado algún valor en el servidor.
                categoria = JSON.parse(texto);
                domCategoriaModificar(categoria);
            } else {
                alert("Error Ajax al modificar: " + texto);
            }
        },
        function(texto) {
            alert("Error Ajax al modificar: " + texto);
        }
    );
}

function clickCategoriaEliminar(id) {
    llamadaAjax("CategoriaEliminar.php", "id="+id,
        function(texto) {
            var categoria = JSON.parse(texto);
            domCategoriaEliminar(id);
        },
        function(texto) {
            alert("Error Ajax al eliminar: " + texto);
        }
    );
}


function inicializarPersonas() {
    divPersonasDatos = document.getElementById("personasDatos");
    inputPersonaNombre = document.getElementById("personaNombre");
    inputPersonaApellidos = document.getElementById("personaApellidos");

    document.getElementById('btnPersonaCrear').addEventListener('click', clickPersonaCrear);

    llamadaAjax("PersonaObtenerTodas.php", "",
        function(texto) {
            var personas = JSON.parse(texto);

            for (var i=0; i<personas.length; i++) {
                // No se fuerza la ordenación, ya que PHP nos habrá dado los elementos en orden correcto y sería una pérdida de tiempo.
                domPersonaInsertar(personas[i], false);
            }
        }
    );
}

function clickPersonaCrear() {
    inputPersonaNombre.disabled = true;
    inputPersonaApellidos.disabled = true

    llamadaAjax("PersonaCrear.php", "nombre=" + inputPersonaNombre.value + "&&apellidos=" + inputPersonaApellidos.value,
        function(texto) {
            // Se re-crean los datos por si han modificado/normalizado algún valor en el servidor.
            var persona = JSON.parse(texto);

            // Se fuerza la ordenación, ya que este elemento podría no quedar ordenado si se pone al final.
            domPersonaInsertar(persona, true);

            inputPersonaNombre.value = "";
            inputPersonaNombre.disabled = false;
            inputPersonaApellidos.value = "";
            inputPersonaApellidos.disabled = false;
        },
        function(texto) {
            notificarUsuario("Error Ajax al crear: " + texto);
            inputPersonaNombre.disabled = false;
            inputPersonaApellidos.disabled = false;
        }
    );
}

function blurPersonaModificar(input) {
    let divPersona = input.parentElement.parentElement;
    let id = extraerId(divPersona.id);
    let nombre = input.value;
    let persona = { "id":  id, "nombre": nombre};

    llamadaAjax("PersonaActualizar.php", objetoAParametrosParaRequest(persona),
        function(texto) {
            if (texto != "null") {
                // Se re-crean los datos por si han modificado/normalizado algún valor en el servidor.
                persona = JSON.parse(texto);
                domPersonaModificar(persona);
            } else {
                alert("Error Ajax al modificar: " + texto);
            }
        },
        function(texto) {
            alert("Error Ajax al modificar: " + texto);
        }
    );
}

function clickPersonaEliminar(id) {
    llamadaAjax("PersonaEliminar.php", "id="+id,
        function(texto) {
            var persona = JSON.parse(texto);
            domPersonaEliminar(id);
        },
        function(texto) {
            alert("Error Ajax al eliminar: " + texto);
        }
    );
}



// ---------- GESTIÓN DEL DOM CATEGORÍAS----------

function domCategoriaCrearDiv(categoria) {
    let nombreInput = document.createElement("input");
    nombreInput.setAttribute("type", "text");
    nombreInput.setAttribute("value", categoria.nombre);
    nombreInput.setAttribute("onblur", "blurCategoriaModificar(this); return false;");
    let nombreDiv = document.createElement("div");
    nombreDiv.appendChild(nombreInput);

    let eliminarImg = document.createElement("img");
    eliminarImg.setAttribute("src", "img/Eliminar.png");
    eliminarImg.setAttribute("onclick", "clickCategoriaEliminar(" + categoria.id + "); return false;");
    let eliminarDiv = document.createElement("div");
    eliminarDiv.appendChild(eliminarImg);

    let divCategoria = document.createElement("div");
    divCategoria.setAttribute("id", "categoria-" + categoria.id);
    divCategoria.appendChild(nombreDiv);
    divCategoria.appendChild(eliminarDiv);

    return divCategoria;
}

function domCategoriaObtenerDiv(pos) {
    let div = divCategoriasDatos.children[pos];
    return div;
}

function domCategoriaObtenerObjeto(pos) {
    let divCategoria = domCategoriaObtenerDiv(pos);
    let divNombre = divCategoria.children[0];
    let input = divNombre.children[0];

    return { "id":  extraerId(divCategoria.id), "nombre": input.value}; // Devolvemos un objeto recién creado con los datos que hemos obtenido.
}

function domCategoriaEjecutarInsercion(pos, categoria) {
    let divReferencia = domCategoriaObtenerDiv(pos);
    let divNuevo = domCategoriaCrearDiv(categoria);

    divCategoriasDatos.insertBefore(divNuevo, divReferencia);
}

function domCategoriaInsertar(categoriaNueva, enOrden=false) {
    // Si piden insertar en orden, se buscará su lugar. Si no, irá al final.
    if (enOrden) {
        for (let pos = 0; pos < divCategoriasDatos.children.length; pos++) {
            let categoriaActual = domCategoriaObtenerObjeto(pos);

            if (categoriaNueva.nombre.localeCompare(categoriaActual.nombre) == -1) {
                // Si la categoría nueva va ANTES que la actual, este es el punto en el que insertarla.
                domCategoriaEjecutarInsercion(pos, categoriaNueva);
                return;
            }
        }
    }

    domCategoriaEjecutarInsercion(divCategoriasDatos.children.length, categoriaNueva);
}

function domCategoriaLocalizarPosicion(id) {
    var trs = divCategoriasDatos.children;

    for (var pos=0; pos < divCategoriasDatos.children.length; pos++) {
        let categoriaActual = domCategoriaObtenerObjeto(pos);

        if (categoriaActual.id == id) return (pos);
    }

    return -1;
}

function domCategoriaEliminar(id) {
    domCategoriaObtenerDiv(domCategoriaLocalizarPosicion(id)).remove();
}

function domCategoriaModificar(categoria) {
    domCategoriaEliminar(categoria.id);

    // Se fuerza la ordenación, ya que este elemento podría no quedar ordenado si se pone al final.
    domCategoriaInsertar(categoria, true);
}



// ---------- GESTIÓN DEL DOM PERSONAS ----------

function domPersonaCrearDiv(persona) {
    let nombreInput = document.createElement("input");
    nombreInput.setAttribute("type", "text");
    nombreInput.setAttribute("value", persona.nombre);
    nombreInput.setAttribute("onblur", "blurPersonaModificar(this); return false;");
    let nombreDiv = document.createElement("div");
    nombreDiv.appendChild(nombreInput);

    let apellidoInput = document.createElement("input");
    apellidoInput.setAttribute("type", "text");
    apellidoInput.setAttribute("value", persona.apellidos);
    apellidoInput.setAttribute("onblur", "blurPersonaModificar(this); return false;");
    let apellidoDiv = document.createElement("div");
    apellidoDiv.appendChild(apellidoInput);


    let eliminarImg = document.createElement("img");
    eliminarImg.setAttribute("src", "img/Eliminar.png");
    eliminarImg.setAttribute("onclick", "clickPersonaEliminar(" + persona.id + "); return false;");
    let eliminarDiv = document.createElement("div");
    eliminarDiv.appendChild(eliminarImg);

    let divPersona = document.createElement("div");
    divPersona.setAttribute("id", "persona-" + persona.id);
    divPersona.appendChild(nombreDiv);
    divPersona.appendChild(apellidoDiv);
    divPersona.appendChild(eliminarDiv);

    return divPersona;
}

function domPersonaObtenerDiv(pos) {
    let div = divPersonasDatos.children[pos];
    return div;
}

function domPersonaObtenerObjeto(pos) {
    let divPersona = domPersonaObtenerDiv(pos);
    let divNombre = divPersona.children[0];
    let divApellido = divPersona.children[1];
    let inputNombre = divNombre.children[0];
    let inputApellido = divApellido.children[0];

    return { "id":  extraerId(divPersona.id), "nombre": inputNombre.value, "apellidos" : inputApellido.value}; // Devolvemos un objeto recién creado con los datos que hemos obtenido.
}

function domPersonaEjecutarInsercion(pos, persona) {
    let divReferencia = domPersonaObtenerDiv(pos);
    let divNuevo = domPersonaCrearDiv(persona);

    divPersonasDatos.insertBefore(divNuevo, divReferencia);
}

function domPersonaInsertar(personaNueva, enOrden=false) {
    // Si piden insertar en orden, se buscará su lugar. Si no, irá al final.
    if (enOrden) {
        for (let pos = 0; pos < divPersonasDatos.children.length; pos++) {
            let personaActual = domPersonaObtenerObjeto(pos);

            if (personaNueva.nombre.localeCompare(personaActual.nombre) == -1) {
                // Si la categoría nueva va ANTES que la actual, este es el punto en el que insertarla.
                domPersonaEjecutarInsercion(pos, personaNueva);
                return;
            }
        }
    }

    domPersonaEjecutarInsercion(divPersonasDatos.children.length, personaNueva);
}

function domPersonaLocalizarPosicion(id) {
    var trs = divPersonasDatos.children;

    for (var pos=0; pos < divPersonasDatos.children.length; pos++) {
        let personaActual = domPersonaObtenerObjeto(pos);

        if (personaActual.id == id) return (pos);
    }

    return -1;
}

function domPersonaEliminar(id) {
    domPersonaObtenerDiv(domPersonaLocalizarPosicion(id)).remove();
}

function domPersonaModificar(persona) {
    domPersonaEliminar(persona.id);

    // Se fuerza la ordenación, ya que este elemento podría no quedar ordenado si se pone al final.
    domPersonaInsertar(persona, true);
}