<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Satya Interiors')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Montserrat:wght@500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/site.css') }}">
    <script src="https://unpkg.com/lucide@latest" defer></script>
</head>
<body>
    <header class="glass-nav">
        <a class="brand" href="{{ route('home') }}">Satya Interiors</a>
        <nav class="nav-links" aria-label="Main navigation">
            <a href="{{ route('shop') }}">Shop</a>
            <a href="{{ route('home') }}#categories">Rooms</a>
            <a href="{{ route('services') }}">Interior Services</a>
            @auth
                <a href="{{ route('orders.index') }}">Orders</a>
                <a href="{{ route('customorders.index') }}">Custom Orders</a>
                @if(auth()->user()->is_admin)
                    <a href="{{ route('admin.dashboard') }}">Admin</a>
                @endif
            @else
                <a href="{{ route('login') }}">Login</a>
            @endauth
        </nav>
        <div class="nav-actions">
            <form class="header-search @if(filled(request('q'))) is-open @endif" method="GET" action="{{ route('shop') }}" role="search">
                <input name="q" type="search" placeholder="Search" aria-label="Search products" value="{{ request('q') }}">
                <button aria-label="Search" type="submit"><i data-lucide="search"></i></button>
            </form>
            <a class="icon-link" aria-label="Shopping bag" href="{{ route('cart.show') }}"><i data-lucide="shopping-bag"></i></a>
            @auth
                <form method="POST" action="{{ route('logout') }}">@csrf<button aria-label="Log out"><i data-lucide="log-out"></i></button></form>
            @endauth
        </div>
    </header>

    @yield('content')

    <footer class="site-footer">
        <div>
            <p class="eyebrow">Furniture and interior objects</p>
            <h2>Built for calm homes and complete rooms.</h2>
        </div>
        <a class="button ghost" href="{{ route('shop') }}">View collection</a>
    </footer>
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();

            document.querySelectorAll('img').forEach((image) => {
                image.addEventListener('error', () => {
                    if (image.dataset.fallbackApplied) {
                        return;
                    }

                    image.dataset.fallbackApplied = 'true';
                    image.src = 'https://images.unsplash.com/photo-1618220179428-22790b461013?auto=format&fit=crop&w=900&q=80';
                });
            });

            document.querySelectorAll('[data-disable-on-submit]').forEach((form) => {
                form.addEventListener('submit', () => {
                    if (!form.checkValidity()) {
                        return;
                    }

                    form.setAttribute('aria-busy', 'true');
                    form.querySelectorAll('button[type="submit"]').forEach((button) => {
                        button.disabled = true;
                        button.dataset.originalText = button.textContent.trim();
                        button.textContent = button.dataset.loadingText || 'Please wait...';
                    });
                });
            });

            document.querySelectorAll('.header-search').forEach((form) => {
                form.addEventListener('submit', (event) => {
                    const input = form.querySelector('input[name="q"]');
                    const isOpen = form.classList.contains('is-open');

                    if (!isOpen) {
                        event.preventDefault();
                        form.classList.add('is-open');
                        input.focus();

                        return;
                    }

                    if (!input.value.trim()) {
                        event.preventDefault();
                        input.value = '';
                        input.focus();
                    }
                });
            });

            document.querySelectorAll('[data-auto-filter]').forEach((form) => {
                form.querySelectorAll('input[type="radio"]').forEach((input) => {
                    input.addEventListener('change', () => form.requestSubmit());
                });

                form.addEventListener('submit', () => {
                    form.querySelectorAll('input, select').forEach((input) => {
                        if (!input.value.trim()) {
                            input.disabled = true;
                        }
                    });
                });
            });

            document.querySelectorAll('[data-preview-color]').forEach((input) => {
                input.addEventListener('change', (event) => {
                    const detail = event.target.closest('.product-detail');
                    const preview = detail?.querySelector('[data-color-preview]');
                    const image = preview?.querySelector('.main-photo');

                    if (preview) {
                        preview.style.setProperty('--preview-color', event.target.dataset.previewColor);
                        preview.classList.toggle('has-variant-image', Boolean(event.target.dataset.previewImage));
                    }

                    if (image) {
                        image.src = event.target.dataset.previewImage || preview.dataset.originalImage;
                    }
                });
            });

            document.querySelectorAll('[data-saved-address]').forEach((select) => {
                select.addEventListener('change', () => {
                    const option = select.selectedOptions[0];
                    const form = select.closest('form');

                    if (!option?.dataset.address) {
                        return;
                    }

                    form.querySelector('[name="phone"]').value = option.dataset.phone || '';
                    form.querySelector('[name="address"]').value = option.dataset.address || '';
                    form.querySelector('[name="city"]').value = option.dataset.city || '';
                    form.querySelector('[name="postal_code"]').value = option.dataset.postalCode || '';
                    form.querySelectorAll('[name="phone"], [name="address"], [name="city"], [name="postal_code"]').forEach((input) => {
                        input.dispatchEvent(new Event('input', { bubbles: true }));
                    });
                });
            });

            document.querySelectorAll('[data-razorpay-payment]').forEach((button) => {
                const form = button.closest('[data-checkout-form]');
                const note = form?.querySelector('[data-payment-note]');
                const paymentMethod = form?.querySelector('[data-payment-method]');
                const choices = form ? form.querySelectorAll('[data-payment-choice]') : [];
                const placeOrder = form?.querySelector('[data-place-order]');
                let razorpayOpening = false;

                const hasDeliveryDetails = () => {
                    const fields = ['phone', 'address', 'city', 'postal_code'];

                    return fields.every((name) => {
                        const field = form.querySelector(`[name="${name}"]`);

                        return field?.value.trim() && field.checkValidity();
                    });
                };

                const syncCheckoutState = () => {
                    const choice = form.querySelector('[data-payment-choice]:checked')?.value || '';
                    const isPaidOnline = choice === 'razorpay' && Boolean(form.querySelector('[data-payment-reference]').value);
                    const ready = hasDeliveryDetails() && (choice === 'cod' || isPaidOnline);

                    paymentMethod.value = choice;
                    placeOrder.disabled = !ready;

                    if (!hasDeliveryDetails()) {
                        note.textContent = 'Enter a valid phone, address, city, and 6 digit pincode.';
                    } else if (!choice) {
                        note.textContent = 'Select Pay now online or Cash on delivery.';
                    } else if (choice === 'razorpay' && !isPaidOnline) {
                        note.textContent = 'Opening Razorpay. Use any enabled test payment method shown in the modal.';
                    } else if (choice === 'razorpay') {
                        note.textContent = 'Razorpay payment successful. You can place the order now.';
                    } else {
                        note.textContent = 'Cash on Delivery selected. You can place the order now.';
                    }
                };

                const openRazorpay = async () => {
                    const key = button.dataset.key;

                    syncCheckoutState();

                    if (!hasDeliveryDetails() || paymentMethod.value !== 'razorpay' || form.querySelector('[data-payment-reference]').value || razorpayOpening) {
                        return;
                    }

                    if (!key) {
                        form.querySelector('[data-payment-note]').textContent = 'Add RAZORPAY_KEY_ID in .env to open Razorpay Checkout.';
                        return;
                    }

                    razorpayOpening = true;
                    note.textContent = 'Creating Razorpay order...';

                    let razorpayOrder;

                    try {
                        const response = await fetch(button.dataset.orderUrl, {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            },
                            body: JSON.stringify({}),
                        });

                        razorpayOrder = await response.json();

                        if (!response.ok) {
                            throw new Error(razorpayOrder.message || 'Unable to start Razorpay payment.');
                        }
                    } catch (error) {
                        razorpayOpening = false;
                        note.textContent = error.message || 'Unable to start Razorpay payment.';
                        placeOrder.disabled = true;

                        return;
                    }

                    const checkout = new Razorpay({
                        key,
                        amount: razorpayOrder.amount,
                        currency: razorpayOrder.currency || button.dataset.currency,
                        order_id: razorpayOrder.id,
                        name: button.dataset.name,
                        description: button.dataset.description,
                        prefill: {
                            name: '{{ auth()->user()?->name }}',
                            email: '{{ auth()->user()?->email }}',
                            contact: form.querySelector('[name="phone"]').value,
                        },
                        notes: {
                            address: form.querySelector('[name="address"]').value,
                        },
                        method: {
                            upi: true,
                            card: true,
                            netbanking: true,
                            wallet: true,
                            paylater: true,
                        },
                        theme: {
                            color: '#303221',
                        },
                        handler(response) {
                            form.querySelector('[data-payment-method]').value = 'razorpay';
                            form.querySelector('[data-payment-reference]').value = response.razorpay_payment_id || '';
                            form.querySelector('[data-razorpay-order]').value = response.razorpay_order_id || '';
                            form.querySelector('[data-razorpay-signature]').value = response.razorpay_signature || '';
                            razorpayOpening = false;
                            syncCheckoutState();
                            note.textContent = 'Payment successful. Placing your order...';
                            placeOrder.disabled = true;
                            form.requestSubmit();
                        },
                        modal: {
                            ondismiss() {
                                razorpayOpening = false;
                                form.querySelector('[data-payment-note]').textContent = 'Razorpay checkout closed. Select Pay now again or choose Cash on Delivery.';
                                placeOrder.disabled = true;
                            },
                        },
                    });

                    checkout.open();
                };

                choices.forEach((choice) => {
                    choice.addEventListener('change', () => {
                        form.querySelector('[data-payment-reference]').value = '';
                        form.querySelector('[data-razorpay-order]').value = '';
                        form.querySelector('[data-razorpay-signature]').value = '';
                        syncCheckoutState();

                        if (choice.value === 'razorpay' && choice.checked) {
                            openRazorpay();
                        }
                    });

                    choice.closest('.payment-option')?.addEventListener('click', () => {
                        if (choice.value === 'razorpay' && choice.checked && !form.querySelector('[data-payment-reference]').value) {
                            openRazorpay();
                        }
                    });
                });

                form?.querySelectorAll('[name="phone"], [name="address"], [name="city"], [name="postal_code"]').forEach((field) => {
                    field.addEventListener('input', () => {
                        syncCheckoutState();

                        if (paymentMethod.value === 'razorpay') {
                            openRazorpay();
                        }
                    });
                });

                form?.addEventListener('submit', (event) => {
                    syncCheckoutState();

                    if (placeOrder.disabled) {
                        event.preventDefault();
                    }
                });

                if (form) {
                    syncCheckoutState();
                }
            });
        });
    </script>
</body>
</html>
