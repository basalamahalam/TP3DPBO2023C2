<?php 

    include('config/db.php');
    include('classes/DB.php');
    include('classes/Template.php');
    include('classes/Pengurus.php');
    include('classes/Divisi.php');
    include('classes/Jabatan.php');

    $divisi = new Divisi($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
    $jabatan = new Jabatan($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
    $pengurus = new Pengurus($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
    $tmp_image = new Pengurus($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
    $divisi->open();
    $jabatan->open();
    $pengurus->open();
    $tmp_image->open();

    // VAR UNTUK SHOW DIVISI DAN JABATAN
    $divisi_options = null;
    $jabatan_options = null;

    // VAR UNTUK EDIT TAPI JADI GLOBAL
    $img_edit = "";
    $nama_edit = ""; $semester_edit = "";
    $divisi_edit = ""; $jabatan_edit = "";

    $view_form = new Template('templates/skintambah.html');
    if (!isset($_GET['edit'])) {
    
        if (isset($_POST['submit'])) {
            if ($pengurus->addPengurus($_POST, $_FILES) > 0) {
                echo "
                <script>
                    alert('Data berhasil ditambahkan!');
                    document.location.href = 'index.php';
                </script>
                ";
            } else {
                echo "
                <script>
                    alert('Data berhasil ditambahkan!');
                    document.location.href = 'tambah.php';
                </script>
                ";
            }
        }
        
        // Connect to Tabel Divisi
        
        $divisi->getDivisi();
    
        // Looping for Shows the data 
        while ($row = $divisi->getResult()) {
            $divisi_options .= "<option value=". $row['divisi_id']. ">" . $row['divisi_nama'] . "</option>";
        }
    
    
        // Connect to Tabel Jabatan
        
        $jabatan->getJabatan();
    
        // Looping for shows the data
        while($row = $jabatan->getResult()) {
            $jabatan_options .= "<option value=". $row['jabatan_id']. ">" . $row['jabatan_nama'] . "</option>";
        }
    } else if (isset($_GET['edit'])) {
        $_ID = $_GET['edit'];
        $tmp_image->getPengurus();
        $tmp_image->getPengurusById($_ID);
        $temp_fix = $tmp_image->getResult();
        $temp_img = $temp_fix['pengurus_foto'];
        // $temp_data = $tmp_image->getPengurusById($_ID);
        // $image_temp_edit = $temp_data->getResult();
        if (isset($_POST['submit'])) {
            if ($pengurus->updatePengurus($_ID, $_POST, $_FILES, $temp_img) > 0) {
                echo "
                <script>
                    alert('Data berhasil diubah!');
                    document.location.href = 'index.php';
                </script>
                ";
            } else {
                echo "
                <script>
                    alert('Data berhasil diubah!');
                    document.location.href = 'tambah.php';
                </script>
                ";
            }
        }
        $pengurus->getPengurusById($_ID);

        $row = $pengurus->getResult();
        $img_edit = $row['pengurus_foto'];
        $nama_edit = $row['pengurus_nama'];
        $semester_edit = $row['pengurus_semester'];
        $divisi_edit = $row['divisi_id'];
        $jabatan_edit = $row['jabatan_id'];

        $divisi->getDivisi();
    
        // Looping for Shows the data 
        while ($row = $divisi->getResult()) {
            $select = ($row['divisi_id'] == $divisi_edit) ? 'selected' : "";
            $divisi_options .= "<option value=". $row['divisi_id']. " . $select . >" . $row['divisi_nama'] . "</option>";
        }
    
    
        // Connect to Tabel Jabatan
        
        $jabatan->getJabatan();
    
        // Looping for shows the data
        while($row = $jabatan->getResult()) {
            $select = ($row['jabatan_id'] == $jabatan_edit) ? 'selected' : "";
            $jabatan_options .= "<option value=". $row['jabatan_id']. " . $select . >" . $row['jabatan_nama'] . "</option>";
        }


    }

    $view_form->replace('IMAGE_DATA' , $img_edit);
    $view_form->replace('NAMA_DATA' , $nama_edit);
    $view_form->replace('SEMESTER_DATA' , $semester_edit);
    $view_form->replace('DIVISI_DATA' , $divisi_edit);
    $view_form->replace('JABATAN_DATA' , $jabatan_edit);
    $view_form->replace('DIVISI_OPTIONS', $divisi_options);
    $view_form->replace('JABATAN_OPTIONS', $jabatan_options);
    $view_form->write();


    $pengurus->close();
    $divisi->close();
    $jabatan->close();

?>