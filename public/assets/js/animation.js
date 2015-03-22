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

  function UpdateElement() {
    duration = moment.duration(Math.max(0, RemainingTime - (moment().unix() - starttime.unix())), 'seconds');
    days = duration.days();

    if (days <= 0) {
      hours = duration.hours();
      minutes = duration.minutes();
      seconds = duration.seconds();

      Element.html(hours + ':' + ('00' + minutes).slice(-2) + ':' + ('00' + seconds).slice(-2));
    }
    else Element.html(duration.humanize());
  };

  UpdateElement();

  return window.setInterval(function() {
    UpdateElement();
  }, interval);
};
