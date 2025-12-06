document.querySelectorAll('.toggle-love-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        let icon = this.querySelector('i');
        let postId = this.dataset.postId;

        fetch("{{ route('post.like') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ id_post: postId })
        })
        .then(res => res.json())
        .then(data => {
            // toggle icon
            if(data.status === 'liked'){
                icon.classList.remove("fa-regular");
                icon.classList.add("fa-solid", "text-danger");
            } else {
                icon.classList.remove("fa-solid", "text-danger");
                icon.classList.add("fa-regular");
            }

            // pulse animation
            icon.style.animation = "pulse 0.3s ease";
            setTimeout(() => icon.style.animation = "", 300);

            // update count
            let likeCountEl = btn.closest('.action-wrapper').querySelector('.like-count');
            if(likeCountEl) likeCountEl.textContent = data.count + " likes";
        })
        .catch(console.error);
    });
});

// Animate cards appear with delay
document.querySelectorAll('.animate-float').forEach((el, index) => {
    el.style.animationDelay = (index * 0.1) + "s";
});
