$(document).ready(function(){var e=$(".js-promo-slider"),o=e.find(".swiper-container"),s=e.find(".arrow-next"),n=e.find(".arrow-prev"),t=(new Swiper(o,{speed:700,spaceBetween:0,watchOverflow:!0,watchSlidesProgress:!0,watchSlidesVisibility:!0,loop:!0,loopAdditionalSlides:1,navigation:{nextEl:s,prevEl:n}}),$(".js-slider-event-archive")),i=t.find(".swiper-container"),a=t.find(".arrow-next"),r=t.find(".arrow-prev"),l=(new Swiper(i,{speed:700,spaceBetween:0,watchOverflow:!0,watchSlidesProgress:!0,watchSlidesVisibility:!0,loop:!0,loopAdditionalSlides:1,navigation:{nextEl:a,prevEl:r},autoplay:{delay:5e3}}),$(".custom-cursor"));$("[data-cursor-pointer]");$(document).on("mousemove",function(e){x=e.clientX,y=e.clientY,l.css("transform","translate("+x+"px,"+y+"px)")}),$(document).on("mouseenter",function(e){l.addClass("cursor-default")}),$(document).on("mouseleave",function(e){l.removeClass("cursor-default")}),$('a:not(.arrow-next), a:not([disabled]), button:not([disabled]), input[type="submit"]:not([disabled]), [class*="js-"]').on("mouseenter",function(e){l.removeClass("cursor-next").addClass("cursor-link")}),$('a:not(.arrow-next), a:not([disabled]), button:not([disabled]), input[type="submit"]:not([disabled]), [class*="js-"]').on("mouseleave",function(e){l.removeClass("cursor-link")}),$(".arrow-next").on("mouseenter",function(e){l.removeClass("cursor-link").addClass("cursor-next")}),$(".arrow-next").on("mouseleave",function(e){l.removeClass("cursor-next")}),$(".js-post-grid").isotope({itemSelector:".post"}),$(".js-set-locations").on("click",function(e){e.preventDefault(),$("html").addClass("is-show-locations")}),$(".js-close-locations").on("click",function(e){e.preventDefault(),$("html").removeClass("is-show-locations")}),$(".js-mobile-nav-toggle").on("click",function(e){e.preventDefault(),$(this).toggleClass("is-opened"),$("html").toggleClass("is-show-navigation")})});