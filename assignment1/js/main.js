function navigateToPage(page) {
    if (page !== "") {
        window.location.href = page;
    }
}
document.getElementById('menu').addEventListener('change', function() {
    navigateToPage(this.value);
});