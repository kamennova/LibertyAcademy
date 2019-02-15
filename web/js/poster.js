/* ==============================
         POSTER MOVEMENT
================================*/

let movementStrength = 45,
    height = movementStrength / $(window).height(),
    width = movementStrength / $(window).width(),
    imageWidth = window.innerWidth + 50,
    imageHeight = window.innerHeight + 50;

// setting background size
let slides = document.getElementsByClassName('slide');
slides[0].style.backgroundSize = imageWidth + "px";
slides[1].style.backgroundSize = imageWidth + "px";

if (window.innerWidth < 1920) {
    let rightPos = 1920 - window.innerWidth;
    slides[2].style.backgroundSize = "1920 px";
    // slides[2].style.backgroundPosition = "right -" + rightPos + "px top";
} else {
    slides[2].style.backgroundSize = imageWidth + "px";
}

document.querySelector('.slide-2 .slide-layer').style.backgroundSize = imageWidth + "px";
document.querySelector('.slide-1 .slide-layer-3').style.backgroundSize = imageWidth + "px";

// moving background with mouse moves
let poster = document.getElementsByClassName('poster')[0];
let active = 1;

poster.addEventListener('mousemove', function (e) {
    let pageX = e.pageX - ($(window).width() / 2),
        pageY = e.pageY - ($(window).height() / 2),
        newValueX,
        newValueY;

    if (active === 1) {
        newValueX = width * pageX * -1 - 25;
        newValueY = height * pageY * -1 - 150;
        $('.slide-1').css("background-position", "right " + newValueX + "px  top  " + newValueY + "px");
        $('.slide-layer-3').css({"top": newValueY + 150 + "px", "right": newValueX + "px"});
        $('.slide-layer-2').css({"top": newValueY + 170 + "px", "left": newValueX + 200 + "px"});
    } else if (active === 2) {
        newValueX = width * pageX * -1 - 25;
        newValueY = height * pageY * -1 - 46;
        $('.slide-2').css("background-position", "right " + newValueX + "px top " + newValueY + "px");
        $('.slide-2 .slide-layer').css("background-position", "right " + newValueX + "px top " + newValueY + "px");
    } else if (active === 3) {
        newValueX = (width * pageX * -1) - 25;
        newValueY = (height * pageY * -1) - windowHeight * 0.18 - 25;
        $('.slide-3').css("background-position", "right " + newValueX + "px top " + newValueY + "px");
        $('.slide-3 .slide-layer').css("background-position", "right " + newValueX + "px top " + newValueY + "px");
    }
});


let slideIndex = 0;

function posterMove() {

    if (slideIndex === slides.length - 1) {
        slides[slides.length - 1].style.zIndex = '50';
    } else if (slideIndex === 0) {
        slides[slides.length - 1].style.zIndex = 100 * slides.length;
    }

    // remove 'active' class after slide appears
    setTimeout(function () {
        if (slideIndex === 0) {
            slides[slides.length - 1].classList.remove('active');

        } else {
            slides[slideIndex - 1].classList.remove('active');
        }
    }, 1000);


    document.getElementById('indicator-' + active).classList.remove('active');
    slideIndex = (slideIndex + 1) % slides.length;

    slides[slideIndex].classList.add('active');

    active = slideIndex + 1;
    document.getElementById('indicator-' + active).classList.add('active');

    if (slideIndex !== 0) {
        if ((document.documentElement.scrollTop || document.body.scrollTop) < window.innerHeight - 70) {
            document.body.classList.add('dark');
        }
    } else if (document.body.classList.contains('dark')) {
        document.body.classList.remove('dark');
    }
}

window.addEventListener('scroll', function (e) {
    let distanceY = window.pageYOffset || document.documentElement.scrollTop,
        shrinkOn = window.innerHeight - 79;
    if (distanceY > shrinkOn) {
        document.body.classList.remove("dark");
    } else {
        if (slideIndex !== 0) {
            document.body.classList.add('dark');
        }
    }
});

let posterMoveInterval = setInterval(posterMove, 3000);
let newIndex;

let indicators = document.getElementsByClassName('indicator');
for (let d = 0; d < indicators.length; d++) {
    indicators[d].addEventListener('click', function () {
        newIndex = (this.id)[this.id.length - 1];
        clearInterval(posterMoveInterval);
        slideIndex = newIndex;
        console.log(slideIndex);
        // slideIndex = (newIndex + 1) % x.length;
        posterMoveInterval = setInterval(posterMove, 3000);
    });
}

/// Placing indicators list

let indicatorsList = document.getElementsByClassName('slides-indicators')[0];


if (document.body.clientWidth >= 1024) {
    siteContainerWidth = document.body.clientWidth * 0.85;
    siteContainerWidth = (siteContainerWidth > 1335) ? 1335 : siteContainerWidth;

    let rightOffset = (document.body.clientWidth - siteContainerWidth) / 2;

    indicatorsList.style.right = rightOffset + 'px';

    let slideCaptions = document.getElementsByClassName('slide-caption');
    for (let i = 0; i < slideCaptions.length; i++) {
        slideCaptions[i].style.right = rightOffset + 'px';
    }
}