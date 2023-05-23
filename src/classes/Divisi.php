<?php

class Divisi extends DB
{
    function getDivisi()
    {
        $query = "SELECT * FROM divisi";
        return $this->execute($query);
    }

    function getDivisiById($id)
    {
        $query = "SELECT * FROM divisi WHERE divisi_id=$id";
        return $this->execute($query);
    }

    function filterDivisi()
    {
        $query = "SELECT * FROM divisi ORDER BY ASC";
        return $this->execute($query);
    }

    function searchDivisi($keyword)
    {
        $query = "SELECT * FROM divisi WHERE divisi_nama LIKE '%".$keyword."%'";
        return $this->execute($query);
    }

    function addDivisi($data)
    {
        $nama = $data['nama'];
        $query = "INSERT INTO divisi VALUES('', '$nama')";
        return $this->executeAffected($query);
    }

    function updateDivisi($id, $data)
    {
        $nama = $data['nama'];
        $query = "UPDATE divisi SET divisi_nama = '$nama' WHERE divisi_id = '$id'";
        // $query = "INSERT INTO divisi VALUES('', '$nama')";
        return $this->executeAffected($query);
    }

    function deleteDivisi($id)
    {
        $query = "DELETE FROM divisi WHERE divisi_id = $id";
        return $this->executeAffected($query);
    }
}
