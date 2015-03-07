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
