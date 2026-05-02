function toggleForm() {
    var form = document.getElementById('uploadForm');
    var isHidden = form.style.display === 'none' || form.style.display === '';
    form.style.display = isHidden ? 'block' : 'none';
    if (isHidden) form.scrollIntoView({ behavior: 'smooth' });
}

window.onload = function () {
    // Auto-hide alert after 3 seconds
    var alert = document.querySelector('.alert');
    if (alert) setTimeout(function () { alert.style.display = 'none'; }, 3000);

    // Auto-open form if upload was attempted
    if (window.location.search.includes('msg=')) {
        document.getElementById('uploadForm').style.display = 'block';
    }
};
