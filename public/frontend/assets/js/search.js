

document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('product-search');
            const resultsBox = document.getElementById('search-results');

            input.addEventListener('input', function() {
                const query = this.value.trim().toLowerCase();
                resultsBox.innerHTML = '';

                if (query.length < 2) {
                    resultsBox.style.display = 'none';
                    return;
                }

                const filtered = allProducts.filter(p =>
                    p.name.toLowerCase().includes(query)
                );

                if (filtered.length === 0) {
                    resultsBox.innerHTML = `
                <div style="padding:12px 16px; color:#999; font-size:14px;">
                    No products found for "<strong>${query}</strong>"
                </div>`;
                } else {
                    resultsBox.innerHTML = filtered.map(p => `
                <a href="/products/${p.id}" style="
                    display: flex;
                    align-items: center;
                    padding: 10px 16px;
                    text-decoration: none;
                    color: #333;
                    border-bottom: 1px solid #f0f0f0;
                    transition: background 0.15s;
                " onmouseover="this.style.background='#f8f9fa'"
                   onmouseout="this.style.background='transparent'">

                    ${p.image
                        ? `<img src="${p.image}" style="width:40px;height:40px;object-fit:cover;border-radius:4px;margin-right:12px;">`
                        : `<div style="width:40px;height:40px;background:#eee;border-radius:4px;margin-right:12px;display:flex;align-items:center;justify-content:center;">
                                   <i class="fa fa-image" style="color:#aaa;"></i>
                               </div>`
                    }

                    <div>
                        <div style="font-weight:500; font-size:14px;">
                            ${highlight(p.name, query)}
                        </div>
                        <div style="color:#e44; font-size:13px; margin-top:2px;">
                            $${parseFloat(p.price).toFixed(2)}
                        </div>
                    </div>
                </a>
            `).join('');
                }

                resultsBox.style.display = 'block';
            });

            function highlight(text, query) {
                const regex = new RegExp(`(${query})`, 'gi');
                return text.replace(regex,
                    '<mark style="background:#fff3cd;padding:0 2px;border-radius:2px;">$1</mark>');
            }

            // Close on outside click
            document.addEventListener('click', function(e) {
                if (!input.contains(e.target) && !resultsBox.contains(e.target)) {
                    resultsBox.style.display = 'none';
                }
            });

            // Keyboard navigation
            input.addEventListener('keydown', function(e) {
                const items = resultsBox.querySelectorAll('a');
                const focused = resultsBox.querySelector('a:focus');

                if (e.key === 'ArrowDown') {
                    e.preventDefault();
                    (focused ? focused.nextElementSibling : items[0])?.focus();
                } else if (e.key === 'ArrowUp') {
                    e.preventDefault();
                    (focused ? focused.previousElementSibling : items[items.length - 1])?.focus();
                } else if (e.key === 'Escape') {
                    resultsBox.style.display = 'none';
                }
            });
        });