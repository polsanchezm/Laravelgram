export function updateLikeButton(isLiked, likeButton) {
    if (isLiked) {
        // si s'ha fet like, canviem el contingut del cor a omplert
        likeButton.classList.remove('bi-heart');
        likeButton.classList.add('bi-heart-fill');
    } else {
        // si s'ha fet dislike, canviem el contingut del cor a buit
        likeButton.classList.remove('bi-heart-fill');
        likeButton.classList.add('bi-heart');
    }
}