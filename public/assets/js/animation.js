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
    difference = Math.max(0, RemainingTime - (moment().unix() - starttime.unix()));
    days = Math.floor(difference / 86400);
    difference -= days * 86400;
    hours = Math.floor(difference / 3600);
    difference -= hours * 3600;
    minutes = Math.floor(difference / 60);
    seconds = difference - minutes * 60;

    Element.html((days > 0 ? (days + ' day' + (days > 1 ? 's, ' : ', ')) : '') + hours + ':' + ('00' + minutes).slice(-2) + ':' + ('00' + seconds).slice(-2));
  };

  UpdateElement();

  return window.setInterval(function() {
    UpdateElement();
  }, interval);
};
