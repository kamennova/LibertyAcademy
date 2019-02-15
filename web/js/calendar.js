var seminarDays = [[7, 16, 2017],[6, 6, 2017],[5, 7, 2017],[8, 17, 2017],[9, 1, 2017]];

function setScheduledDays(date) {

    for (i = 0; i < seminarDays.length; i++) {
        if (date.getMonth() == seminarDays[i][0] - 1 && date.getDate() == seminarDays[i][1]  && date.getFullYear() == seminarDays[i][2] ) {
            return [true, 'sDay'];
        }
    }

    return [false, ''];
}