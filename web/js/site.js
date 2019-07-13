// ---------HEADER--------

window.addEventListener('scroll', function (e) {
    let distanceY = window.pageYOffset || document.documentElement.scrollTop,
        shrinkOn = window.innerHeight - 70,
        header = $('.main-header-wrapper');
    if (distanceY > shrinkOn) {
        header.removeClass("transparent");
        document.body.classList.remove('dark');
    } else {
        if (!header.hasClass("transparent")) {
            header.addClass("transparent");
        }
    }
});

let expanded = false;

document.getElementById('menu-icon').addEventListener('click', () => {

});

$('#menu-icon').click(function () {
    $(this).toggleClass('open');

    if (!expanded) {
        $('.main-nav-sub-menu').animate({'top': '0px'}, {duration: 200});
        expanded = true;
    }
    else {
        $('.main-nav-sub-menu').animate({'top': '-595px'}, {duration: 400});
        expanded = false;
    }
});


// --------------MODAL-----------

let eventModal = document.querySelector('.modal.upcoming-event');

let windowWidth = window.innerWidth;
let windowHeight = window.innerHeight;
let siteContainerWidth;

if (windowWidth >= 1335) {
    siteContainerWidth = 1335
} else {
    siteContainerWidth = windowWidth * 0.85
}

let popUpRight = (windowWidth - siteContainerWidth) / 2;

if (eventModal) {
    eventModal.style.right = popUpRight + 'px';

    let eventModalClose = eventModal.querySelector(".modal-close");

    if (eventModalClose) {
        eventModalClose.addEventListener('click', function (evt) {
            evt.preventDefault();
            eventModal.classList.remove('modal-show');
        });
    }
}


// --------FILTER COLUMN----------

let isMobile = screen.width < 768;

let mainGrid = document.getElementsByClassName('main-grid')[0];
if (mainGrid) {

    if(!isMobile) {
        let mainGridHeight = mainGrid.offsetHeight;

        let filterColumn = document.getElementsByClassName('filter-column')[0];
        let filterColumnOffsets = 55;
        let filterColumnHeight = filterColumn.offsetHeight + filterColumnOffsets;

        let footerHeight = document.getElementsByClassName('main-footer')[0].offsetHeight;
        let maxScrollHeight = document.body.offsetHeight + window.innerHeight - filterColumnHeight - footerHeight - filterColumnOffsets;

        if (filterColumnHeight > mainGridHeight) {
            mainGrid.style.height = filterColumnHeight + 'px';
        }

        window.addEventListener('scroll', () => {
            let windowScroll = $(window).scrollTop() + window.innerHeight;

            if (windowScroll > maxScrollHeight) {
                filterColumn.style.position = 'absolute';
                filterColumn.style.bottom = '25px';
            } else {
                filterColumn.style.position = 'fixed';
                filterColumn.style.bottom = 'auto';
            }
        });
    } else {
        console.log('hfgh');
    }
}
// ------CKEDITOR---------

// $(window).onload(function(){
//    $('.cke_wysiwyg_frame').click();
// });