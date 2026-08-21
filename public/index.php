<?php
require_once __DIR__.'/../config/config.php';
require_once __DIR__.'/../app/helpers/security.php';
require_once __DIR__.'/../app/models/Professional.php';
require_once __DIR__.'/../app/models/Booking.php';
require_once __DIR__.'/../app/controllers/ProfessionalController.php';
require_once __DIR__.'/../app/controllers/BookingController.php';

if ($_SERVER['REQUEST_METHOD']==='POST') {
    $action=$_POST['action']??'';
    if($action==='register_professional') ProfessionalController::register();
    if($action==='create_booking') BookingController::create();
}
$page=$_GET['page']??'home'; $data=[];
if($page==='search') $data['professionals']=Professional::all(trim($_GET['q']??''));
if($page==='professional') { $data['professional']=Professional::find((int)($_GET['id']??0)); if($data['professional']) { $data['services']=Professional::services($data['professional']['id']); $data['portfolio']=Professional::portfolio($data['professional']['id']); } }
if($page==='booking') { $data['professional']=Professional::find((int)($_GET['id']??0)); if($data['professional']) $data['services']=Professional::services($data['professional']['id']); }
if($page==='appointment') $data['booking']=Booking::find((int)($_GET['id']??0));
$view=__DIR__.'/../views/client/'.$page.'.php';
if($page==='register-professional') $view=__DIR__.'/../views/professional/register.php';
if(!is_file($view)) { http_response_code(404); $view=__DIR__.'/../views/client/404.php'; }
include __DIR__.'/../views/components/layout.php';
