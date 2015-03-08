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

function TimerAnimation(Element, EndTime) {
  lastseconds = -1;
  milliseconds = 1000;
  interval = 28;

  return window.setInterval(function() {
    difference = Math.max(0, moment.unix(EndTime - moment().unix()).unix());
    days = Math.floor(difference / 86400);
    difference -= days * 86400;
    hours = Math.floor(difference / 3600);
    difference -= hours * 3600;
    minutes = Math.floor(difference / 60);
    seconds = difference - minutes * 60;

   if (lastseconds != seconds && seconds != 0) {
     lastseconds = seconds;
     milliseconds = 1000;
   }
   else if (seconds == 0) milliseconds = 0;
   else milliseconds = Math.max(0, milliseconds - interval);

    Element.html(days + 'd ' + hours + 'h ' + minutes + 'm ' + seconds + 's ' + milliseconds + 'ms');
  }, interval);
};
