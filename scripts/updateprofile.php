<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/session/loginsession.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/scripts/feedback.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/scripts/validation.php';

RequireAuthentication();

$avatar = RequirePostVariable('avatar');
$website = RequirePostVariable('website');
$about = RequirePostVariable('about');

if (strlen($avatar) > 0 && !URLValid($avatar)) Error('Avatar is not a valid link.');
else if (strlen($website) > 0 && !URLValid($website)) Error('Website is not a valid link.');

$stmt = $dbconnection->prepare('UPDATE users SET avatar = ?, website = ?, about = ? WHERE id = ?;');
$stmt->execute(array($avatar, $website, $about, $session->GetUserID()));
Success('');

?>
