function numberFormat(
    number,
    decimals = 0,
    decimalSeparator = ",",
    thousandsSeparator = "."
) {
    // Convert the number to a string
    let formattedNumber = number.toFixed(decimals).toString();

    // Split the integer and decimal parts
    let parts = formattedNumber.split(".");

    // Format the integer part with thousands separator
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, thousandsSeparator);

    // Join the integer and decimal parts with the decimal separator
    formattedNumber = parts.join(decimalSeparator);

    return formattedNumber;
}

$("form").submit(() => {
    $(".preload").css("display", "flex");
});

function hidePreload() {
    $(".preload").css("display", "none");
}
