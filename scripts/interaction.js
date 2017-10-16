// Main JavaScript Document

var $ = jQuery; //negates Wordpress from going into noConflict() mode and allow for use of '$' instead of 'jQuery'

$(document).ready(function() {
  //set copyright year to current year
  $('.footer span.year').html(new Date().getFullYear());

  var windowWidth = $(window).width();
  hideMenuForMobile(windowWidth, true);

  // Responsive YouTube Videos
  var $allVideos = $("iframe[src^='http://www.youtube.com']");
  // Figure out and save aspect ratio for each video
  $allVideos.each(function() {
    $(this).data('aspectRatio', this.height / this.width).removeAttr('height').removeAttr('width');
  });
  
  if($allVideos.length) { // only run this resize script if there are videos to resize
    $(window).resize(function() {
      var newWidth = $allVideos.parent().width();
      // Resize all videos according to their own aspect ratio
      $allVideos.each(function() {
        $(this).width(newWidth).height(newWidth * $(this).data('aspectRatio'));
      });
    // Kick off one resize to fix all videos on page load
    }).resize();
  }

});

$(document).on('click', '.menu-link', function() {
  if($(this).hasClass('opened')) {
    $(this).next().slideUp();
    $(this).removeClass('opened');
  } else {
    $(this).next().slideDown();
    $(this).addClass('opened');
  }
  return false;
});

// check any link starting with # and scroll page to that anchor
$(document).on('click', 'a[href^="#"]', function() {
  if($(this).attr('href') === "#" && !$(this).hasClass('menu-link')) {
    var target = '';
    var elem = $('body');
  } else {
    var target = $(this).attr('href').split('#')[1];
    var elem = $('a[name="' + target + '"]');
  }
  scrollToDiv(elem);

  return false;
});

function hideMenuForMobile(windowWidth, load) {
  if(!$(document).data('resize-width')) {
    $(document).data('resize-width', windowWidth);
  }
  var existingWidth = $(document).data('resize-width');
  var newWidth = $(document).width();
  if(existingWidth !== newWidth || load) {
    if($(window).width() < 569) {
      $('.mobile-menu').each(function() {
        $(this).hide();
        $(this).prev().removeClass('opened');
      });
    } else {
      $('.mobile-menu').each(function() {
        $(this).show();
        $('.menu-link').addClass('opened');
      });
    }
  }
  $(document).data('resize-width', newWidth);
}

var rtime = new Date(1, 1, 2000, 12,00,00);
var timeout = false;
var delta = 100;

$(window).resize(function() {
  rtime = new Date();
  if (timeout === false) {
    timeout = true;
    setTimeout(resizeend, delta);
  } 
});

function resizeend() {
  if (new Date() - rtime < delta) {
    setTimeout(resizeend, delta);
  } 
  else {
    timeout = false;
    var windowWidth = $(window).width();
    hideMenuForMobile(windowWidth);
  }
}

function scrollToDiv(element) {
  var offset = element.offset();
  var offsetTop = offset.top;
  $('body, html').animate({
    scrollTop: offsetTop
  }, 800);
}
