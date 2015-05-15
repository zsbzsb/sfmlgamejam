<div class="row">
  <h2 class="text-center"><strong><a href="<?=$routes->generate('jam_page', array('id' => $id))?>"><?=$jam['title']?></a></strong></h2>
  <h4 class="text-center text-muted"><?= date(DATE_FORMAT, JamBegins($jam)).' to '.date(DATE_FORMAT, SubmissionsBegin($jam)); ?></h4>
  <?php if (isset($jam['selectedtheme'])) echo '<h2 class="text-center text-warning aftertag" aftertag="is the chosen theme">\'<i>'.$jam['selectedtheme'].'</i>\'</h2>'; ?>
  <?php require TEMPLATEROOT.'countdown.php'; ?>
  <hr />
</div>
