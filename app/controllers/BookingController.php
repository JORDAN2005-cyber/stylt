<?php
require_once __DIR__ . '/../helpers/security.php';
require_once __DIR__ . '/../models/Booking.php';
class BookingController {
    public static function create(): void {
        verify_csrf();
        try {
            $id=Booking::create((int)$_POST['professional_id'],(int)$_POST['service_id'],$_POST['date'],$_POST['time'],$_POST['mode'],trim($_POST['zone']));
            redirect(APP_URL.'/index.php?page=appointment&id='.$id);
        } catch(Throwable $e) { flash('error',$e->getMessage()); redirect(APP_URL.'/index.php?page=booking&id='.(int)$_POST['professional_id']); }
    }
}
