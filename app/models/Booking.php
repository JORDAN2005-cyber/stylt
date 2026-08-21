<?php
require_once __DIR__ . '/../../config/database.php';
class Booking {
    public static function create(int $professionalId, int $serviceId, string $date, string $time, string $mode, string $zone): int {
        $pdo=db(); $pdo->beginTransaction();
        try {
            $lock=$pdo->prepare("SELECT id,status FROM bookings WHERE professional_id=? AND appointment_date=? AND appointment_time=? FOR UPDATE");
            $lock->execute([$professionalId,$date,$time]); $existing=$lock->fetch();
            if ($existing && in_array($existing['status'], ['pending','confirmed'], true)) throw new RuntimeException('Ce créneau vient d’être réservé. Choisis une autre heure.');
            if ($existing) {
                $up=$pdo->prepare("UPDATE bookings SET service_id=?,mode=?,zone=?,status='confirmed' WHERE id=?");
                $up->execute([$serviceId,$mode,$zone,$existing['id']]); $id=(int)$existing['id'];
            } else {
                $ins=$pdo->prepare("INSERT INTO bookings (professional_id,service_id,appointment_date,appointment_time,mode,zone,status,created_at) VALUES (?,?,?,?,?,?, 'confirmed', NOW())");
                $ins->execute([$professionalId,$serviceId,$date,$time,$mode,$zone]); $id=(int)$pdo->lastInsertId();
            }
            $pdo->commit(); return $id;
        } catch(Throwable $e) { $pdo->rollBack(); throw $e; }
    }
    public static function find(int $id): ?array {
        $st=db()->prepare("SELECT b.*, u.full_name AS professional_name, p.photo_path, p.verified, p.rating, s.name AS service_name, s.price, s.duration_minutes FROM bookings b JOIN professionals p ON p.id=b.professional_id JOIN users u ON u.id=p.user_id JOIN services s ON s.id=b.service_id WHERE b.id=? LIMIT 1");
        $st->execute([$id]); $r=$st->fetch(); return $r ?: null;
    }
}
