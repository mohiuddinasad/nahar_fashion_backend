function toggleWishlist(btn, productId) {
            const isWishlisted = btn.classList.contains('wishlisted');
            const url = isWishlisted ? `/wishlist/remove/${productId}` : `/wishlist/add/${productId}`;
            const method = isWishlisted ? 'DELETE' : 'POST';
            const token = document.querySelector('meta[name="csrf-token"]');
            if (!token) {
                console.error('CSRF token missing!');
                return;
            }

            fetch(url, {
                    method: method,
                    headers: {
                        'X-CSRF-TOKEN': token.content,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'login_required') {
                        window.location.href = '/login';
                        return;
                    }

                    if (data.status === 'added' || data.status === 'already_added') {
                        btn.classList.add('wishlisted');
                        if (btn.querySelector('i')) {
                            btn.querySelector('i').className = 'fas fa-heart';
                        }
                    }

                    if (data.status === 'removed') {
                        const card = document.getElementById(`wishlist-card-${productId}`);
                        if (card) {
                            card.style.transition = 'opacity 0.3s';
                            card.style.opacity = '0';
                            setTimeout(() => {
                                card.remove();

                                // Check if any rows left
                                const tbody = document.querySelector('#wishlist_product tbody');
                                if (tbody && tbody.querySelectorAll('tr').length === 0) {
                                    document.querySelector('#wishlist_product .container').innerHTML = `
                            <div class="alert alert-info text-center my-5">
                                Your wishlist is empty. <a href="/shop">Continue Shopping</a>
                            </div>`;
                                }
                            }, 300);
                        } else {
                            btn.classList.remove('wishlisted');
                            if (btn.querySelector('i')) {
                                btn.querySelector('i').className = 'far fa-heart';
                            }
                        }
                    }

                    if (data.count !== undefined) {
                        const badge = document.getElementById('wishlistCount');
                        if (badge) badge.textContent = data.count;
                    }
                })
                .catch(err => console.error('Wishlist error:', err));
        }
