function StopAnimation(Animation) {
  window.clearInterval(Animation);
};

function DotAnimation(Element, AnimatedText) {
  AnimatedText = typeof AnimatedText !== 'undefined' ? AnimatedText : '.';

  Element.html(AnimatedText + '.');

  return window.setInterval(function() {
    if (Element.html().length > 5 + AnimatedText.length) Element.html(AnimatedText + '.');
    else Element.append('.');
  }, 500);
};

function TimerAnimation(Element, RemainingTime) {
  milliseconds = 1000;
  interval = 500;
  starttime = moment();
  shortdisplay = true;
  autochange = true;

  Element.click(function() {
    autochange = false;
    shortdisplay = !shortdisplay;
    UpdateDisplay();
  });

  function UpdateDisplay() {
    duration = moment.duration(Math.max(0, RemainingTime - (moment().unix() - starttime.unix())), 'seconds');
    days = duration.days();

    if (autochange) shortdisplay = days > 0;

    if (!shortdisplay) {
      hours = duration.hours();
      minutes = duration.minutes();
      seconds = duration.seconds();

      Element.html((days > 0 ? (days + ' day' + (days > 1 ? 's, ' : ', ')) : '') + hours + ':' + ('00' + minutes).slice(-2) + ':' + ('00' + seconds).slice(-2));
    }
    else Element.html(duration.humanize());
  };

  UpdateDisplay();

  return window.setInterval(function() {
    UpdateDisplay();
  }, interval);
};
