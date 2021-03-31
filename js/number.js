function animateValue(id, start, end, duration) {
    if (start === end) return;
    var range = end - start;
    var current = start;
    var increment = end > start? 5 : -5;
    var stepTime = Math.abs(Math.floor(duration / range));
    var obj = document.getElementById(id);
    var timer = setInterval(function() {
        current += increment;
        obj.innerHTML = current; 
        if (current == end) {
            clearInterval(timer);
        }
    }, stepTime);

    animateValue("value", 100, 25, 5000);
}

window.onload = () => {
    animateValue("value", 100, 25, 10);
}