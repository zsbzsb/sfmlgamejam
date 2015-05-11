    </div>
    <nav class="navbar navbar-inverse navbar-fixed-bottom hidden-xs" role="navigation" id="footer">
      <div class="container">
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-left">
            <li><a href="<?= $routes->generate('terms') ?>">Terms of Use</a></li>
            <li><a href="https://www.github.com/zsbzsb/sfmlgamejam/" target="_blank">Source Code</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="<?= $routes->generate('time') ?>" id="timedisplay"></a></li>
            <li><a href="http://www.zbrown.net/" target="_blank">Copyright &copy; Zachariah Brown (zsbzsb)</a></li>
          </ul>
        </div>
      </div>
    </nav>
    <script>
    $(function() {
      UpdateTime();
      window.setInterval(function() {
        UpdateTime();
      }, 1000);
    });

    function UpdateTime() {
      $('#timedisplay').html(moment.utc().format('MM/DD/YYYY hh:mm A'));
    };
    </script>
  </body>
</html>
