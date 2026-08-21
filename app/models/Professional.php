<?php
require_once __DIR__ . '/../../config/database.php';
class Professional {
    public static function all(string $q=''): array {
        $sql = "SELECT p.*, u.full_name, u.phone FROM professionals p JOIN users u ON u.id=p.user_id WHERE p.status='approved'";
        $params=[];
        if ($q !== '') { $sql .= " AND (u.full_name LIKE :q OR p.bio LIKE :q OR p.city LIKE :q OR p.zone LIKE :q)"; $params['q']="%$q%"; }
        $sql .= " ORDER BY p.verified DESC, p.rating DESC, p.id DESC";
        $st=db()->prepare($sql); $st->execute($params); return $st->fetchAll();
    }
    public static function find(int $id): ?array {
        $st=db()->prepare("SELECT p.*, u.full_name, u.phone, u.email FROM professionals p JOIN users u ON u.id=p.user_id WHERE p.id=? LIMIT 1");
        $st->execute([$id]); $p=$st->fetch(); return $p ?: null;
    }
    public static function services(int $id): array {
        $st=db()->prepare("SELECT s.* FROM professional_services ps JOIN services s ON s.id=ps.service_id WHERE ps.professional_id=? ORDER BY s.price ASC");
        $st->execute([$id]); return $st->fetchAll();
    }
    public static function portfolio(int $id): array {
        $st=db()->prepare("SELECT image_path FROM portfolios WHERE professional_id=? ORDER BY id ASC"); $st->execute([$id]); return $st->fetchAll();
    }
}
