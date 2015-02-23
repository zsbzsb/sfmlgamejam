var Animations = {};

function StopAnimation(Element) {
  if (!(Element in Animations)) return;
  window.clearInterval(Animations[Element]['id']);
  Element.html(Animations[Element]['defaulttext']);
};

function DotAnimation(Element, AnimatedText) {
  if(typeof(AnimatedText) === 'undefined') AnimatedText = '';
  var defaulttext = Element.html();
  Element.html(AnimatedText + '.');
  var id = window.setInterval(function() {
    if (Element.html().length > 5 + AnimatedText.length) Element.html(AnimatedText + '.');
    else Element.append('.');
  }, 500);
  Animations[Element] = {defaulttext:defaulttext, id:id};
};
