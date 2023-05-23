<?php

include('config/db.php');

class Pengurus extends DB
{
    function getPengurusJoin()
    {
        $query = "SELECT * FROM pengurus JOIN divisi ON pengurus.divisi_id=divisi.divisi_id JOIN jabatan ON pengurus.jabatan_id=jabatan.jabatan_id ORDER BY pengurus.pengurus_id";

        return $this->execute($query);
    }

    function getPengurus()
    {
        $query = "SELECT * FROM pengurus";
        return $this->execute($query);
    }

    function filterPengurus()
    {
        $query = "SELECT * FROM pengurus JOIN divisi ON pengurus.divisi_id=divisi.divisi_id JOIN jabatan ON pengurus.jabatan_id=jabatan.jabatan_id ORDER BY pengurus.pengurus_nama DESC";
        return $this->execute($query);
    }

    function getPengurusById($id)
    {
        $query = "SELECT * FROM pengurus JOIN divisi ON pengurus.divisi_id=divisi.divisi_id JOIN jabatan ON pengurus.jabatan_id=jabatan.jabatan_id WHERE pengurus_id=$id";
        return $this->execute($query);
    }

    function searchPengurus($keyword)
    {
        $query = "SELECT * FROM pengurus JOIN divisi ON pengurus.divisi_id=divisi.divisi_id JOIN jabatan ON pengurus.jabatan_id=jabatan.jabatan_id WHERE pengurus_nama LIKE '%".$keyword."%'";
        return $this->execute($query);
    }

    function addPengurus($data, $file)
    {
        $tmp_file = $file['file_image']['tmp_name'];
        $pengurus_foto = $file['file_image']['name'];
        
        $dir = "assets/images/$pengurus_foto";
        move_uploaded_file($tmp_file, $dir);

        $pengurus_nama = $data['nama'];
        $pengurus_semester = $data['semester'];
        $divisi_id = $data['divisi'];
        $jabatan_id = $data['jabatan'];

        $query = "INSERT INTO pengurus VALUES('','$pengurus_foto', '$pengurus_nama', '$pengurus_semester', '$divisi_id', '$jabatan_id')";

        return $this->executeAffected($query);
    }

    function updatePengurus($id, $data, $file, $img)
    {
        
        
        $tmp_file = $file['file_image']['tmp_name'];
        $pengurus_foto = $file['file_image']['name'];
        
        if ($pengurus_foto == "") {
            $pengurus_foto = $img;
        }

        $dir = "assets/images/$pengurus_foto";
        move_uploaded_file($tmp_file, $dir);


        $pengurus_nama = $data['nama'];
        $pengurus_semester = $data['semester'];
        $divisi_id = $data['divisi'];
        $jabatan_id = $data['jabatan'];

        $query = "UPDATE pengurus SET pengurus_foto = '$pengurus_foto', pengurus_nama = '$pengurus_nama', pengurus_semester = '$pengurus_semester', divisi_id = '$divisi_id', jabatan_id = '$jabatan_id' WHERE pengurus_id = '$id'";
        
        return $this->executeAffected($query);
    }

    function deletePengurus($id)
    {
        $query = "DELETE FROM pengurus WHERE pengurus_id = $id";
        return $this->executeAffected($query);
    }
}
