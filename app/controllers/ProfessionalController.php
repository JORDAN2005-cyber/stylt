<?php
require_once __DIR__ . '/../helpers/security.php';
require_once __DIR__ . '/../models/Professional.php';
require_once __DIR__ . '/../../config/database.php';

class ProfessionalController {
    public static function register(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;
        verify_csrf();
        $name=trim($_POST['full_name']??''); $phone=trim($_POST['phone']??''); $email=trim($_POST['email']??'');
        $bio=trim($_POST['bio']??''); $city=trim($_POST['city']??''); $zone=trim($_POST['zone']??'');
        if ($name==='' || $phone==='' || $city==='' || $zone==='') { flash('error','Remplis tous les champs obligatoires.'); return; }
        if (!isset($_FILES['photo']) || $_FILES['photo']['error']!==UPLOAD_ERR_OK) { flash('error','Ajoute une photo professionnelle.'); return; }
        $file=$_FILES['photo'];
        if ($file['size']>MAX_UPLOAD_BYTES) { flash('error','La photo doit faire moins de 3 Mo.'); return; }
        $finfo=new finfo(FILEINFO_MIME_TYPE); $mime=$finfo->file($file['tmp_name']);
        $allowed=['image/jpeg'=>'jpg','image/png'=>'png','image/webp'=>'webp'];
        if (!isset($allowed[$mime])) { flash('error','Format accepté : JPG, PNG ou WebP.'); return; }
        if (!is_dir(UPLOAD_DIR)) mkdir(UPLOAD_DIR,0755,true);
        $filename='pro_'.bin2hex(random_bytes(8)).'.'.$allowed[$mime];
        if (!move_uploaded_file($file['tmp_name'], UPLOAD_DIR.$filename)) { flash('error','Impossible d’enregistrer la photo.'); return; }
        $pdo=db();
        try {
            $pdo->beginTransaction();
            $u=$pdo->prepare("INSERT INTO users (role,full_name,phone,email,password_hash,created_at) VALUES ('PROFESSIONNEL',?,?,?,?,NOW())");
            $u->execute([$name,$phone,$email!==''?$email:null,password_hash(bin2hex(random_bytes(12)),PASSWORD_DEFAULT)]);
            $uid=(int)$pdo->lastInsertId();
            $p=$pdo->prepare("INSERT INTO professionals (user_id,bio,city,zone,photo_path,status,verified,rating,review_count,created_at) VALUES (?,?,?,?,?,'pending',0,0,0,NOW())");
            $p->execute([$uid,$bio,$city,$zone,'assets/uploads/professionals/'.$filename]);
            $pid=(int)$pdo->lastInsertId();
            $pdo->commit();
            flash('success','Compte créé. Ton profil est maintenant en attente de validation Stylt.');
            redirect(APP_URL.'/index.php?page=professional&id='.$pid);
        } catch(Throwable $e) { if($pdo->inTransaction())$pdo->rollBack(); @unlink(UPLOAD_DIR.$filename); flash('error','Une erreur est survenue : '.$e->getMessage()); }
    }
}
