<?php $Title = 'Thanks for Registering!'; $RequiresAuthentication = true; include_once $_SERVER['DOCUMENT_ROOT'].'/layout/header.php'; ?>

<div class="row">
  <div class="jumbotron">
    <h2 class="text-center">Thanks for registering <?php echo $session->GetUsername(); ?>!</h2>
    <br>
    <h3 class="text-center">You are now free to move about the <a href="/account">holodeck</a>.</h3>
  </div>
</div>

<?php include_once $_SERVER['DOCUMENT_ROOT'].'/layout/footer.php'; ?>
