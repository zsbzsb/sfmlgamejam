    </div>
    <nav class="navbar navbar-inverse navbar-fixed-bottom" role="navigation" id="footer">
      <div class="container">
        <div class="navbar">
          <ul class="nav navbar-nav navbar-left">
            <li><a href="<?= $routes->generate('terms') ?>">Terms of Use</a></li>
            <li><a href="https://www.github.com/zsbzsb/sfmlgamejam/" target="_blank">Source Code</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="<?= $routes->generate('time') ?>" id="timedisplay"></a></li>
            <li><a href="http://www.zbrown.net/" target="_blank">Developed By Zachariah Brown (zsbzsb)</a></li>
          </ul>
        </div>
      </div>
    </nav>
    <script>
    $(function() {
      window.setInterval(function() {
        $('#timedisplay').html(moment.utc().format('MM/DD/YYYY hh:mm A'));
      }, 1000);
    });
    </script>
  </body>
</html>
