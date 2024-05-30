/**
* @author Tarsicio Carrizales telecom.com.ve@gmail.com
*/
$(function () {
    document.getElementById("avatar_user").onchange = function(e) {
      // Creamos el objeto de la clase FileReader
      let reader = new FileReader();
      // Leemos el archivo subido y se lo pasamos a nuestro fileReader
      reader.readAsDataURL(e.target.files[0]);
      // Le decimos que cuando este listo ejecute el código interno
      reader.onload = function(){
        let preview = document.getElementById('preview');
        image = document.createElement('img');
        image.src = reader.result;
        image.style = "width:150px; height:200px; border-radius:50%; margin-right:25px;";
        preview.innerHTML = '';
        preview.append(image);        
      };
    }

    // icono para mostrar contraseña
            showPassword = document.querySelector('.show-password');
            showPassword.addEventListener('click', () => {
                // elementos input de tipo clave
                password1 = document.querySelector('#password_user');                
                if ( password1.type === "text" ) {
                    password1.type = "password"                    
                    showPassword.classList.remove('fa-eye-slash');
                } else {
                    password1.type = "text"                    
                    showPassword.classList.toggle("fa-eye-slash");
                }
            });
  });