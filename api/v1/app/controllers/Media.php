<?php

require '../app/models/Medio.php';

class Media
{
    function __construct(){
    }

    //GET
    function getAllMedia(){
        echo "Hola desde el metodo getAllMedia() de MEDIA Controller <br>";
        //Lectura del json completo
        $json = file_get_contents('../data/media.json', true);
        echo "Los datos almacenados son: <br>";
        echo $json. "<br>";
    }
    function getMediaById($id){
        echo "Hola desde el metodo getMediaById() de MEDIA Controller <br>";
        echo "El ID del MEDIO es " . $id . "<br>";
        //Lectura del json para el id
        $json = file_get_contents('../data/media.json', true);
        $media = json_decode($json);
        $medioBuscar = null;
        foreach ($media as $medio) {
            if ($medio->id == $id) {
                $medioBuscar = $medio;
            }
        }
        if ($medioBuscar == null) {
            echo "El MEDIO con ID " . $id . " NO EXISTE <br>";
        } else {
            $myJSON = json_encode($medioBuscar, JSON_PRETTY_PRINT);
            echo "El MEDIO con ID " . $id . " ES: <br>";
            echo $myJSON. "<br>";
        }
    }
    //POST
    public function createMedia($data){
        echo "Hola desde el metodo createMedia() de MEDIA Controller <br>";
        echo "Los datos del MEDIO son " . json_encode($data) . "<br>";
        //Añadir los datos al json si són válidos o indicar que no lo son
        $mydata= json_encode($data);
        $nuevomedio = json_decode($mydata);
        $id = $nuevomedio->id;
        $json = file_get_contents('../data/media.json', true);
        $media = json_decode($json);
        $existe = false;
        foreach ($media as $medio) {
            if ($medio->id == $id) {
                $existe = true;
            }
        }
        if ($existe != false) {
            echo "El MEDIO con ID " . $id . " YA EXISTE. NO SE CREA <br>";
        } else {
            echo "Procedo a dar de alta el MEDIO con ID " . $id . "<br>";
            array_push($media, $nuevomedio);
            $myJSON = json_encode($media, JSON_PRETTY_PRINT);
            echo $myJSON;
            $file = '../data/media.json';
            $fp = fopen($file, "w");
            fwrite($fp, $myJSON);
            fclose($fp);
        }
    }
    //PUT
    public function updateMedia($id, $data){
        echo "Hola desde el metodo updateMedia() de MEDIA Controller <br>";
        echo "El dato a actualizar del MEDIO con ID ".$id." es: " . json_encode($data) . "<br>";
        //Actualizar los datos del id del json si existe y si los datos a actualizar son válidos 
        //o indicar que no lo son
        $mydata= json_encode($data);
        $nuevocampo = json_decode($mydata,true);
        $json = file_get_contents('../data/media.json', true);
        $media = json_decode($json);
        $medioActualizar = null;
        foreach ($media as $medio) {
            if ($medio->id == $id) {
                $medioActualizar = $medio;
            }
        }
        if ($medioActualizar == null) {
            echo "El MEDIO con ID " . $id . " NO EXISTE. NO SE ACTUALIZA <br>";
        } else {
            echo "Procedo a actualizar el MEDIO con ID " . $id . "<br>";
            $clave = array_search($medioActualizar, $media);
            if (array_key_exists('medio',$nuevocampo)){
                $medioActualizar->medio=$nuevocampo['medio'];
            } 
            if (array_key_exists('titulo',$nuevocampo)){
                $medioActualizar->titulo=$nuevocampo['titulo'];
            } 
            if (array_key_exists('ADE',$nuevocampo)){
                $medioActualizar->ADE=$nuevocampo['ADE'];
            } 
            $myJSON = json_encode($media, JSON_PRETTY_PRINT);
            echo $myJSON;
            $file = '../data/media.json';
            $fp = fopen($file, "w");
            fwrite($fp, $myJSON);
            fclose($fp);
        }
    }
    //DELETE
    public function deleteMedia($id){
        echo "Hola desde el metodo deleteMedia() de MEDIA Controller <br>";
        echo "El ID del MEDIO es " . $id . "<br>";
        //Borrar el id del json si existe o indicar que no existe 
        $json = file_get_contents('../data/media.json', true);
        $media = json_decode($json);
        $medioBorrar = null;
        foreach ($media as $medio) {
            if ($medio->id == $id) {
                $medioBorrar = $medio;
            }
        }
        if ($medioBorrar == null) {
            echo "El MEDIO con ID " . $id . " NO EXISTE. NO SE BORRA <br>";
        } else {
            echo "Procedo a borrar el MEDIO con ID " . $id . "<br>";
            $clave = array_search($medioBorrar, $media);
            unset($media[$clave]);
            $media=array_values($media);
            $myJSON = json_encode($media, JSON_PRETTY_PRINT);
            echo $myJSON;
            $file = '../data/media.json';
            $fp = fopen($file, "w");
            fwrite($fp, $myJSON);
            fclose($fp);
        }
    }
    //ERROR
    public function errorMedia(){
        echo "Hola desde el metodo errorMedia() de MEDIA Controller <br>";
        echo "ERROR 404!!!<br>";
    }
}
?>