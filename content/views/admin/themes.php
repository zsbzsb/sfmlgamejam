<div class="row">
  <h2 class="text-center">Approve Themes for the <a href="<?=$routes->generate('jam_page', array('id' => $id))?>"><?=$jam['title']?></a></h2>
  <h3 class="text-center" id="themecountdisplay"></h3>
  <hr />
</div>

<div class="row">
  <div class="col-md-8 col-md-offset-2">
    <?php require TEMPLATEROOT.'formfeedback.php'; ?>
    <table class="table table-striped <?=$canedit ? 'clickabletable' : ''?>">
      <thead>
        <tr>
          <th>Theme</th>
          <th>Submitter</th>
          <th>Is Approved</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php

          foreach ($themes as $theme)
          {
            echo '
              <tr class="themerow" themeid="'.$theme['id'].'">
                <td>'.$theme['name'].'</td>
                <td>'.$theme['username'].'</td>
                <td class="isapproved">'.($theme['isapproved'] ? 'Yes' : 'No').'</td>
                <td><a href="'.$routes->generate('theme_edit_admin', array('id' => $id, 'themeid' => $theme['id'])).'" class="editlink">Edit</a></td>
              </tr>';
          }

        ?>
      </tbody>
    </table>
  </div>
</div>

<script>
CanEdit = <?=$canedit ? 'true' : 'false'?>;
TotalThemeCount = <?=count($themes)?>;
ApprovedThemeCount = <?=$approvedthemecount?>;

$(function() {
  if (CanEdit) {
    $('.themerow').click(function() {
      var cell = $(this).find('.isapproved');
      var id = $(this).attr('themeid');

      if (cell.html() == 'Yes')
        ApproveTheme(id, cell, false);
      else if (cell.html() == 'No')
        ApproveTheme(id, cell, true);
    });

    $('.themerow .editlink').click(function(e) {
      e.stopPropagation(); 
    });
  }

  UpdateThemeCountDisplay();
});

function ApproveTheme(ID, Cell, IsApproved) {
  var animation = DotAnimation(Cell);

  function RestoreCell(IsApproved) {
    StopAnimation(animation);
    Cell.html(IsApproved ? 'Yes' : 'No');
  };

  Post('/api/v1/themes/suggestions/approve', { themeid:ID, isapproved:IsApproved })
    .done(function(result) {
      if (result.success) {
        RestoreCell(IsApproved);
        ApprovedThemeCount += IsApproved ? 1 : -1;
        UpdateThemeCountDisplay();
      }
      else {
        ErrorFeedback(result.message);
        RestoreCell(!IsApproved);
      }
    })
    .fail(function() {
      ErrorFeedback('An unexpected error happened, please try again.');  
      RestoreCell(!IsApproved);
    });
};

function UpdateThemeCountDisplay() {
  $('#themecountdisplay').html(ApprovedThemeCount + ' / ' + TotalThemeCount + ' approved themes');
};
</script>
