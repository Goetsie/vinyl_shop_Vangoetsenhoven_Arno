export function hello(){
    console.log('The Vinyl Shop JavaScript works! 🙂');
}

$(function(){
    $('nav i.fas').addClass('fa-fw mr-1');
    $('input[required], select[required], textarea[required]').each(function () {
        $(this).closest('.form-group')
            .find('label')
            .append('<sup class="text-danger mx-1">*</sup>');
    });
    // Enable bootstrap tooltip buttons
    $('[data-toggle="tooltip"]').tooltip({
        // tags gebruiken in tooltip
        'html' : true,
    });

    Noty.overrideDefaults({
        layout: 'topRight',
        theme: 'bootstrap-v4',
        timeout: 3000
    });
});
// convert the time to a more readable format
export function to_mm_ss(duration) {
    let seconds = parseInt((duration / 1000) % 60);
    let minutes = parseInt((duration / (1000 * 60)) % 60);
    minutes = (minutes < 10) ? '0' + minutes : minutes;
    seconds = (seconds < 10) ? '0' + seconds : seconds;
    duration = minutes + ':' + seconds;
    return duration;
}
