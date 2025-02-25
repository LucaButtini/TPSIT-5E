// bundle.js - Funzioni comuni per la gestione del carrello

const CartManager = {
    // Recupera il carrello dal LocalStorage
    getCart: function() {
        return JSON.parse(localStorage.getItem("cart")) || [];
    },

    // Salva il carrello nel LocalStorage
    saveCart: function(cart) {
        localStorage.setItem("cart", JSON.stringify(cart));
    },

    // Aggiunge un prodotto al carrello (aggiorna la quantità se già presente)
    addToCart: function(product, quantity) {
        let cart = this.getCart();
        // Utilizzo di product.code come identificativo univoco
        const productId = product.code;
        const existing = cart.find(item => item.id === productId);
        if (existing) {
            existing.quantity += quantity;
        } else {
            cart.push({
                id: productId,
                name: product.title,
                // Convertiamo il prezzo in numero (assumendo il formato "€xx,xx")
                price: parseFloat(product.price.replace("€", "").replace(",", ".")),
                quantity: quantity,
                image: product.image
            });
        }
        this.saveCart(cart);
        return cart;
    },

    // Aggiorna la quantità di un prodotto nel carrello
    updateQuantity: function(productId, change) {
        let cart = this.getCart();
        const item = cart.find(item => item.id === productId);
        if (item) {
            item.quantity += change;
            if (item.quantity <= 0) {
                cart = cart.filter(i => i.id !== productId);
            }
            this.saveCart(cart);
        }
        return cart;
    },

    // Rimuove un prodotto dal carrello
    removeFromCart: function(productId) {
        let cart = this.getCart();
        cart = cart.filter(item => item.id !== productId);
        this.saveCart(cart);
        return cart;
    }
};

// Se utilizzi moduli ES6, puoi esportare CartManager:
// export { CartManager };
