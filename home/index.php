<?php $Title = 'Home'; $Active = 'Home'; include_once $_SERVER['DOCUMENT_ROOT'].'/layout/header.php'; ?>

<div class="row">
  <div class="jumbotron">
    <h2 class="text-center">Hello and welcome to the SFML Game Jam website!</h2>
  </div>
</div>

<div class="row">
<!-- News -->
  <div class="col-md-8">
    <h3 id="news">News</h3>
    <a href="#">
      <div class="row">
        <div class="col-md-9"><h4>Now Ready</h4></div>
        <div class="col-md-3"><h4>8-15-13</h4></div>
      </div>
    </a>
    <div class="row">
      <div class="col-md-10">
        <blockquote>
          <p>This is a testing news feed. It should go and go and go and go until we never get back. Willi wonka has lots of candy like that.</p>
        </blockquote>
      </div>
    </div>
    <div class="row">
      <a href="#">
        <div class="col-md-9"><h4>Older</h4></div>
        <div class="col-md-3"><h4>2-28-12</h4></div>
      </a>
    </div>
  </div>

<!-- Upcoming Jams -->
  <div class="col-md-4">
    <h3 id="jams">Upcoming Jams</h3>
    <div class="row">
      <a href="#">
        <div class="col-md-7"><h4>5th Jam</h4></div>
        <div class="col-md-3"><h4>9-10-15</h4></div>
      </a>
    </div>
  </div>
</div>

<?php include_once $_SERVER['DOCUMENT_ROOT'].'/layout/footer.php'; ?>
