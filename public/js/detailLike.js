import { updateLikeButton } from "./updateLike.js";

// agafem el botó del like
const button = document.getElementById('like');

// agafem el comptador dels likes
const likeCount = document.getElementById('like-count');

// agafem la id de la imatge
const imageId = button.getAttribute('data-image-id');

// agafem la url per actualitzar els likes
const url = '/posts/like/' + imageId;

document.addEventListener('DOMContentLoaded', function () {
    // agafem la url per comrpovar els likes
    const checkUrl = '/posts/like/check/' + imageId;

    // verificar les dades al carregar la pàgina
    fetch(checkUrl, {
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
        .then(response => response.json())
        .then(data => {
            // actualitzem els likes
            const totalLikes = data.totalLikes;
            updateLikeButton(data.liked, button, likeCount, totalLikes)
        });

});

// al fer click al botó, s'actualitzen les dades
button.addEventListener('click', function (e) {
    e.preventDefault();

    // comprovem si s'ha fet like o no
    const isLiked = button.classList.contains('bi-heart-fill');

    // parsegem el contingut dels likes
    const currentLikes = parseInt(likeCount.textContent);

    // actualitzem el comptador de likes reactivament
    const updatedLikes = isLiked ? currentLikes - 1 : currentLikes + 1;
    likeCount.textContent = updatedLikes;

    // actualitzem les dades
    updateLikeButton(!isLiked, button, likeCount, updatedLikes);

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ image_id: imageId })
    })
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                // si no s'ha pogut fer like, posem els likes als que ja hi hava abans de fer like
                likeCount.textContent = currentLikes;
                updateLikeButton(isLiked, button, likeCount, currentLikes);
            }
        })
        .catch((error) => {
            // mostrem l'error i deixem els likes als que hi havia abans de fer like
            console.error('Error:', error);
            likeCount.textContent = currentLikes;
            updateLikeButton(isLiked, button, likeCount, currentLikes);
        });
});
